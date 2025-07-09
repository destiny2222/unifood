<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    public $fillable = [ 'image', 'short_title', 'long_title', 'description' ]; 
}
