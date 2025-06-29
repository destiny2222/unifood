<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
     public $fillable = [ 
        'title',
        'slug',
        'availability',
        'featured',
        'badge',
        'price',
        'discount',
        'images',
        'status',
        'category_id',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->title);
    }
   
    public function averageRating()

    {

        return $this->reviews->avg('rating');

    }

    public static function calculateDiscount($price, $discount)
    {
        return $discount ? (1 - $price / $discount) * 100 : 0;
    }
    
    // public function carts(){
    //     return $this->hasMany(Cart::class);
    // }

    public  function photos(){
        return $this->hasMany(ProductImage::class);
    }


    // public function reviews()
    // {
    //     return $this->hasMany(ReviewRating::class);
    // }

   

    public function getImagesArrayAttribute(): array
    {
        return $this->images ? explode(',', $this->images) : [];
    }
}
