<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JulyBacklogOrdersSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $user = User::create([
                'name' => 'July Backlog Merchant',
                'email' => 'july.merchant@example.com',
                'password' => bcrypt('password'),
            ]);
            $users = collect([$user]);
        }

        $b2bProducts = Product::where('is_b2b', 1)->get();
        if ($b2bProducts->isEmpty()) {
            $b2bProducts = Product::take(10)->get();
        }

        $statuses = ['Submitted', 'Approved', 'Invoiced', 'Completed', 'Completed', 'Completed', 'Cancelled'];
        $paymentMethods = ['invoice_net_30', 'credit_card', 'bank_transfer'];

        // Seed 15 B2B Purchase Orders across July 2026
        for ($i = 1; $i <= 15; $i++) {
            $day = rand(1, 31);
            $createdAt = Carbon::create(2026, 7, $day, rand(8, 18), rand(0, 59));
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

            $po = PurchaseOrder::create([
                'po_number' => 'PO-202607-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'internal_reference' => 'JULY-REF-' . strtoupper(Str::random(6)),
                'user_id' => $user->id,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'total_amount' => 0.00,
                'discount_amount' => rand(0, 1) ? rand(10, 50) : 0.00,
                'is_draft' => false,
                'is_recurring' => (bool) rand(0, 1),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $orderTotal = 0;
            $itemsCount = rand(2, 5);
            $selectedProducts = $b2bProducts->random(min($itemsCount, $b2bProducts->count()));

            foreach ($selectedProducts as $prod) {
                $qty = rand(5, 30);
                $unitPrice = (float) $prod->price;
                $subtotal = $qty * $unitPrice;
                $orderTotal += $subtotal;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $prod->id,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            $po->total_amount = max(0, $orderTotal - $po->discount_amount);
            $po->save();
        }

        // Seed 10 Retail OrderItems across July 2026
        $allProducts = Product::all();
        if ($allProducts->isNotEmpty()) {
            $shippingAddress = \App\Models\ShippingAddress::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'city' => 'London',
                    'state' => 'Greater London',
                    'country' => 'United Kingdom',
                    'postal_code' => 'SW1A 1AA',
                    'address' => '10 July Street',
                    'ship-address' => '10 July Street',
                    'is_default' => 1,
                ]
            );

            for ($j = 1; $j <= 10; $j++) {
                $day = rand(1, 31);
                $createdAt = Carbon::create(2026, 7, $day, rand(8, 20), rand(0, 59));
                $user = $users->random();
                $prod = $allProducts->random();

                OrderItem::create([
                    'invoice_number' => 'INV-202607-' . str_pad($j, 4, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'product_id' => $prod->id,
                    'shipping_addresses_id' => $shippingAddress->id,
                    'quantity' => rand(1, 5),
                    'price' => $prod->price,
                    'payment_method' => 'card',
                    'payment_status' => 1,
                    'order_status' => 1,
                    'delivery_fee' => 5.00,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
