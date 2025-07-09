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
       
        Schema::create('app_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('background_image')->nullable();
            $table->string('app_image')->nullable();
            $table->string('play_store_link');
            $table->string('app_store_link');
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_sections');
    }
};
