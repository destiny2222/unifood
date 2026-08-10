<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update B2B products: set discount (discount price) to be 10% higher than price (standard price)
        DB::table('products')
            ->where('is_b2b', 1)
            ->update([
                'discount' => DB::raw('ROUND(price * 1.10, 2)')
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert B2B products' discounts back to 0.00
        DB::table('products')
            ->where('is_b2b', 1)
            ->update([
                'discount' => 0.00
            ]);
    }
};
