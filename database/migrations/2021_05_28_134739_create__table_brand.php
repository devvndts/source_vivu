<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBrand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('photo')->nullable();
            $table->string('tenen')->nullable();
            $table->string('tenvi')->nullable();
            $table->string('tenkhongdauvi')->nullable();
            $table->string('tenkhongdauen')->nullable();
            $table->string('type')->nullable();
            $table->integer('stt')->default(0);
            $table->tinyInteger('hienthi')->default(0);

            $table->tinyInteger('noibat')->default(0);
            $table->tinyInteger('hot')->default(0);
            $table->binary('noidungen')->nullable();
            $table->binary('noidungvi')->nullable();
            $table->binary('motaen')->nullable();
            $table->binary('motavi')->nullable();

            $table->string('titlevi')->nullable();
            $table->string('keywordsvi')->nullable();
            $table->text('descriptionvi')->nullable();
            $table->string('titleen')->nullable();
            $table->string('keywordsen')->nullable();
            $table->text('descriptionen')->nullable();

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
        Schema::dropIfExists('brand');
    }
}
