<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStatic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static', function (Blueprint $table) {
            $table->increments('id');
            $table->string('photo')->nullable();
            $table->text('options')->nullable();
            $table->string('tenkhongdauvi')->nullable();
            $table->string('tenkhongdauen')->nullable();
            $table->binary('noidungen')->nullable();
            $table->binary('noidungvi')->nullable();
            $table->binary('motaen')->nullable();
            $table->binary('motavi')->nullable();
            $table->string('tenen')->nullable();
            $table->string('tenvi')->nullable();
            $table->string('taptin')->nullable();
            $table->string('type')->nullable();
            $table->tinyInteger('hienthi')->default(0);
            $table->integer('ngaytao')->default(0);
            $table->integer('ngaysua')->default(0);
            $table->integer('id_product')->default(0);
            $table->text('json_product')->nullable();
            $table->string('begindate')->nullable();
            $table->string('enddate')->nullable();
            $table->string('begintime')->nullable();
            $table->string('endtime')->nullable();
            $table->integer('giasale')->default(0);
            $table->integer('tongsl')->default(0);
            $table->integer('soluongbandau')->default(0);
            $table->integer('dongsale')->default(0);
            $table->binary('tieudeformen')->nullable();
            $table->binary('tieudeformvi')->nullable();

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
        Schema::dropIfExists('static');
    }
}
