<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    public $fillable = [
        'title', 'icon', 'quantity'
    ];
}
