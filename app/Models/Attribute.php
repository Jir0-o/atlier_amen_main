<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attribute extends Model
{
    protected $fillable = ['name', 'slug'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    // Use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Auto-generate unique slug
    public static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $original = $slug;
        $i = 1;
        while (self::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $original . '-' . $i++;
        }
        return $slug;
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('name')) {
                $model->slug = self::generateUniqueSlug($model->slug ?: $model->name, $model->id ?? null);
            }
        });
    }
}
