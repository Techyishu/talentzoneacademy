<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Available user roles.
     */
    public const ROLES = [
        'super_admin' => 'Super Admin',
        'school_admin' => 'School Admin',
        'staff' => 'Staff',
        'student' => 'Student',
        'parent' => 'Parent',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'school_id',
        'staff_id',
        'student_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the school that the user belongs to.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the linked staff record.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Get the linked student record.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the children (for parent users).
     */
    public function children()
    {
        return $this->belongsToMany(Student::class, 'parent_students', 'parent_user_id', 'student_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }

    /**
     * Check if the user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if the user is a school admin.
     */
    public function isSchoolAdmin(): bool
    {
        return $this->role === 'school_admin';
    }

    /**
     * Check if the user is a staff member.
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Check if the user is a student.
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Check if the user is a parent.
     */
    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    /**
     * Get the dashboard route for this user based on role.
     */
    public function getDashboardRoute(): string
    {
        return match ($this->role) {
            'super_admin', 'school_admin' => 'admin.dashboard',
            'staff' => 'staff.dashboard',
            'student' => 'student.dashboard',
            'parent' => 'parent.dashboard',
            default => 'admin.dashboard',
        };
    }

    /**
     * Get the family fee balance for this parent for a given session.
     */
    public function getFamilyBalance(int $sessionId): ?ParentFeeBalance
    {
        if (! $this->isParent()) {
            return null;
        }

        return ParentFeeBalance::where('parent_user_id', $this->id)
            ->where('academic_session_id', $sessionId)
            ->first();
    }

    /**
     * Get the total family dues for this parent for a given session.
     */
    public function getTotalFamilyDues(int $sessionId): float
    {
        $balance = $this->getFamilyBalance($sessionId);

        return $balance ? (float) $balance->balance : 0.0;
    }
}

