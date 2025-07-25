<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ShippingAddress extends Model
{
    // use HasUuids;

    public $fillable = [
        'city',
        'state',
        'country',
        'postal_code',
        'address',
        'is_default',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    

    public function orders(){
        return $this->hasMany(OrderItem::class, 'shipping_addresses_id');
    }
}
