<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionTier extends Model
{

    protected $table = 'subscription_tiers';

    use HasFactory;

    protected $fillable = ['name', 'price', 'currency'];

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}
