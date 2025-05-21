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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();  // ID voucher
            $table->string('code')->unique();  // Mã voucher duy nhất
            $table->string('name');  // Tên voucher
            $table->text('description')->nullable();  // Mô tả voucher
            $table->enum('type', ['percent', 'fixed'])->default('fixed');  // Loại voucher (percent: phần trăm, fixed: giá trị cố định)
            $table->decimal('value', 12, 2);  // Giá trị voucher (phần trăm hoặc số tiền)
            $table->decimal('max_discount_amount', 15, 2)->nullable(); // Số tiền giảm tối đa (cho loại percent)
            $table->decimal('min_order_value', 15, 2)->nullable(); // Giá trị đơn hàng tối thiểu
            $table->dateTime('expires_at')->nullable();  // Thời gian hết hạn voucher
            $table->integer('max_usage')->default(1);  // Số lần sử dụng tối đa cho voucher
            $table->integer('usage_count')->default(0);  // Số lần voucher đã được sử dụng
            $table->boolean('is_active')->default(true);  // Trạng thái hoạt động của voucher (có thể vô hiệu hóa)
            $table->string('condition_type')->nullable(); // Loại điều kiện áp dụng (product, category, ...)
            $table->timestamps();  // Các trường created_at, updated_at
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
