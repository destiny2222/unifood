<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    public $fillable = [ 'existing_image', 'product_image', 'name','designation','status', 'description' ];
}
