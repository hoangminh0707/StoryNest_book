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
        Schema::create('inventory_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_variant_id'); // FK đến product_variants
            $table->integer('quantity_change'); // Số lượng thay đổi (+ hoặc -)
            $table->enum('type', ['import', 'sale', 'return', 'adjustment']); 
            // import: Nhập hàng, sale: Bán hàng, return: Trả hàng, adjustment: Điều chỉnh tồn kho
            $table->text('reason')->nullable(); // Lý do thay đổi (VD: Hàng lỗi, chương trình khuyến mãi, ...)
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_history');
    }
};
