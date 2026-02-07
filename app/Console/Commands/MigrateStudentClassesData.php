<?php

namespace App\Console\Commands;

use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateStudentClassesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:migrate-classes-data {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate student class and section text data to relational model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('Running in DRY RUN mode - no changes will be made');
        }

        $this->info('Starting class and section data migration...');

        // Get all schools
        $schools = School::all();

        foreach ($schools as $school) {
            $this->info("\nProcessing school: {$school->name}");

            // Backup old data first
            if (!$dryRun) {
                $this->info('Backing up old class/section data...');
                Student::where('school_id', $school->id)
                    ->whereNotNull('class')
                    ->update([
                        'class_old' => DB::raw('class'),
                        'section_old' => DB::raw('section'),
                    ]);
            }

            // Get unique classes for this school
            $uniqueClasses = Student::where('school_id', $school->id)
                ->whereNotNull('class')
                ->distinct()
                ->pluck('class')
                ->filter()
                ->values();

            $this->info("Found {$uniqueClasses->count()} unique classes");

            foreach ($uniqueClasses as $displayOrder => $className) {
                $this->line("  - {$className}");

                if (!$dryRun) {
                    // Create or get the class
                    $schoolClass = SchoolClass::firstOrCreate(
                        [
                            'school_id' => $school->id,
                            'name' => $className,
                        ],
                        [
                            'display_order' => $displayOrder,
                        ]
                    );

                    // Get unique sections for this class
                    $uniqueSections = Student::where('school_id', $school->id)
                        ->where('class', $className)
                        ->whereNotNull('section')
                        ->distinct()
                        ->pluck('section')
                        ->filter()
                        ->values();

                    if ($uniqueSections->count() > 0) {
                        $this->info("    Found {$uniqueSections->count()} sections for {$className}");

                        foreach ($uniqueSections as $sectionName) {
                            $this->line("      - {$sectionName}");

                            // Create or get the section
                            $section = Section::firstOrCreate([
                                'school_id' => $school->id,
                                'class_id' => $schoolClass->id,
                                'name' => $sectionName,
                            ]);

                            // Update students with this class and section
                            $updated = Student::where('school_id', $school->id)
                                ->where('class', $className)
                                ->where('section', $sectionName)
                                ->update([
                                    'class_id' => $schoolClass->id,
                                    'section_id' => $section->id,
                                ]);

                            $this->line("        Updated {$updated} students");
                        }
                    }

                    // Update students with only class (no section)
                    $updatedClassOnly = Student::where('school_id', $school->id)
                        ->where('class', $className)
                        ->whereNull('section_id')
                        ->update([
                            'class_id' => $schoolClass->id,
                        ]);

                    if ($updatedClassOnly > 0) {
                        $this->line("    Updated {$updatedClassOnly} students without section");
                    }
                }
            }
        }

        if ($dryRun) {
            $this->info("\nDRY RUN completed - no changes were made");
            $this->info("Run without --dry-run to apply changes");
        } else {
            $this->info("\nMigration completed successfully!");

            // Show summary
            $totalStudents = Student::count();
            $studentsWithClass = Student::whereNotNull('class_id')->count();
            $studentsWithSection = Student::whereNotNull('section_id')->count();

            $this->table(
                ['Metric', 'Count'],
                [
                    ['Total Students', $totalStudents],
                    ['Students with Class', $studentsWithClass],
                    ['Students with Section', $studentsWithSection],
                    ['Total Classes', SchoolClass::count()],
                    ['Total Sections', Section::count()],
                ]
            );
        }

        return 0;
    }
}
