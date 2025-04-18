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
        Schema::create('flash_deals', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề chương trình khuyến mãi
            $table->dateTime('start_time'); // Thời gian bắt đầu
            $table->dateTime('end_time'); // Thời gian kết thúc
            $table->timestamps(); // Thời gian tạo & cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_deals');
    }
};
