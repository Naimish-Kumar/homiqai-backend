<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('furniture_products')) {
            Schema::create('furniture_products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category')->default('furniture');
                $table->string('brand')->nullable();
                $table->string('image_url')->nullable();
                $table->string('affiliate_link')->nullable();
                $table->decimal('low_price', 10, 2)->nullable();
                $table->decimal('medium_price', 10, 2)->nullable();
                $table->decimal('high_price', 10, 2)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('furniture_product_style')) {
            Schema::create('furniture_product_style', function (Blueprint $table) {
                $table->id();
                $table->foreignId('furniture_product_id')->constrained()->cascadeOnDelete();
                $table->foreignId('style_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['furniture_product_id', 'style_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('furniture_product_style');
        Schema::dropIfExists('furniture_products');
    }
};
