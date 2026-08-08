<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Kyc extends Model
{

    protected $fillable = [
        'user_id',
        'company_name',
        'trading_name',
        'company_registration_number',
        'vat_registration_number',
        'business_type',
        'date_business_established',
        'nature_of_business',
        'business_website',
        'trade_address',
        'address_line_1',
        'address_line_2',
        'city',
        'postcode',
        'country',
        'billing_contact',
        'primary_contact_name',
        'primary_contact_position',
        'primary_contact_email',
        'primary_contact_phone',
        'preferred_contact_method',
        'owner_full_name',
        'owner_position',
        'owner_nationality',
        'owner_dob',
        'owner_residential_address',
        'certificate_of_incorporation',
        'proof_of_business_address',
        'vat_registration_certificate',
        'business_bank_statement',
        'government_id',
        'proof_of_residential_address',
        'partnership_agreement',
        'sole_trader_evidence',
        'other_documents',
        'primary_products_of_interest',
        'estimated_monthly_order_volume',
        'expected_order_frequency',
        'purpose_of_purchase',
        'status',
        'pricing_tier',
        'status_notes',
        'credit_limit',
        'payment_terms',
    ];

    protected $casts = [
        'date_business_established' => 'date:Y-m-d',
        'owner_dob' => 'date:Y-m-d',
        'other_documents' => 'array',
        'credit_limit' => 'decimal:2',
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
