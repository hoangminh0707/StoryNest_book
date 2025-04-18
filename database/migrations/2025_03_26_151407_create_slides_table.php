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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Tiêu đề slide (nếu có)
            $table->string('image_url'); // Đường dẫn ảnh slide
            $table->string('link')->nullable(); // Link khi click vào slide
            $table->integer('position')->default(0); // Thứ tự hiển thị
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
