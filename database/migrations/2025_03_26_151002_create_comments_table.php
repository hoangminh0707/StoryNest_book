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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // ID của bình luận (khóa chính)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người bình luận
            $table->unsignedBigInteger('commentable_id'); // ID của đối tượng được bình luận (sản phẩm hoặc bài viết)
            $table->string('commentable_type'); // Kiểu đối tượng (Product, Post,...)
            $table->text('content'); // Nội dung bình luận
            $table->boolean('is_approved')->default(false); // Kiểm duyệt bình luận
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
