<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();  // Tạo trường 'id' là primary key
            $table->string('name');  // Tên phương thức thanh toán
            $table->string('code')->nullable();  // Mã phương thức thanh toán (có thể nullable)
            $table->text('description')->nullable();  // Mô tả phương thức thanh toán (có thể nullable)
            $table->string('image')->nullable();  // Hình ảnh phương thức thanh toán (có thể nullable)
            $table->boolean('is_active')->default(true);  // Trạng thái kích hoạt (mặc định là true)
            $table->timestamps();  // Tạo trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
