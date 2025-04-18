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
        Schema::create('voucher_templates', function (Blueprint $table) {
            $table->id(); // ID của mẫu mã giảm giá
            $table->string('name'); // Tên mã giảm giá
            $table->text('description')->nullable(); // Mô tả mã giảm giá
            $table->decimal('discount_amount', 10, 2)->nullable(); // Số tiền giảm giá cố định
            $table->integer('discount_percentage')->nullable(); // Phần trăm giảm giá
            $table->decimal('min_order_value', 10, 2)->nullable(); // Giá trị đơn hàng tối thiểu để áp dụng
            $table->integer('max_uses_per_user')->nullable(); // Số lần tối đa mỗi người dùng có thể sử dụng
            $table->integer('total_available')->nullable(); // Tổng số mã có sẵn
            $table->dateTime('start_date'); // Ngày bắt đầu
            $table->dateTime('end_date'); // Ngày kết thúc
            $table->boolean('is_active')->default(true); // Trạng thái kích hoạt
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_templates');
    }
};
