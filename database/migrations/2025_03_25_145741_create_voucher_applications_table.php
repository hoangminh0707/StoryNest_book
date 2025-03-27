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
        Schema::create('voucher_applications', function (Blueprint $table) {
            $table->id(); // ID ứng dụng mã giảm giá
            $table->unsignedBigInteger('voucher_id'); // Liên kết đến bảng voucher_templates
            $table->enum('type', ['product', 'category', 'all']); // Loại áp dụng: sản phẩm, danh mục, toàn cửa hàng
            $table->unsignedBigInteger('reference_id')->nullable(); // ID sản phẩm hoặc danh mục được áp dụng
            $table->timestamps();
            $table->foreign('voucher_id')->references('id')->on('voucher_templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_applications');
    }
};
