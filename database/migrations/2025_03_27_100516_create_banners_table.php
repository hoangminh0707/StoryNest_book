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
        Schema::create('banners', function (Blueprint $table) {
            $table->id(); // ID duy nhất của banner
            $table->string('image_url'); // Đường dẫn ảnh banner
            $table->string('title')->nullable(); // Tiêu đề của banner (có thể để trống)
            $table->string('link')->nullable(); // Đường dẫn liên kết (có thể để trống)
            $table->integer('order')->default(0); // Số thứ tự hiển thị
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
