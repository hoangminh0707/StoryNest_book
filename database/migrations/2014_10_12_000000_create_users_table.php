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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('customer_type', ['guest', 'registered',])->default('guest'); // Khách vãng lai hoặc đăng ký
            $table->string('avatar')->nullable(); // Ảnh đại diện
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Giới tính
            $table->date('birthdate')->nullable(); // Ngày sinh
            $table->string('phone')->nullable(); // Số điện thoại
            $table->string('address')->nullable(); // Địa chỉ
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
