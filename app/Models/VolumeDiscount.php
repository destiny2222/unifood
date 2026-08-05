<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolumeDiscount extends Model
{
    protected $fillable = [
        'product_id',
        'minimum_quantity',
        'discount_percentage',
    ];

    /**
     * Get the product that owns the volume discount.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
