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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id(); // ID chi tiết thanh toán
            $table->unsignedBigInteger('payment_id'); // Liên kết đến bảng payments
            $table->string('transaction_id')->nullable(); // Mã giao dịch của bên thanh toán
            $table->text('payment_info')->nullable(); // Thông tin thêm về thanh toán
            $table->timestamps();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
