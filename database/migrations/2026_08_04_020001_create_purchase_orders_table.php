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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->nullable();
            $table->string('internal_reference')->unique(); 
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('shipping_address_id')->nullable()->constrained('b2_b_shipping_addresses')->nullOnDelete();
            $table->string('status')->default('Submitted'); 
            $table->string('payment_method')->default('card');
            $table->decimal('total_amount', 12, 2);
            $table->boolean('is_draft')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
