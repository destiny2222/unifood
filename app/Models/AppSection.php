<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSection extends Model
{
    protected $fillable = [
       'background_image', 'app_image', 'play_store_link', 'app_store_link', 'title', 'description'
    ];
}
