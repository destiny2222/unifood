<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\VolumeDiscount;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class B2BDemoProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create or get some demo categories for B2B
        $categories = collect([
            'Wholesale Produce',
            'Bulk Dairy',
            'Restaurant Pantry',
            'Commercial Meats',
            'Bulk Beverages',
            'Catering Supplies'
        ])->map(function ($name) {
            return Category::firstOrCreate([
                'title' => $name,
            ], [
                'slug' => Str::slug($name)
            ]);
        });

        $units = ['kg', 'lbs', 'pack', 'box', 'pallet', 'case'];
        $badges = ['Bulk Deal', 'Hot', 'New', 'Trade Only', null, null];

        $productTitles = [
            'Commercial Cooking Oil 20L',
            'Wholesale Flour 50kg',
            'Premium Arabica Beans 10kg',
            'Bulk Mozzarella Cheese Block',
            'Wholesale Tomato Paste Case',
            'Farm Fresh Eggs 144ct',
            'Commercial Sugar Sack 25kg',
            'Wholesale Chicken Breasts 10kg',
            'Catering Napkins 1000ct',
            'Bulk Basmati Rice 20kg',
            'Commercial Salt 25kg',
            'Wholesale Beef Mince 5kg',
            'Bulk Ketchup Dispenser Box',
            'Commercial Soy Sauce 5L',
            'Wholesale Frozen Chips 15kg',
        ];

        foreach ($productTitles as $title) {
            $basePrice = $faker->randomFloat(2, 20, 200);
            
            $mainImage = 'https://grostore.themetags.com/public/uploads/media/BR4qSOjlbLlMcfi9BSZXATSha6EyVHs4P53MpY6v.png';

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'description' => $faker->paragraph(3) . ' Perfect for restaurants and catering businesses.',
                    'price' => $basePrice,
                    'discount' => null, // Typically no direct discount, handled via tiers/volume
                    'unit' => $faker->randomElement($units),
                    'weight' => $faker->randomFloat(2, 5, 50),
                    'status' => 'active',
                    'availability' => 'in_stock',
                    'featured' => $faker->boolean(20),
                    'today_special' => $faker->boolean(10),
                    'has_variants' => 0,
                    'is_b2b' => true,
                    'minimum_order_quantity' => $faker->randomElement([5, 10, 20, 50]),
                    'badge' => $faker->randomElement($badges),
                    'category_id' => $categories->random()->id,
                    'images' => $mainImage,
                ]
            );

            // Create ProductImage records for the B2B product
            \App\Models\ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'image_path' => $mainImage,
            ]);

            \App\Models\ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'image_path' => fake()->imageUrl(width: 640, height: 480),
            ]);

            // Add Volume Discounts for this B2B product
            // e.g., 5% off for 20+ units, 10% off for 50+ units, 15% off for 100+ units
            $tiers = [
                ['min' => 20, 'discount' => 5.0],
                ['min' => 50, 'discount' => 10.0],
                ['min' => 100, 'discount' => 15.0],
            ];

            foreach ($tiers as $tier) {
                // Only add tier if it's greater than the MOQ
                if ($tier['min'] > $product->minimum_order_quantity) {
                    VolumeDiscount::updateOrCreate([
                        'product_id' => $product->id,
                        'minimum_quantity' => $tier['min'],
                    ], [
                        'discount_percentage' => $tier['discount'],
                    ]);
                }
            }
        }
        
        $this->command->info('B2B Demo Products and Volume Discounts seeded successfully!');
    }
}
