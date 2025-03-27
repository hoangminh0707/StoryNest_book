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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // ID của thông báo
            $table->unsignedBigInteger('user_id'); // Người nhận thông báo
            $table->string('type'); // Loại thông báo (đơn hàng, khuyến mãi,...)
            $table->text('message'); // Nội dung thông báo
            $table->boolean('is_read')->default(false); // Trạng thái đã đọc hay chưa
            $table->timestamps(); // Ngày tạo và cập nhật

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Ràng buộc khóa ngoại với bảng users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
