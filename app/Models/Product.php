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
        'is_b2b',
        'minimum_order_quantity',
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

    /**
     * Scope a query to filter products based on user B2B mode.
     */
    public function scopeForUser($query)
    {
        if (auth()->check() && auth()->user()->isB2B()) {
            return $query->where('is_b2b', true);
        }
        return $query->where('is_b2b', false);
    }

    /**
     * Get the volume discounts for the product.
     */
    public function volumeDiscounts()
    {
        return $this->hasMany(VolumeDiscount::class)->orderBy('minimum_quantity', 'asc');
    }

    /**
     * Get the negotiated prices for this product.
     */
    public function negotiatedPrices()
    {
        return $this->hasMany(NegotiatedPrice::class);
    }

    /**
     * Get the resolved price for a specific user and quantity.
     * MOU-210: Pricing Resolution Logic
     */
    public function getResolvedPrice(?User $user = null, int $quantity = 1, ?float $baseVariantPrice = null): float
    {
        $basePrice = $baseVariantPrice !== null ? $baseVariantPrice : (float) $this->price;

        if (!$user || !$user->isB2B()) {
            return $basePrice;
        }

        // 1. Check for Negotiated Price override first
        $negotiatedPrice = $this->negotiatedPrices()->where('user_id', $user->id)->first();
        if ($negotiatedPrice) {
            $tradePrice = (float) $negotiatedPrice->price;
        } else {
            // 2. Base Trade Price based on KYC Tier
            $kyc = $user->kyc;
            $tierDiscountPercentage = $kyc ? $kyc->getDiscountPercentage() : 0;
            
            $tradePrice = $basePrice;
            if ($tierDiscountPercentage > 0) {
                $tradePrice = $basePrice * (1 - ($tierDiscountPercentage / 100));
            }
        }

        // 3. Volume Discounts (applied to either tier trade price or negotiated price)
        $volumeDiscounts = $this->volumeDiscounts;
        $applicableVolumeDiscount = null;

        foreach ($volumeDiscounts as $discount) {
            if ($quantity >= $discount->minimum_quantity) {
                $applicableVolumeDiscount = $discount;
            }
        }

        if ($applicableVolumeDiscount && $applicableVolumeDiscount->discount_percentage > 0) {
            // Apply volume discount percentage to the already discounted trade price
            $tradePrice = $tradePrice * (1 - ($applicableVolumeDiscount->discount_percentage / 100));
        }

        return round($tradePrice, 2);
    }
}
