<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists'; 
    protected $fillable = ['user_id', 'session_id', 'work_id'];

    public function work()
    {
        return $this->belongsTo(Work::class, 'work_id');
    }

    /**
     * Merge items for the logged-in user OR the current guest session.
     */
    public function scopeForCurrent($q, ?int $userId = null, ?string $sid = null)
    {
        $userId ??= auth()->id();
        $sid    ??= session()->getId();

        return $q->where(function ($qq) use ($userId, $sid) {
            if ($userId) {
                $qq->where('user_id', $userId);
            }
            $qq->orWhere(function ($q2) use ($sid) {
                $q2->whereNull('user_id')->where('session_id', $sid);
            });
        });
    }

    public static function countForCurrent(): int
    {
        $userId = auth()->id();
        $sid    = session()->getId();

        return static::where(function ($q) use ($userId, $sid) {
            if ($userId) $q->where('user_id', $userId);
            $q->orWhere(function ($qq) use ($sid) {
                $qq->whereNull('user_id')->where('session_id', $sid);
            });
        })->count();
    }
}

