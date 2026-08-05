<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Kyc extends Model
{

    protected $fillable = [
        'user_id',
        'company_name',
        'company_registration_number',
        'business_type',
        'trade_address',
        'billing_contact',
        'estimated_monthly_order_volume',
        'status',
        'pricing_tier',
        'status_notes',
    ];

    /**
     * Get the user who submitted the KYC application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all users (including buyers) linked to this business account.
     */
    public function authorizedBuyers()
    {
        return $this->hasMany(User::class, 'kyc_id');
    }

    /**
     * Get the discount percentage associated with the pricing tier.
     */
    public function getDiscountPercentage(): float
    {
        switch ($this->pricing_tier) {
            case 'Gold':
                return 30.0;
            case 'Silver':
                return 20.0;
            case 'Bronze':
                return 10.0;
            default:
                return 0.0; // Wholesale Tier 1 has 0% default discount (usually relies on separate B2B products or custom prices)
        }
    }
}
