<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'background_image',
        'user_image',
        'poem',
    ];

    // Accessor for image URLs
    public function getBackgroundImageUrlAttribute(): string
    {
        return $this->background_image
            ? asset('storage/' . $this->background_image)
            : 'https://via.placeholder.com/600x400?text=Background';
    }

    public function getUserImageUrlAttribute(): string
    {
        return $this->user_image
            ? asset('storage/' . $this->user_image)
            : 'https://via.placeholder.com/150?text=User+Image';
    }
}
