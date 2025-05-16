<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('blog_id')->constrained();
                $table->string('name');
                $table->string('email');
                $table->text('content');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

