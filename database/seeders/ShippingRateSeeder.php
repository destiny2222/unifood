<?php

namespace Database\Seeders;

use App\Models\ShippingRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rates = [
            [0, 2, 'next_day', 13.45],
            [0, 2, 'next_morning', 4.29],
            [0, 2, 'two_days', 3.45],
            [5, 10, 'next_day', 18.35],
            [5, 10, 'next_morning', 7.95],
            [5, 10, 'two_days', 6.85],
            [11, 20, 'next_day', 22.55],
            [11, 20, 'next_morning', 12.60],
            [11, 20, 'two_days', 9.80],
        ];

        foreach ($rates as $rate) {
            ShippingRate::create([
                'min_weight' => $rate[0],
                'max_weight' => $rate[1],
                'delivery_type' => $rate[2],
                'price' => $rate[3],
            ]);
        }
    }
}
