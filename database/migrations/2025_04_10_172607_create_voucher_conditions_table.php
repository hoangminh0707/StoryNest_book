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
        Schema::create('voucher_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained('vouchers')->onDelete('cascade');  // Liên kết với voucher và xóa khi voucher bị xóa
            $table->enum('condition_type', ['product', 'category']);  // Loại điều kiện (áp dụng cho sản phẩm hay danh mục)
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');  // Sản phẩm áp dụng, nếu xóa sản phẩm thì đặt null
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');  // Danh mục áp dụng, nếu xóa danh mục thì đặt null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_conditions');
    }
};
