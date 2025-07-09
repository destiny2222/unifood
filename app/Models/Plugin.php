<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    public $fillable = [ 
        'stripe_public_key',
        'stripe_key_secret',
    ];
}
