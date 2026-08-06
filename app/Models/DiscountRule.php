<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{
    protected $fillable = [
        'min_amount',
        'discount_percentage',
        'max_discount_amount',
        'is_active',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Calculate checkout discount for the given subtotal.
     * Returns array with discount details.
     */
    public static function calculateDiscount($subtotal)
    {
        $rule = self::where('is_active', true)
            ->where('min_amount', '<=', $subtotal)
            ->orderBy('min_amount', 'desc')
            ->first();

        if (!$rule) {
            return [
                'rule_id' => null,
                'discount_amount' => 0.00,
                'discount_percentage' => 0.00,
            ];
        }

        $discountAmount = $subtotal * ($rule->discount_percentage / 100.0);
        if ($rule->max_discount_amount > 0) {
            $discountAmount = min($discountAmount, (float) $rule->max_discount_amount);
        }

        return [
            'rule_id' => $rule->id,
            'discount_amount' => round($discountAmount, 2),
            'discount_percentage' => (float) $rule->discount_percentage,
        ];
    }
}
