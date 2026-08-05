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
        // 1. Create kycs table
        if (!Schema::hasTable('kycs')) {
            Schema::create('kycs', function (Blueprint $table) {
                $table->id();
                $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
                $table->string('company_name');
                $table->string('company_registration_number');
                $table->string('business_type'); // restaurant, retailer, caterer, reseller, other
                $table->text('trade_address');
                $table->string('billing_contact');
                $table->string('estimated_monthly_order_volume');
                $table->string('status')->default('pending'); // pending, approved, rejected, info_requested
                $table->string('pricing_tier')->default('Wholesale Tier 1');
                $table->text('status_notes')->nullable();
                $table->timestamps();
            });
        }

        // 2. Add columns to users table
        if (!Schema::hasColumn('users', 'kyc_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('kyc_id')->nullable()->after('id')->constrained('kycs')->nullOnDelete();
                $table->boolean('is_business_owner')->default(false)->after('kyc_id');
                $table->string('current_view')->default('personal')->after('is_business_owner');
            });
        }

        // 3. Add column to products table
        if (!Schema::hasColumn('products', 'is_b2b')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('is_b2b')->default(false)->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_b2b');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kyc_id']);
            $table->dropColumn(['kyc_id', 'is_business_owner', 'current_view']);
        });

        Schema::dropIfExists('kycs');
    }
};
