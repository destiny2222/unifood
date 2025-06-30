<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ShippingAddress extends Model
{
    // use HasUuids;

    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'address_type',
        'delivery_area_id',
        'user_id'
    ];

    public function deliveryArea()
    {
        return $this->belongsTo(DeliveryArea::class);
    }
}
