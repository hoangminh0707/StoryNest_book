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
        Schema::create('price_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_variant_id'); // FK đến product_variants
            $table->decimal('old_price', 10, 2); // Giá cũ
            $table->decimal('new_price', 10, 2); // Giá mới
            $table->timestamp('changed_at')->useCurrent(); // Thời điểm thay đổi giá
            $table->text('reason')->nullable(); // Lý do thay đổi giá (Khuyến mãi, điều chỉnh giá, ...)
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
        Schema::dropIfExists('price_history');
    }
};
