<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name', 'slug', 'description', 'parent_id', 'is_active', 'category_image', 'image_left', 'image_right'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // helpers
    public function getCategoryImageUrlAttribute(): ?string
    {
        return $this->category_image ? asset($this->category_image) : null;
    }
    public function getImageLeftUrlAttribute(): ?string
    {
        return $this->image_left ? asset($this->image_left) : null;
    }
    public function getImageRightUrlAttribute(): ?string
    {
        return $this->image_right ? asset($this->image_right) : null;
    }

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
