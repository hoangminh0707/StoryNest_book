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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Địa chỉ giao hàng được chọn từ user_addresses
            $table->foreignId('user_address_id')->constrained('user_addresses')->onDelete('restrict');
            $table->foreignId('voucher_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('shipping_method_id')->constrained('shipping_methods')->onDelete('restrict'); // Hình thức vận chuyển
            $table->decimal('total_amount', 12, 2);         // Tổng tiền trước giảm
            $table->decimal('discount_amount', 12, 2)->default(0); // Tiền giảm giá
            $table->decimal('shipping_fee', 12, 2)->default(0);    // Phí vận chuyển
            $table->decimal('final_amount', 12, 2);          // Tổng sau tất cả
        
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])->default('pending');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
