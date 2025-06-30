<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderItem extends Model
{
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
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function order(){
        return $this->belongsTo(ShippingAddress::class);
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
