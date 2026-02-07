<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToSchool
{
    /**
     * Boot the trait to automatically scope queries and set school_id
     */
    protected static function bootBelongsToSchool(): void
    {
        // Automatically add school_id when creating a record
        static::creating(function ($model) {
            if (!$model->school_id && session('active_school_id')) {
                $model->school_id = session('active_school_id');
            }
        });

        // Automatically scope all queries to the active school
        // Only applies if user is NOT a super admin
        static::addGlobalScope('school', function (Builder $query) {
            $user = auth()->user();

            // If user is not super admin and there's an active school, scope the query
            if ($user && $user->role !== 'super_admin' && session('active_school_id')) {
                $query->where('school_id', session('active_school_id'));
            }
        });
    }

    /**
     * Get the school that owns the record
     */
    public function school()
    {
        return $this->belongsTo(\App\Models\School::class);
    }
}
