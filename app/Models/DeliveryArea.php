<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DeliveryArea extends Model
{
    // use HasUuids;
    public $fillable = [
       'area_name', 'minimum_delivery_time', 'status', 'maximum_delivery_time', 'delivery_fee', 'slug'
    ];

    public function shippingAddress(){
        return $this->hasMany(ShippingAddress::class);
    }

}
