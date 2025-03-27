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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // ID thanh toán
            $table->unsignedBigInteger('order_id'); // Liên kết đến đơn hàng
            $table->decimal('amount', 10, 2); // Số tiền thanh toán
            $table->string('payment_method'); // Phương thức thanh toán (VD: credit_card, paypal, bank_transfer)
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Trạng thái thanh toán
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
