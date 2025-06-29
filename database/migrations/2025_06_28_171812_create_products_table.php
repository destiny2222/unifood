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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('availability')->nullable();
            $table->string('featured')->nullable();
            $table->string('badge')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->string('images')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
