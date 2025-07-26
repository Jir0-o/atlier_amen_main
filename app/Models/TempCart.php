<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempCart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'work_id',
        'quantity',
        'work_name',
        'work_image_low',
        // 'unit_price',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function scopeForCurrent($query)
    {
        return $query->where('session_id', session()->getId());
    }

    public function incrementQuantity(int $by = 1): void
    {
        $this->quantity += $by;
        $this->save();
    }
}
