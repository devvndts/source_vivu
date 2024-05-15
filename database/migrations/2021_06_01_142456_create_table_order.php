<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->default(0);
            $table->string('madonhang')->nullable();
            $table->string('hoten')->nullable();
            $table->string('dienthoai')->nullable();
            $table->string('diachi')->nullable();
            $table->string('email')->nullable();
            $table->integer('httt')->default(0);
            $table->double('tamtinh')->default(0);
            $table->double('giamgia')->default(0);
            $table->double('tonggia')->default(0);
            $table->double('coin_pay')->default(0);
            $table->integer('city')->default(0);
            $table->integer('district')->default(0);
            $table->integer('wards')->default(0);
            $table->double('phiship')->default(0);
            $table->text('yeucaukhac')->nullable();
            $table->text('ghichu')->nullable();
            $table->integer('ngaytao')->default(0);
            $table->integer('tinhtrang')->default(0);
            $table->integer('stt')->default(0);
            $table->integer('status_payments')->default(0);
            $table->text('json_payments')->nullable();
            $table->text('json_coupon')->nullable();
            $table->text('json_invoice')->nullable();
            $table->text('json_delivery')->nullable();
            $table->string('bankcode')->nullable();
            $table->tinyInteger('hienthi')->default(0);
            $table->tinyInteger('is_created_order_delivery')->default(0);
            $table->longText('247_tracking')->nullable();
            $table->longText('json_orderNhanh')->nullable();
            $table->longText('json_uporderNhanh')->nullable();
            $table->integer('dongbo')->default(0);
            $table->double('idOderNhanh')->default(0);
            $table->integer('channel')->default(0);
            $table->integer('has_feedback')->default(0);
            $table->integer('madonhang_shopee')->default(0);
            $table->integer('completion_time')->default(0);
            $table->integer('guarantee_time')->default(0);
            $table->double('chiphi_kenhbanhang')->default(0);
            $table->integer('lazada_id')->default(0);
            $table->integer('dagiao')->default(0);
            $table->text('tiki_order_code')->nullable();
            $table->text('tiki_json')->nullable();

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
        Schema::dropIfExists('order');
    }
}
