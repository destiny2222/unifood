<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'internal_reference',
        'user_id',
        'status',
        'payment_method',
        'total_amount',
        'is_draft',
        'is_recurring',
        'discount_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'is_draft' => 'boolean',
        'is_recurring' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function recurringSchedule()
    {
        return $this->hasOne(RecurringSchedule::class, 'purchase_order_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(B2BShippingAddress::class, 'shipping_address_id');
    }
}
