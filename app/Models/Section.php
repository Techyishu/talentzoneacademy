<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'school_id',
        'class_id',
        'name',
    ];

    /**
     * Get the school that owns the section.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the class that this section belongs to.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the students in this section.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }
}
