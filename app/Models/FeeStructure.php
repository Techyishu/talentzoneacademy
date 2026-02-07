<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'school_id',
        'academic_session_id',
        'class_id',
        'fee_head_id',
        'amount',
        'frequency',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the school that owns the fee structure.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the academic session for this fee structure.
     */
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    /**
     * Get the class for this fee structure.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the fee head for this fee structure.
     */
    public function feeHead()
    {
        return $this->belongsTo(FeeHead::class);
    }
}
