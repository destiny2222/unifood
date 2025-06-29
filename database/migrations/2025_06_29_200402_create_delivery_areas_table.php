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
        // 'area_name', 'minimum_delivery_time', 'status', 'maximum_delivery_time', 'delivery_fee'
        Schema::create('delivery_areas', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->integer('minimum_delivery_time')->default(0);
            $table->integer('maximum_delivery_time')->default(0);
            $table->integer('delivery_fee');
            $table->string('slug')->unique();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_areas');
    }
};
