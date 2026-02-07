<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class SalaryDeduction extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'salary_slip_id',
        'salary_advance_id',
        'type',
        'description',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Deduction types.
     */
    public const TYPES = [
        'advance_recovery' => 'Advance Recovery',
        'pf' => 'Provident Fund',
        'tax' => 'Tax Deduction',
        'leave' => 'Leave Deduction',
        'other' => 'Other',
    ];

    /**
     * Get the salary slip.
     */
    public function salarySlip()
    {
        return $this->belongsTo(SalarySlip::class);
    }

    /**
     * Get the advance if this is an advance recovery.
     */
    public function advance()
    {
        return $this->belongsTo(SalaryAdvance::class, 'salary_advance_id');
    }

    /**
     * Get type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
