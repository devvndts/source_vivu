<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten')->nullable();
            $table->string('email')->nullable();
            $table->string('dienthoai')->nullable();
            $table->string('taptin')->nullable();
            $table->string('tieude')->nullable();
            $table->text('noidung')->nullable();
            $table->text('ghichu')->nullable();
            $table->text('diachi')->nullable();
            $table->text('type')->nullable();
            $table->tinyInteger('hienthi')->default(0);
            $table->integer('ngaytao')->default(0);
            $table->integer('ngaysua')->default(0);
            $table->integer('stt')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact');
    }
}
