<?php

namespace App\Services;

use App\Models\FeeReceipt;
use App\Models\FeeStructure;
use App\Models\Student;
use App\Models\StudentFeeBalance;
use Illuminate\Support\Facades\DB;

class FeeBalanceService
{
    /**
     * Calculate total dues for a student for a given session.
     */
    public function calculateDues(Student $student, int $sessionId): array
    {
        $dues = [];

        if (!$student->class_id) {
            return $dues;
        }

        // Get fee structures for this student's class and session
        $feeStructures = FeeStructure::where('academic_session_id', $sessionId)
            ->where('class_id', $student->class_id)
            ->with('feeHead')
            ->get();

        foreach ($feeStructures as $structure) {
            $dues[$structure->fee_head_id] = [
                'fee_head' => $structure->feeHead,
                'amount' => $structure->amount,
                'frequency' => $structure->frequency,
            ];
        }

        return $dues;
    }

    /**
     * Get balance summary for a student for a given session.
     */
    public function getBalanceSummary(Student $student, int $sessionId): array
    {
        $balances = StudentFeeBalance::where('student_id', $student->id)
            ->where('academic_session_id', $sessionId)
            ->with('feeHead')
            ->get()
            ->keyBy('fee_head_id');

        $summary = [];
        $totalDue = 0;
        $totalPaid = 0;
        $totalBalance = 0;

        // Get expected dues
        $dues = $this->calculateDues($student, $sessionId);

        foreach ($dues as $feeHeadId => $dueInfo) {
            $balance = $balances->get($feeHeadId);

            $due = $balance ? $balance->total_due : $dueInfo['amount'];
            $paid = $balance ? $balance->total_paid : 0;
            $remaining = $balance ? $balance->balance : $due;

            $summary[] = [
                'fee_head_id' => $feeHeadId,
                'fee_head' => $dueInfo['fee_head'],
                'total_due' => $due,
                'total_paid' => $paid,
                'balance' => $remaining,
                'frequency' => $dueInfo['frequency'],
            ];

            $totalDue += $due;
            $totalPaid += $paid;
            $totalBalance += $remaining;
        }

        return [
            'items' => $summary,
            'total_due' => $totalDue,
            'total_paid' => $totalPaid,
            'total_balance' => $totalBalance,
        ];
    }

    /**
     * Initialize balances for a student for a given session.
     */
    public function initializeBalances(Student $student, int $sessionId): void
    {
        $dues = $this->calculateDues($student, $sessionId);

        foreach ($dues as $feeHeadId => $dueInfo) {
            StudentFeeBalance::firstOrCreate(
                [
                    'school_id' => $student->school_id,
                    'student_id' => $student->id,
                    'academic_session_id' => $sessionId,
                    'fee_head_id' => $feeHeadId,
                ],
                [
                    'total_due' => $dueInfo['amount'],
                    'total_paid' => 0,
                    'balance' => $dueInfo['amount'],
                ]
            );
        }
    }

    /**
     * Record a payment and update balances.
     */
    public function recordPayment(FeeReceipt $receipt): void
    {
        if (!$receipt->academic_session_id) {
            return;
        }

        DB::transaction(function () use ($receipt) {
            // Initialize balances if not already done
            $this->initializeBalances($receipt->student, $receipt->academic_session_id);

            // Update balances for each receipt item
            foreach ($receipt->items as $item) {
                $balance = StudentFeeBalance::where([
                    'student_id' => $receipt->student_id,
                    'academic_session_id' => $receipt->academic_session_id,
                    'fee_head_id' => $item->fee_head_id,
                ])->first();

                if ($balance) {
                    $balance->total_paid += $item->amount;
                    $balance->balance = $balance->total_due - $balance->total_paid;
                    $balance->save();
                }
            }
        });
    }

    /**
     * Reverse a payment (for cancellations).
     */
    public function reversePayment(FeeReceipt $receipt): void
    {
        if (!$receipt->academic_session_id) {
            return;
        }

        DB::transaction(function () use ($receipt) {
            foreach ($receipt->items as $item) {
                $balance = StudentFeeBalance::where([
                    'student_id' => $receipt->student_id,
                    'academic_session_id' => $receipt->academic_session_id,
                    'fee_head_id' => $item->fee_head_id,
                ])->first();

                if ($balance) {
                    $balance->total_paid -= $item->amount;
                    $balance->balance = $balance->total_due - $balance->total_paid;
                    $balance->save();
                }
            }
        });
    }

    /**
     * Generate monthly fees for a student for a given session and month.
     * Converts fee structure amounts to monthly based on frequency.
     */
    public function generateMonthlyFees(Student $student, int $sessionId, int $month): void
    {
        if (!$student->class_id) {
            return;
        }

        // Get fee structures for this student's class and session
        $feeStructures = FeeStructure::where('academic_session_id', $sessionId)
            ->where('class_id', $student->class_id)
            ->with('feeHead')
            ->get();

        foreach ($feeStructures as $structure) {
            // Calculate monthly amount based on frequency
            $monthlyAmount = match ($structure->frequency) {
                'monthly' => $structure->amount,
                'quarterly' => round($structure->amount / 3, 2),
                'annual' => round($structure->amount / 12, 2),
                default => $structure->amount,
            };

            // Create or update student fee balance (idempotent)
            StudentFeeBalance::firstOrCreate(
                [
                    'school_id' => $student->school_id,
                    'student_id' => $student->id,
                    'academic_session_id' => $sessionId,
                    'fee_head_id' => $structure->fee_head_id,
                ],
                [
                    'total_due' => $monthlyAmount,
                    'total_paid' => 0,
                    'balance' => $monthlyAmount,
                ]
            );
        }
    }
}
