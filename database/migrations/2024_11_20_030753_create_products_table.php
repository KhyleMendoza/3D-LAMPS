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
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->decimal('discounted_price', 8, 2)->nullable();
            $table->integer('discount')->nullable();
            $table->text('description')->nullable();
            $table->json('image');
            $table->string('category')->index();
            $table->integer('stock')->default(0);
            $table->integer('sold')->default(0);
            $table->string('colors')->nullable();
            $table->string('size')->nullable();
            $table->decimal('ratings', 3, 2)->default(0);
            $table->integer('reviews')->default(0);
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
