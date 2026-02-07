<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeHead extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'school_id',
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the school that owns the fee head.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the fee structures for this fee head.
     */
    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }

    /**
     * Scope a query to only include active fee heads.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
