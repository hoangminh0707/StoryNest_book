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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // ID mục đơn hàng
            $table->unsignedBigInteger('order_id'); // Liên kết đơn hàng
            $table->unsignedBigInteger('product_id'); // Liên kết sản phẩm
            $table->unsignedBigInteger('product_variant_id')->nullable(); // Liên kết biến thể sản phẩm, nullable nếu không có
            $table->integer('quantity'); // Số lượng
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
