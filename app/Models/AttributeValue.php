<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AttributeValue extends Model
{
    protected $fillable = ['attribute_id', 'value', 'slug'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function generateUniqueSlug($value, $ignoreId = null)
    {
        $slug = Str::slug($value);
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
            if (empty($model->slug) || $model->isDirty('value')) {
                $model->slug = self::generateUniqueSlug($model->slug ?: $model->value, $model->id ?? null);
            }
        });
    }
}

