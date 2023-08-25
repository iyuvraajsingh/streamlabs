<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sale_user_id',
        'item_id',
        'amount',
        'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function saleUser()
    {
        return $this->belongsTo(User::class, 'sale_user_id');
    }

    public function items()
    {
        return $this->hasOne(Item::class);
    }
}