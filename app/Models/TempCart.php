<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempCart extends Model
{
    protected $table = 'temp_carts'; 
    protected $fillable = [
        'user_id','session_id','work_id','quantity','work_name','work_image_low',
        'work_variant_id','variant_text','unit_price',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class, 'work_id');
    }

    public function workVariant()
    {
        return $this->belongsTo(WorkVariant::class, 'work_variant_id');
    }

    /**
     * Merge cart rows for user OR session (guest).
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

    public function incrementQuantity(int $by = 1): void
    {
        $this->quantity += $by;
        $this->save();
    }
}

