<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeeBalance extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'school_id',
        'student_id',
        'academic_session_id',
        'fee_head_id',
        'total_due',
        'total_paid',
        'balance',
    ];

    protected $casts = [
        'total_due' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    /**
     * Get the school that owns the balance.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the student for this balance.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the academic session for this balance.
     */
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    /**
     * Get the fee head for this balance.
     */
    public function feeHead()
    {
        return $this->belongsTo(FeeHead::class);
    }

    /**
     * Scope a query to only include balances with outstanding dues.
     */
    public function scopeWithDues($query)
    {
        return $query->where('balance', '>', 0);
    }
}
