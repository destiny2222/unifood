<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->title);
    }
    public  function product(){
        return $this->hasMany(Product::class);
    }
    
    
    public $fillable = [
        'title', 'slug','image'
    ];
}
