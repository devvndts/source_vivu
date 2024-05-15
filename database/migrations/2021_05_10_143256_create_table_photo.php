<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('noibat')->default(0);
            $table->string('photo')->nullable();
            $table->string('tenkhongdauvi')->nullable();
            $table->string('tenkhongdauen')->nullable();
            $table->binary('noidungen')->nullable();
            $table->binary('noidungvi')->nullable();
            $table->binary('motaen')->nullable();
            $table->binary('motavi')->nullable();
            $table->string('tenen')->nullable();
            $table->string('tenvi')->nullable();
            $table->string('link')->nullable();
            $table->string('link_video')->nullable();
            $table->text('options')->nullable();
            $table->string('type')->nullable();
            $table->string('act')->nullable();
            $table->integer('stt')->default(0);
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
        Schema::dropIfExists('photo');
    }
}
