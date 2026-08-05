<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'delivery_fee')) {
                    $table->decimal('delivery_fee', 10, 2)->default(0);
                }
                if (!Schema::hasColumn('order_items', 'size')) {
                    $table->string('size')->nullable();
                }
                if (!Schema::hasColumn('order_items', 'shipping_delivery_type')) {
                    $table->string('shipping_delivery_type')->nullable();
                }
                if (!Schema::hasColumn('order_items', 'shipping_price')) {
                    $table->decimal('shipping_price', 8, 2)->default(0);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Left empty as these columns are expected to exist in the main schema.
    }
};
