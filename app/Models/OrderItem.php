<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderItem extends Model
{
    // use HasUuids;
    
     public $fillable = [
        'shipping_addresses_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function order(){
        return $this->belongsTo(ShippingAddress::class);
    }
}
