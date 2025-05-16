<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên phương thức (ví dụ: Giao hàng nhanh, Giao hàng tiết kiệm)
            $table->string('provider')->nullable(); // Tên nhà cung cấp nếu có
            $table->decimal('default_fee', 10, 2)->default(0); // Phí mặc định
            $table->text('description')->nullable(); // Mô tả
            $table->boolean('is_active')->default(true); // Có khả dụng hay không
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
