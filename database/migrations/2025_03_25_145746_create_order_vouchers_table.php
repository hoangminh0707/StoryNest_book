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
        Schema::create('order_vouchers', function (Blueprint $table) {
            $table->id(); // ID bảng liên kết đơn hàng với mã giảm giá
            $table->unsignedBigInteger('order_id'); // Liên kết đơn hàng
            $table->unsignedBigInteger('voucher_code_id'); // Liên kết mã giảm giá
            $table->decimal('discount_amount', 10, 2); // Số tiền giảm giá
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('voucher_code_id')->references('id')->on('voucher_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_vouchers');
    }
};
