<?php

namespace App\Traits;

use App\Models\ShippingRate;

trait ShippingCost
{
   public function getShippingRates($weight)
{
    // First, try to get rates matching the weight range
    $rates = ShippingRate::where('min_weight', '<=', $weight)
        ->where('max_weight', '>=', $weight)
        ->get();

    if ($rates->count()) {
        return $rates;
    }

    // If weight exceeds all ranges, get the highest max_weight value
    $highestMax = ShippingRate::max('max_weight');

    return ShippingRate::where('max_weight', $highestMax)->get();
}

}
