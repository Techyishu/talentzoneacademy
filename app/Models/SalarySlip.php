<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'staff_id',
        'slip_no',
        'month',
        'year',
        'basic_salary',
        'allowances',
        'gross_salary',
        'total_deductions',
        'net_salary',
        'payment_date',
        'payment_mode',
        'payment_reference',
        'status',
        'notes',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Get the staff member for this salary slip.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Get the deductions for this salary slip.
     */
    public function deductions()
    {
        return $this->hasMany(SalaryDeduction::class);
    }

    /**
     * Get the month name.
     */
    public function getMonthNameAttribute(): string
    {
        return date('F', mktime(0, 0, 0, $this->month, 1));
    }

    /**
     * Get formatted period.
     */
    public function getPeriodAttribute(): string
    {
        return $this->month_name . ' ' . $this->year;
    }

    /**
     * Generate unique slip number.
     */
    public static function generateSlipNo(int $schoolId): string
    {
        $prefix = 'SAL';
        $year = date('Y');
        $month = date('m');

        $lastSlip = static::where('school_id', $schoolId)
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastSlip ? (intval(substr($lastSlip->slip_no, -4)) + 1) : 1;

        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
