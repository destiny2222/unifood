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

    // public function getSlugAttribute(): string
    // {
    //     return Str::slug($this->title);
    // }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('title')) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    public  function product(){
        return $this->hasMany(Product::class);
    }
    
    
    public $fillable = [
        'title', 'slug','image'
    ];
}
