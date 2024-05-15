<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_photo')->default(0);
            $table->string('photo')->nullable();
            $table->string('tenen')->nullable();
            $table->string('tenvi')->nullable();
            $table->integer('id_mau')->default(0);
            $table->string('taptin')->nullable();
            $table->text('link_video')->nullable();
            $table->integer('stt')->default(0);
            $table->string('type')->nullable();
            $table->string('com')->nullable();
            $table->string('kind')->nullable();
            $table->string('val')->nullable();
            $table->tinyInteger('hienthi')->default(0);
            $table->integer('ngaytao')->default(0);
            $table->integer('ngaysua')->default(0);
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
        Schema::dropIfExists('gallery');
    }
}
