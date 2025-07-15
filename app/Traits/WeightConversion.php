<?php

namespace App\Traits;

trait WeightConversion
{
    /**
     * Convert weight to grams
     */
    public function toGrams(float $weight, string $unit): float
    {
        return $unit === 'kg' ? $weight * 1000 : $weight;
    }

    /**
     * Convert weight to kilograms
     */
    public function toKilograms(float $weight, string $unit): float
    {
        return $unit === 'g' ? $weight / 1000 : $weight;
    }
}
