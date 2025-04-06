<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->softDeletes(); // Thêm cột deleted_at
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('deleted_at'); // Xóa cột deleted_at nếu rollback
        });
    }
}
