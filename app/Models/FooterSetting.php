<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'footer_text','facebook_url','instagram_url','website_url','address','email',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
