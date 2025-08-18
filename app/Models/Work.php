<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'work_date',
        'tags',
        'details',
        'art_video',
        'work_type',
        'book_pdf',
        'work_image',
        'work_image_low',
        'image_left',
        'image_left_low',
        'image_right',
        'image_right_low',
        'price',
        'quantity',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'work_date' => 'date',
        'is_active' => 'boolean',
    ];

    /* Relationships */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function gallery()
    {
        return $this->hasMany(WorkGallery::class)->orderBy('sort_order');
    }

    public function variants()
    {
        return $this->hasMany(WorkVariant::class);
    }

    /* Accessor Helpers */
    public function getWorkImageUrlAttribute(): string
    {
        return $this->work_image ? asset($this->work_image) : 'https://via.placeholder.com/300x200?text=Work';
    }
    public function getImageLeftUrlAttribute(): string
    {
        return $this->image_left ? asset($this->image_left) : 'https://via.placeholder.com/150x150?text=Left';
    }
    public function getImageRightUrlAttribute(): string
    {
        return $this->image_right ? asset($this->image_right) : 'https://via.placeholder.com/150x150?text=Right';
    }
}
