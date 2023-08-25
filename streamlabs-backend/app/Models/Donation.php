<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'donation_user_id',
        'amount',
        'currency',
        'donation_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function donationUser()
    {
        return $this->belongsTo(User::class, 'donation_user_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}