<?php
namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class Feature
{
    public static function enabled(string $key): bool
    {
        $map = Cache::remember('settings.map', 60, function () {
            return Setting::pluck('value','key')
                ->map(fn ($v) => filter_var($v, FILTER_VALIDATE_BOOL))
                ->toArray();
        });

        // global kill switch
        if (empty($map['shop_enabled'])) {
            return false;
        }

        return (bool) ($map[$key] ?? false);
    }

    public static function clear(): void
    {
        Cache::forget('settings.map');
    }
}