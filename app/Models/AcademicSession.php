<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'school_id',
        'name',
        'start_date',
        'end_date',
        'is_current',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Get the school that owns the academic session.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Scope to get the current academic session for a school.
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Set this session as the current session and unset others.
     */
    public function makeCurrent()
    {
        // Unset all other current sessions for this school
        self::where('school_id', $this->school_id)
            ->where('id', '!=', $this->id)
            ->update(['is_current' => false]);

        // Set this session as current
        $this->is_current = true;
        $this->save();
    }
}
