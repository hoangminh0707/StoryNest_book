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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Giá sản phẩm (cho sản phẩm đơn)
            $table->integer('quantity')->nullable(); // Số lượng sản phẩm (cho sản phẩm đơn)
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->enum('product_type', ['simple', 'variable'])->default('simple'); // Loại sản phẩm
            $table->enum('status', ['published', 'draft'])->default('draft'); // Trạng thái
            $table->timestamps(); 
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('set null');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
