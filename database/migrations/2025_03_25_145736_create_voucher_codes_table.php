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
        Schema::create('voucher_codes', function (Blueprint $table) {
            $table->id(); // ID mã giảm giá cụ thể
            $table->unsignedBigInteger('voucher_template_id'); // Liên kết mẫu mã giảm giá
            $table->string('code')->unique(); // Mã giảm giá duy nhất
            $table->integer('usage_limit'); // Số lần tối đa sử dụng
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
            $table->integer('remaining_uses'); // Số lần còn lại có thể sử dụng
            $table->timestamps();
            $table->foreign('voucher_template_id')->references('id')->on('voucher_templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_codes');
    }
};
