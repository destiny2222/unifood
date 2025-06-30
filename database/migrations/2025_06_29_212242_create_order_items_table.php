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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_addresses_id')->constrained('shipping_addresses')->cascadeDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeDelete();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->boolean('payment_status')->default(false);
            $table->string('invoice_number')->nullable();
            $table->boolean('order_status')->default(false);
            $table->string('payment_method')->nullable();
            $table->foreignUuid('user_id')->constrained('users')->cascadeDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
