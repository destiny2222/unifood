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
        Schema::create('why_choose_u_s', function (Blueprint $table) {
            $table->id();
            $table->string('long_title');
            $table->string('short_title');
            $table->string('title_one');
            $table->string('icon_one');
            $table->string('title_two');
            $table->string('icon_two');
            $table->string('title_three');
            $table->string('icon_three');
            $table->string('title_four');
            $table->string('icon_four');
            $table->longText('description');
            $table->boolean('status')->default(false);
            $table->string('image_two')->nullable();
            $table->string('background_image')->nullable();
            $table->string('image_one')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why_choose_u_s');
    }
};
