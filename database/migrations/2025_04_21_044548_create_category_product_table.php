<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductTable extends Migration
{
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->id(); // Tạo cột id tự động

            // Khóa ngoại cho sản phẩm
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Khóa ngoại cho danh mục
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
}
