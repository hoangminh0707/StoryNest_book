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
        Schema::create('voucher_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained('vouchers');  // Liên kết với bảng vouchers
            $table->foreignId('user_id')->constrained('users');  // Liên kết với bảng users
            $table->timestamp('used_at')->nullable();  // Thời gian người dùng sử dụng voucher
            $table->boolean('is_used')->default(false);  // Trạng thái sử dụng voucher (true: đã sử dụng, false: chưa sử dụng)
            $table->timestamps();  // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_user');
    }
};
