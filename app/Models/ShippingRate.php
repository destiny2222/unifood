<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = [
        'min_weight', 'max_weight', 'delivery_type', 'price'
    ];
}
