<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $fillable = [
        'title_one', 'title_two', 'description', 'status', 'offer_text', 'link', 'image', 'serial'
    ];
}
