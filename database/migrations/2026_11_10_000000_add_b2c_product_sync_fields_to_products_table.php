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
        Schema::table('products', function (Blueprint $table) {
            // POS "ProductId" is the stock number/item code used to match products.
            $table->string('stock_number')->nullable()->after('slug')->index();
            $table->string('barcode')->nullable()->after('stock_number');

            $table->decimal('cost_price', 10, 2)->nullable()->after('price');
            $table->string('tax_rate')->nullable()->after('cost_price');
            $table->decimal('cost_inc_tax', 10, 2)->nullable()->after('tax_rate');
            $table->decimal('margin_percent', 10, 6)->nullable()->after('cost_inc_tax');
            $table->decimal('rr_price', 10, 2)->nullable()->after('margin_percent');
            $table->string('bottle_deposit_item_name')->nullable()->after('rr_price');

            $table->string('product_type')->nullable()->after('bottle_deposit_item_name');
            $table->string('size')->nullable()->after('product_type');
            $table->string('colour')->nullable()->after('size');
            $table->decimal('tare_weight', 10, 2)->nullable()->after('colour');
            $table->string('age_restriction')->nullable()->after('tare_weight');

            $table->boolean('is_variable_price')->default(false)->after('age_restriction');
            $table->boolean('tax_exempt_eligible')->default(false)->after('is_variable_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['stock_number']);
            $table->dropColumn([
                'stock_number',
                'barcode',
                'cost_price',
                'tax_rate',
                'cost_inc_tax',
                'margin_percent',
                'rr_price',
                'bottle_deposit_item_name',
                'product_type',
                'size',
                'colour',
                'tare_weight',
                'age_restriction',
                'is_variable_price',
                'tax_exempt_eligible',
            ]);
        });
    }
};
