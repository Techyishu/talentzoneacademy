<?php

namespace App\Services;

use App\Models\FamilyPaymentAllocation;
use App\Models\FeeReceipt;
use App\Models\ParentFeeBalance;
use App\Models\Student;
use App\Models\StudentFeeBalance;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FamilyFeeService
{
    public function __construct(
        protected FeeBalanceService $feeBalanceService
    ) {
    }

    /**
     * Calculate the family balance for a parent in a given session.
     */
    public function calculateFamilyBalance(User $parent, int $sessionId): array
    {
        if (! $parent->isParent()) {
            throw new \InvalidArgumentException('User is not a parent');
        }

        // Get all children for this parent in the same school
        $children = $parent->children()
            ->where('school_id', $parent->school_id)
            ->with(['schoolClass', 'schoolSection'])
            ->get();

        $totalDue = 0;
        $totalPaid = 0;
        $childrenDetails = [];

        foreach ($children as $child) {
            $balanceSummary = $this->feeBalanceService->getBalanceSummary($child, $sessionId);

            $childBalance = $balanceSummary['total_balance'];

            $totalDue += $balanceSummary['total_due'];
            $totalPaid += $balanceSummary['total_paid'];

            $childrenDetails[] = [
                'id' => $child->id,
                'name' => $child->name,
                'admission_no' => $child->admission_no,
                'class' => $child->schoolClass?->name ?? $child->class,
                'section' => $child->schoolSection?->name ?? $child->section,
                'total_due' => $balanceSummary['total_due'],
                'total_paid' => $balanceSummary['total_paid'],
                'balance' => $childBalance,
            ];
        }

        return [
            'total_due' => $totalDue,
            'total_paid' => $totalPaid,
            'balance' => $totalDue - $totalPaid,
            'children' => $childrenDetails,
            'children_count' => $children->count(),
        ];
    }

    /**
     * Initialize or update the ParentFeeBalance record for a parent.
     */
    public function initializeFamilyBalances(User $parent, int $sessionId): void
    {
        if (! $parent->isParent()) {
            throw new \InvalidArgumentException('User is not a parent');
        }

        $familyBalance = $this->calculateFamilyBalance($parent, $sessionId);

        ParentFeeBalance::updateOrCreate(
            [
                'school_id' => $parent->school_id,
                'parent_user_id' => $parent->id,
                'academic_session_id' => $sessionId,
            ],
            [
                'total_due' => $familyBalance['total_due'],
                'total_paid' => $familyBalance['total_paid'],
                'balance' => $familyBalance['balance'],
            ]
        );
    }

    /**
     * Record a family payment and distribute it across children.
     */
    public function recordFamilyPayment(FeeReceipt $receipt): void
    {
        if (! $receipt->isFamilyPayment()) {
            throw new \InvalidArgumentException('Receipt is not a family payment');
        }

        DB::transaction(function () use ($receipt) {
            $parent = $receipt->parent;
            $sessionId = $receipt->academic_session_id;

            // Get all children
            $children = $parent->children()
                ->where('school_id', $receipt->school_id)
                ->get();

            // Calculate allocations
            $allocations = $this->allocatePaymentProportionally(
                $receipt->amount,
                $children,
                $sessionId
            );

            // Create allocation records and update student balances
            foreach ($allocations as $studentId => $allocatedAmount) {
                if ($allocatedAmount <= 0) {
                    continue;
                }

                // Create allocation record
                FamilyPaymentAllocation::create([
                    'fee_receipt_id' => $receipt->id,
                    'student_id' => $studentId,
                    'allocated_amount' => $allocatedAmount,
                    'allocation_method' => 'proportional',
                ]);

                // Update student's fee balances
                $student = Student::find($studentId);
                $this->updateStudentBalanceFromAllocation($student, $sessionId, $allocatedAmount);
            }

            // Update or create parent fee balance
            $this->recalculateFamilyBalance($parent, $sessionId);
        });
    }

    /**
     * Allocate a payment proportionally across students based on their balances.
     */
    public function allocatePaymentProportionally(float $amount, Collection $students, int $sessionId): array
    {
        $allocations = [];
        $totalBalance = 0;
        $studentBalances = [];

        // Calculate total family balance and individual balances
        foreach ($students as $student) {
            $balanceSummary = $this->feeBalanceService->getBalanceSummary($student, $sessionId);
            $balance = $balanceSummary['total_balance'];

            $studentBalances[$student->id] = $balance;
            $totalBalance += $balance;
        }

        // If total balance is 0, distribute equally
        if ($totalBalance == 0) {
            $equalAmount = $students->count() > 0 ? $amount / $students->count() : 0;
            foreach ($students as $student) {
                $allocations[$student->id] = round($equalAmount, 2);
            }

            return $allocations;
        }

        // Distribute proportionally
        $remainingAmount = $amount;
        $studentsProcessed = 0;

        foreach ($students as $student) {
            $studentsProcessed++;

            // For the last student, allocate all remaining amount to avoid rounding errors
            if ($studentsProcessed === $students->count()) {
                $allocations[$student->id] = round($remainingAmount, 2);
            } else {
                $ratio = $studentBalances[$student->id] / $totalBalance;
                $allocated = round($amount * $ratio, 2);
                $allocations[$student->id] = $allocated;
                $remainingAmount -= $allocated;
            }
        }

        return $allocations;
    }

    /**
     * Update a student's fee balance from a family payment allocation.
     */
    protected function updateStudentBalanceFromAllocation(Student $student, int $sessionId, float $allocatedAmount): void
    {
        // Get all student fee balances for this session
        $feeBalances = StudentFeeBalance::where('student_id', $student->id)
            ->where('academic_session_id', $sessionId)
            ->where('balance', '>', 0)
            ->orderBy('balance', 'desc') // Pay off highest balances first
            ->get();

        $remainingAmount = $allocatedAmount;

        foreach ($feeBalances as $feeBalance) {
            if ($remainingAmount <= 0) {
                break;
            }

            $paymentForThisHead = min($remainingAmount, $feeBalance->balance);

            $feeBalance->total_paid += $paymentForThisHead;
            $feeBalance->balance = $feeBalance->total_due - $feeBalance->total_paid;
            $feeBalance->save();

            $remainingAmount -= $paymentForThisHead;
        }
    }

    /**
     * Recalculate and update the family balance for a parent.
     */
    public function recalculateFamilyBalance(User $parent, int $sessionId): void
    {
        if (! $parent->isParent()) {
            throw new \InvalidArgumentException('User is not a parent');
        }

        $familyBalance = $this->calculateFamilyBalance($parent, $sessionId);

        $parentBalance = ParentFeeBalance::where('parent_user_id', $parent->id)
            ->where('academic_session_id', $sessionId)
            ->where('school_id', $parent->school_id)
            ->first();

        if ($parentBalance) {
            // Update existing balance
            $parentBalance->update([
                'total_due' => $familyBalance['total_due'],
                'total_paid' => $familyBalance['total_paid'],
                'balance' => $familyBalance['balance'],
            ]);
        } else {
            // Create new balance record
            $this->initializeFamilyBalances($parent, $sessionId);
        }
    }
}
