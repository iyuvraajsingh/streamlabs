<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscriber_id',
        'subscription_tier',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(User::class, 'subscriber_id');
    }

    public function subscriptionTier()
    {
        return $this->belongsTo(SubscriptionTier::class);
    }
}