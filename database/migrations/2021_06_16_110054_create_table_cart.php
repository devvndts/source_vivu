<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_product')->default(0);
            $table->integer('id_order')->default(0);
            $table->string('photo')->nullable();
            $table->string('ten')->nullable();
            $table->string('code')->nullable();
            $table->string('masp')->nullable();
            $table->string('mau')->nullable();
            $table->string('size')->nullable();
            $table->double('gia')->default(0);
            $table->double('giacu')->default(0);
            $table->double('giamoi')->default(0);
            $table->integer('soluong')->default(0);
            $table->integer('weight')->default(0);
            $table->integer('buy_later')->default(0);
            $table->text('token_member_cart')->nullable();
            $table->integer('id_user')->default(0);

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
        Schema::dropIfExists('cart');
    }
}
