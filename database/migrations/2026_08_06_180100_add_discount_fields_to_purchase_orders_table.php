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
        if (Schema::hasTable('purchase_orders')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                if (!Schema::hasColumn('purchase_orders', 'discount_amount')) {
                    $table->decimal('discount_amount', 12, 2)->default(0.00)->after('payment_method');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchase_orders')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                if (Schema::hasColumn('purchase_orders', 'discount_amount')) {
                    $table->dropColumn('discount_amount');
                }
            });
        }
    }
};
