<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function followers()
    {
        return $this->hasMany(Follower::class);
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function merch_sales()
    {
        return $this->hasMany(MerchSale::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

}
