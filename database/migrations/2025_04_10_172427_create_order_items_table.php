<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Mỗi dòng thuộc về 1 đơn hàng
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Sản phẩm
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('cascade'); // Biến thể (nếu có)

            $table->string('product_name'); // Ghi lại tên SP tại thời điểm mua
            $table->decimal('price', 12, 2); // Giá tại thời điểm mua
            $table->integer('quantity'); // Số lượng
            $table->decimal('total', 12, 2); // Tổng tiền = price * quantity

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
