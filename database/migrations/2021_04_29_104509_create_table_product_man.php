<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProductMan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_list')->default(0);
            $table->integer('id_cat')->default(0);
            $table->integer('id_item')->default(0);
            $table->integer('id_sub')->default(0);
            $table->integer('id_brand')->default(0);
            $table->string('id_size')->default(0);
            $table->string('id_mau')->default(0);
            $table->string('id_tags')->default(0);
            $table->text('id_bst')->default(0);
            $table->tinyInteger('noibat')->default(0);
            $table->tinyInteger('hot')->default(0);
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
            $table->string('masp')->nullable();
            $table->string('masp_brand')->nullable();
            $table->double('giacu')->nullable();
            $table->double('gia')->nullable();
            $table->double('gia_km')->nullable();
            $table->double('gia_moi')->nullable();
            $table->integer('stt')->default(0);
            $table->tinyInteger('hienthi')->default(0);
            $table->string('type')->nullable();
            $table->integer('banchay')->default(0);
            $table->integer('moi')->default(0);
            $table->integer('dai')->default(0);
            $table->integer('rong')->default(0);
            $table->integer('cao')->default(0);
            $table->integer('khoiluong')->default(0);
            $table->integer('ngaytao')->default(0);
            $table->integer('ngaysua')->default(0);

            $table->string('titlevi')->nullable();
            $table->string('keywordsvi')->nullable();
            $table->text('descriptionvi')->nullable();
            $table->string('titleen')->nullable();
            $table->string('keywordsen')->nullable();
            $table->text('descriptionen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
