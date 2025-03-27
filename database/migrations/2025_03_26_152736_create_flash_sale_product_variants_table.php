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
        Schema::create('flash_sale_product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flash_deal_id'); // FK -> flash_deals(id)
            $table->unsignedBigInteger('product_variant_id'); // FK -> product_variants(id)
            $table->decimal('discount_price', 10, 2); // Giá sau khi giảm giá
            $table->timestamps();

            $table->foreign('flash_deal_id')->references('id')->on('flash_deals')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sale_product_variants');
    }
};
