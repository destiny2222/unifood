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
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->foreignId('kyc_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('Pending'); // Pending, Quoted, Accepted, Declined, Expired
            $table->string('delivery_frequency')->nullable(); // e.g., one-off, weekly, monthly
            $table->text('notes')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->text('terms')->nullable();
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};
