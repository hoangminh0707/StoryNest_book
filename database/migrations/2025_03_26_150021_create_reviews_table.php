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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // ID của review (khóa chính)
    
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người đánh giá
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Sản phẩm được đánh giá
            
            $table->integer('rating')->default(5); // Điểm đánh giá
            $table->text('comment')->nullable(); // Nội dung đánh giá
            $table->boolean('is_approved')->default(false); // Kiểm duyệt đánh giá trước khi hiển thị
        
            $table->timestamps(); // created_at & updated_at
            
            // Kiểm tra rating chỉ nhận giá trị từ 1 đến 5
            
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
