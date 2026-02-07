<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'logo',
        'signature_image',
        'receipt_prefix',
        'primary_color',
        'status',
    ];

    /**
     * Get the users for the school.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the students for the school.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the staff for the school.
     */
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    /**
     * Get the fee receipts for the school.
     */
    public function feeReceipts()
    {
        return $this->hasMany(FeeReceipt::class);
    }

    /**
     * Get the gallery images for the school.
     */
    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }

    /**
     * Get the pages for the school.
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
