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
        Schema::create('voucher_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained('vouchers') ;  // Liên kết với bảng vouchers
            $table->foreignId('order_id')->constrained('orders');  // Liên kết với bảng orders
            $table->decimal('discount_value', 12, 2);  // Giá trị giảm giá đã áp dụng
            $table->timestamps();  // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_orders');
    }
};
