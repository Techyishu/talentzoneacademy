<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class FeeReceipt extends Model
{
    use BelongsToSchool;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'school_id',
        'student_id',
        'receipt_no',
        'transaction_type',
        'payment_type',
        'parent_user_id',
        'academic_session_id',
        'amount',
        'payment_mode',
        'payment_date',
        'fee_month',
        'remarks',
        'cancelled',
        'cancelled_at',
        'cancelled_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'cancelled' => 'boolean',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the student that owns the fee receipt.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the academic session for this receipt.
     */
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    /**
     * Get the items for this receipt.
     */
    public function items()
    {
        return $this->hasMany(FeeReceiptItem::class);
    }

    /**
     * Get the user who cancelled the receipt.
     */
    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Get the parent user for family payments.
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    /**
     * Get the family payment allocations for this receipt.
     */
    public function familyAllocations()
    {
        return $this->hasMany(FamilyPaymentAllocation::class);
    }

    /**
     * Check if this is a family payment.
     */
    public function isFamilyPayment(): bool
    {
        return $this->payment_type === 'family';
    }
}
