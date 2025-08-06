<?php

namespace App\Traits;

trait WeightConversion
{
    /**
     * Convert weight from grams to kilograms.
     *
     * @param float $grams
     * @return float
     */
    public function convertToKg(float $grams): float
    {
        return $grams / 1000;
    }

    /**
     * Convert weight from kilograms to grams.
     *
     * @param float $kilograms
     * @return float
     */
    public function convertToGrams(float $kilograms): float
    {
        return $kilograms * 1000;
    }

    /**
     * Get the total weight of cart items in kilograms.
     *
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @return float
     */
    public function getTotalWeightInKg(\Illuminate\Database\Eloquent\Collection $cartItems): float
    {
        $totalWeightInKg = 0;

        foreach ($cartItems as $cartItem) {
            $itemWeightInKg = 0;
            if ($cartItem->product->has_variants == 1) {
                $variant = $cartItem->product->variants->where('size', $cartItem->size)->first();
                if ($variant) {
                    $itemWeightInKg = $variant->weight;
                    $unit = $variant->unit;
                    if (strtolower($unit) === 'g') {
                        $itemWeightInKg = $this->convertToKg($itemWeightInKg);
                    }
                }
            } else {
                $itemWeightInKg = $cartItem->product->weight ?? 0;
                $unit = $cartItem->product->unit;
                if (strtolower($unit) === 'g') {
                    $itemWeightInKg = $this->convertToKg($itemWeightInKg);
                }
            }
            $totalWeightInKg += $itemWeightInKg * $cartItem->quantity;
        }

        return $totalWeightInKg;
    }
}
