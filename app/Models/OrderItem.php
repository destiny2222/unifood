<?php

namespace App\Models;

use App\Traits\WeightConversion;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderItem extends Model
{
    use WeightConversion;
    // use HasUuids;
    
     public $fillable = [
        'shipping_addresses_id',
        'product_id',
        'quantity',
        'invoice_number',
        'payment_method',
        'price',
        'payment_status',
        'order_status',
        'user_id',
        'delivery_fee',
        'size',
        'totalWeight',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


    public function shippingAddress(){
        return $this->belongsTo(ShippingAddress::class, 'shipping_addresses_id');
    }

    public function getTotalWeightAttribute()
    {
        $itemWeight = 0;
        $unit = '';

        if ($this->product->has_variants == 1) {
            $variant = $this->product->variants->where('size', $this->size)->first();
            if ($variant) {
                $itemWeight = $variant->weight;
                $unit = $variant->unit;
            }
        } else {
            $itemWeight = $this->product->weight ?? 0;
            $unit = $this->product->unit;
        }

        if (strtolower($unit) === 'g') {
            return $this->convertToKg($itemWeight) * $this->quantity;
        }

        if (strtolower($unit) === 'kg') {
            return $itemWeight * $this->quantity;
        }

        return 0;
    }

    public static function generateInvoiceNumber()
    {
        $latest = self::latest()->first();
        if (!$latest) {
            return 'INV-0001';
        }
        $string = preg_replace("/[^0-9]/", '', $latest->invoice_number);
        $number = (int) $string; // Cast to integer
        return 'INV-' . sprintf('%04d', $number + 1);
    }
}
