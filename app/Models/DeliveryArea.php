<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DeliveryArea extends Model
{
    // use HasUuids;
    public $fillable = [
        'minimum_delivery', 'status',  'delivery_fee', 
    ];


}
