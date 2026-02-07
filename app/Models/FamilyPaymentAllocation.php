<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyPaymentAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_receipt_id',
        'student_id',
        'allocated_amount',
        'allocation_method',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
    ];

    /**
     * Get the fee receipt this allocation belongs to.
     */
    public function feeReceipt(): BelongsTo
    {
        return $this->belongsTo(FeeReceipt::class);
    }

    /**
     * Get the student this allocation is for.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
