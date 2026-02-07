<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use BelongsToSchool;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'school_id',
        'staff_code',
        'name',
        'designation',
        'phone',
        'joining_date',
        'salary',
        'status',
        'photo',
        'show_on_website',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2',
        'show_on_website' => 'boolean',
    ];

    /**
     * Scope for staff visible on website.
     */
    public function scopeVisibleOnWebsite($query)
    {
        return $query->where('show_on_website', true)->where('status', 'active');
    }

    /**
     * Get the attendance records for the staff member.
     */
    public function attendances()
    {
        return $this->hasMany(StaffAttendance::class);
    }

    /**
     * Get the user account for this staff member.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the salary slips for the staff member.
     */
    public function salarySlips()
    {
        return $this->hasMany(SalarySlip::class);
    }

    /**
     * Get the salary advances for the staff member.
     */
    public function salaryAdvances()
    {
        return $this->hasMany(SalaryAdvance::class);
    }
}

