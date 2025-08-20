<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmailContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, MustVerifyEmail, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'first_name', 'last_name', 'email','country','username','phone','date_of_birth','password',
        'photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user's wishlist.
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the user's cart.
     */
    public function cart()
    {
        return $this->hasMany(TempCart::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(Address::class)->where('type','shipping');
    }
    public function billingAddress()
    {
        return $this->hasOne(Address::class)->where('type','billing');
    }
}
