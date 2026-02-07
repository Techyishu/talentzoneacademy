<?php

namespace App\Console\Commands;

use App\Models\AcademicSession;
use App\Models\Student;
use App\Models\User;
use App\Services\FamilyFeeService;
use App\Services\FeeBalanceService;
use Illuminate\Console\Command;

class GenerateMonthlyFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fees:generate-monthly
                            {session_id : The academic session ID}
                            {month : The month number (1-12)}
                            {--school_id= : Optional school ID to limit generation to specific school}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly fees for all students in a given academic session';

    protected FeeBalanceService $feeBalanceService;
    protected FamilyFeeService $familyFeeService;

    public function __construct(FeeBalanceService $feeBalanceService, FamilyFeeService $familyFeeService)
    {
        parent::__construct();
        $this->feeBalanceService = $feeBalanceService;
        $this->familyFeeService = $familyFeeService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sessionId = $this->argument('session_id');
        $month = $this->argument('month');
        $schoolId = $this->option('school_id');

        // Validate month
        if ($month < 1 || $month > 12) {
            $this->error('Month must be between 1 and 12');
            return 1;
        }

        // Get the session
        $session = AcademicSession::find($sessionId);
        if (!$session) {
            $this->error("Academic session with ID {$sessionId} not found");
            return 1;
        }

        $this->info("Generating monthly fees for {$session->name} - Month {$month}");
        $this->newLine();

        // Get students query
        $studentsQuery = Student::where('status', 'active')
            ->where('academic_session_id', $sessionId);

        // Filter by school if provided
        if ($schoolId) {
            $studentsQuery->where('school_id', $schoolId);
            $this->info("Filtering to school ID: {$schoolId}");
        }

        $students = $studentsQuery->get();

        if ($students->isEmpty()) {
            $this->warn('No active students found for this session');
            return 0;
        }

        $this->info("Found {$students->count()} active students");
        $this->newLine();

        // Progress bar
        $progressBar = $this->output->createProgressBar($students->count());
        $progressBar->start();

        $successCount = 0;
        $skippedCount = 0;
        $errors = [];

        // Generate fees for each student
        foreach ($students as $student) {
            try {
                if ($student->class_id) {
                    $this->feeBalanceService->generateMonthlyFees($student, $sessionId, $month);
                    $successCount++;
                } else {
                    $skippedCount++;
                }
            } catch (\Exception $e) {
                $errors[] = "Student {$student->admission_no} ({$student->name}): {$e->getMessage()}";
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Recalculate family balances for all parents
        $this->info('Recalculating family balances for parents...');

        $parents = User::where('role', 'parent')
            ->whereHas('children')
            ->get();

        foreach ($parents as $parent) {
            try {
                $this->familyFeeService->recalculateFamilyBalance($parent, $sessionId);
            } catch (\Exception $e) {
                $this->warn("Failed to recalculate balance for parent {$parent->name}: {$e->getMessage()}");
            }
        }

        // Summary
        $this->newLine();
        $this->info('=== Generation Summary ===');
        $this->info("✓ Successfully generated fees for {$successCount} students");

        if ($skippedCount > 0) {
            $this->warn("⚠ Skipped {$skippedCount} students (no class assigned)");
        }

        if (!empty($errors)) {
            $this->error("✗ Errors encountered: " . count($errors));
            foreach ($errors as $error) {
                $this->error("  - {$error}");
            }
            return 1;
        }

        $this->info('Monthly fee generation completed successfully!');
        return 0;
    }
}
