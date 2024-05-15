<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_city')->default(0);
            $table->integer('id_district')->default(0);
            $table->string('ten')->nullable();
            $table->string('tenkhongdau')->nullable();
            $table->string('mapx')->nullable();
            $table->string('cap')->nullable();
            $table->integer('stt')->default(0);
            $table->tinyInteger('hienthi')->default(0);
            $table->integer('ngaytao')->default(0);
            $table->integer('ngaysua')->default(0);
            $table->double('gia')->default(0);

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
        Schema::dropIfExists('ward');
    }
}
