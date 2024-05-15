<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMember2405 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
            $table->string('diachi')->nullable();
            $table->string('dienthoai')->nullable();
            $table->integer('stt')->default(0);
            $table->tinyInteger('hienthi')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
            $table->string('diachi')->nullable();
            $table->string('dienthoai')->nullable();
            $table->integer('stt')->default(0);
            $table->tinyInteger('hienthi')->default(0);
        });
    }
}
