<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'kyc_id',
        'user_id',
        'status',
        'delivery_frequency',
        'notes',
        'valid_until',
        'terms',
        'total_amount',
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function kyc()
    {
        return $this->belongsTo(Kyc::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(RfqItem::class);
    }

    /**
     * Scope a query to only include pending RFQs.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }
}
