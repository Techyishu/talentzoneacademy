<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class SalaryAdvance extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'staff_id',
        'amount',
        'advance_date',
        'reason',
        'status',
        'recovered_amount',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'recovered_amount' => 'decimal:2',
        'advance_date' => 'date',
    ];

    /**
     * Get the staff member for this advance.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Get the deductions linked to this advance.
     */
    public function deductions()
    {
        return $this->hasMany(SalaryDeduction::class);
    }

    /**
     * Get pending balance.
     */
    public function getPendingBalanceAttribute(): float
    {
        return $this->amount - $this->recovered_amount;
    }

    /**
     * Check if fully recovered.
     */
    public function getIsRecoveredAttribute(): bool
    {
        return $this->recovered_amount >= $this->amount;
    }
}
