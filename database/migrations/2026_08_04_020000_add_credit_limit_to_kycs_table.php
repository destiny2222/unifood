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
        Schema::table('kycs', function (Blueprint $table) {
            if (!Schema::hasColumn('kycs', 'credit_limit')) {
                $table->decimal('credit_limit', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('kycs', 'payment_terms')) {
                $table->string('payment_terms')->default('card'); // 'card' or '30_days', etc.
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            $table->dropColumn(['credit_limit', 'payment_terms']);
        });
    }
};
