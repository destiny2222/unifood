<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DeliveryArea extends Model
{
    // use HasUuids;
    public $fillable = [
    //    'delivery_area',
        'delivery_area_name', 'minimum_delivery_time', 'status', 'maximum_delivery_time', 'delivery_fee', 'slug'
    ];

    public function shippingAddress(){
        return $this->hasMany(ShippingAddress::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->area_name);
    }

}
