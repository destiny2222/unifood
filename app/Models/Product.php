<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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
        'today_special',
        'images',
        'weight',
        'unit',
        'has_variants',
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

    // public function getSlugAttribute(): string
    // {
    //     return Str::slug($this->title);
    // }

    //  protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($product) {
    //         if (empty($product->slug)) {
    //             $product->slug = static::generateUniqueSlug($product->title);
    //         }
    //     });
    // }

    // public static function generateUniqueSlug($title)
    // {
    //     $baseSlug = Str::slug($title);
    //     $slug = $baseSlug;
    //     $counter = 1;

    //     while (static::where('slug', $slug)->exists()) {
    //         $slug = $baseSlug . '-' . $counter;
    //         $counter++;
    //     }

    //     return $slug;
    // }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
            // ->doNotGenerateSlugsOnUpdate();
    }


    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    

   
    // public function averageRating()

    // {

    //     return $this->reviews->avg('rating');

    // }

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


    public function reviews()
    {
        return $this->hasMany(ReviewRating::class);
    }

   

    public function getImagesArrayAttribute(): array
    {
        return $this->images ? explode(',', $this->images) : [];
    }
}
