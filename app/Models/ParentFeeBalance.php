<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentFeeBalance extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'school_id',
        'parent_user_id',
        'academic_session_id',
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
     * Get the parent user that owns this fee balance.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    /**
     * Get the academic session this balance is for.
     */
    public function academicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class);
    }

    /**
     * Get the school this balance belongs to.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Scope to get only balances with dues (balance > 0).
     */
    public function scopeWithDues($query)
    {
        return $query->where('balance', '>', 0);
    }

    /**
     * Get all children (students) linked to this parent.
     */
    public function getChildren()
    {
        return $this->parent->children()
            ->where('school_id', $this->school_id)
            ->get();
    }
}
