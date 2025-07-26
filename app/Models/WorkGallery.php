<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkGallery extends Model
{
    protected $fillable = [
        'work_id',
        'image_path',
        'image_path_low',
        'sort_order',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function getImageUrlAttribute(): string
    {
        return asset($this->image_path);
    }
}
