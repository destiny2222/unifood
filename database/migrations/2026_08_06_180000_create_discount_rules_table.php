<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('discount_rules')) {
            Schema::create('discount_rules', function (Blueprint $table) {
                $table->id();
                $table->decimal('min_amount', 10, 2);
                $table->decimal('discount_percentage', 5, 2);
                $table->decimal('max_discount_amount', 10, 2)->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            // Seed default rule: 10% discount on orders >= £100, capped at £50
            DB::table('discount_rules')->insert([
                'min_amount' => 100.00,
                'discount_percentage' => 10.00,
                'max_discount_amount' => 50.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_rules');
    }
};
