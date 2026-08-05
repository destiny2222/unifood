<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable , HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'profile_picture',
        'phone',
        'kyc_id',
        'is_business_owner',
        'current_view',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the associated B2B KYC record.
     */
    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'kyc_id');
    }

    /**
     * Determine if the user is in B2B view mode with an approved KYC trade account.
     */
    public function isB2B(): bool
    {
        return $this->kyc_id && 
               $this->current_view === 'business' && 
               $this->kyc && 
               $this->kyc->status === 'approved';
    }

    /**
     * Determine if the user is in B2B view mode with a pending KYC application.
     */
    public function isPendingB2B(): bool
    {
        return $this->kyc_id && 
               $this->current_view === 'business' && 
               $this->kyc && 
               ($this->kyc->status === 'pending' || $this->kyc->status === 'info_requested');
    }

    /**
     * Determine if the user's KYC application is rejected in business view.
     */
    public function isB2BRejected(): bool
    {
        return $this->kyc_id && 
               $this->current_view === 'business' && 
               $this->kyc && 
               $this->kyc->status === 'rejected';
    }

    public function shippingAddresses() {
        return $this->hasMany(ShippingAddress::class);
    }

    public function defaultAddress() {
        return $this->hasOne(ShippingAddress::class)->where('is_default', true);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
