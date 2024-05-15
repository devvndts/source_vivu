<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePostcat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postcat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_list')->default(0);
            $table->tinyInteger('noibat')->default(0);
            $table->string('tenkhongdauvi')->nullable();
            $table->string('tenkhongdauen')->nullable();
            $table->binary('noidungen')->nullable();
            $table->binary('noidungvi')->nullable();
            $table->binary('motaen')->nullable();
            $table->binary('motavi')->nullable();
            $table->string('tenen')->nullable();
            $table->string('tenvi')->nullable();
            $table->string('photo')->nullable();
            $table->text('options')->nullable();
            $table->integer('stt')->default(0);
            $table->tinyInteger('hienthi')->default(0);
            $table->string('type')->nullable();
            $table->integer('ngaytao')->default(0);
            $table->integer('ngaysua')->default(0);

            $table->string('titlevi')->nullable();
            $table->string('keywordsvi')->nullable();
            $table->text('descriptionvi')->nullable();
            $table->string('titleen')->nullable();
            $table->string('keywordsen')->nullable();
            $table->text('descriptionen')->nullable();

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
        Schema::dropIfExists('postcat');
    }
}
