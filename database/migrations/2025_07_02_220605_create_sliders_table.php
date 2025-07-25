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
        
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title_one');
            $table->string('title_two');
            $table->string('offer_text');
            $table->string('link');
            $table->string('image')->nullable();
            $table->string('serial');
            $table->longText('description');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
