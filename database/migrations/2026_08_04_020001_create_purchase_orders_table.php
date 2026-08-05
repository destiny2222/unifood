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
            $table->string('po_number')->nullable(); // Customer's reference
            $table->string('internal_reference')->unique(); // Mightyolu's reference
            $table->foreignId('kyc_id')->constrained('kycs')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            
            // Submitted, Processing, Dispatched, Delivered, Invoiced
            $table->string('status')->default('Submitted'); 
            
            $table->string('payment_method')->default('card'); // card, on_account
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
