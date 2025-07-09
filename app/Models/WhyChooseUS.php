<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUS extends Model
{
    public $fillable = [ 
        'background_image', 
        'image_one',
        'image_two', 
        'short_title',
        'long_title',
        'status', 
        'description' ,
        'title_one',
        'icon_one',
        'title_two',
        'icon_two',
        'title_three',
        'icon_three',
        'title_four',
        'icon_four',
    ];
}
