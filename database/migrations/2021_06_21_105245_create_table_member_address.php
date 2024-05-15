<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMemberAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->default(0);
            $table->string('tenvi')->nullable();
            $table->integer('id_city')->default(0);
            $table->string('name_city')->nullable();
            $table->integer('id_district')->default(0);
            $table->string('name_district')->nullable();
            $table->integer('id_ward')->default(0);
            $table->string('name_ward')->nullable();
            $table->integer('id_street')->default(0);
            $table->string('name_street')->nullable();
            $table->string('address')->nullable();

            $table->string('hoten')->nullable();
            $table->string('dienthoai')->nullable();
            $table->string('email')->nullable();
            $table->integer('ngaytao')->default(0);
            $table->integer('ngaysua')->default(0);
            $table->integer('hienthi')->default(1);
            $table->integer('is_default')->default(0);
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
        Schema::dropIfExists('user_address');
    }
}
