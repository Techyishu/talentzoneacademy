<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    use BelongsToSchool;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'school_id',
        'staff_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
    ];

    /**
     * Status options for attendance.
     */
    public const STATUSES = [
        'present' => 'Present',
        'absent' => 'Absent',
        'late' => 'Late',
        'leave' => 'Leave',
        'half_day' => 'Half Day',
    ];

    /**
     * Get the staff that this attendance belongs to.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Get the school that this attendance belongs to.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Scope to filter by date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'present' => 'green',
            'absent' => 'red',
            'late' => 'yellow',
            'leave' => 'blue',
            'half_day' => 'orange',
            default => 'gray',
        };
    }

    /**
     * Get formatted check-in time.
     */
    public function getFormattedCheckInAttribute(): ?string
    {
        return $this->check_in ? $this->check_in->format('h:i A') : null;
    }

    /**
     * Get formatted check-out time.
     */
    public function getFormattedCheckOutAttribute(): ?string
    {
        return $this->check_out ? $this->check_out->format('h:i A') : null;
    }
}
