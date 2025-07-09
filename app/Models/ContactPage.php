<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
   
    protected $fillable = [
        'existing_image',
        'email',
        'phone',
        'address',
        'map',
        'status',
    ];
}
