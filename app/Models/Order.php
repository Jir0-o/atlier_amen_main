<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_qty',
        'subtotal',
        'shipping_charge',
        'grand_total',
        'ship_fname','ship_lname','ship_address','ship_city','ship_state','ship_zip','ship_country',
        'bill_fname','bill_lname','bill_address','bill_city','bill_state','bill_zip','bill_country',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
