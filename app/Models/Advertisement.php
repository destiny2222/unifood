<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    public $fillable = [
        'title', 'image', 'status', 'description',
    ];
}
