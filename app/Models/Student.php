<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use BelongsToSchool;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'school_id',
        'admission_no',
        'name',
        'gender',
        'dob',
        'class',
        'section',
        'class_id',
        'section_id',
        'roll_no',
        'guardian_name',
        'guardian_phone',
        'address',
        'photo',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * Get the class that this student belongs to.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the section that this student belongs to.
     */
    public function schoolSection()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Get the fee receipts for the student.
     */
    public function feeReceipts()
    {
        return $this->hasMany(FeeReceipt::class);
    }

    /**
     * Get the attendance records for the student.
     */
    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    /**
     * Get the user account for this student.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the parent users linked to this student.
     */
    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_students', 'student_id', 'parent_user_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }

    /**
     * Get the primary parent (first linked parent).
     */
    public function getPrimaryParent(): ?User
    {
        return $this->parents()->first();
    }

    /**
     * Check if the student has any linked parents.
     */
    public function hasParents(): bool
    {
        return $this->parents()->exists();
    }

    /**
     * Get family members (siblings) - students who share at least one parent.
     */
    public function getFamilyMembers()
    {
        if (! $this->hasParents()) {
            return collect();
        }

        // Get all parent IDs for this student
        $parentIds = $this->parents()->pluck('users.id');

        // Find all students who have any of these parents, excluding this student
        return Student::whereHas('parents', function ($query) use ($parentIds) {
            $query->whereIn('users.id', $parentIds);
        })
            ->where('id', '!=', $this->id)
            ->where('school_id', $this->school_id)
            ->get();
    }
}

