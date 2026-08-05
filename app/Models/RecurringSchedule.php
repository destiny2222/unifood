<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'kyc_id',
        'frequency',
        'next_run_date',
        'is_active',
    ];

    protected $casts = [
        'next_run_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function purchaseOrderTemplate()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function kyc()
    {
        return $this->belongsTo(Kyc::class);
    }
}
