<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackvtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackvtp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number');
            $table->string('order_reference');
            $table->string('order_statusdate');
            $table->integer('order_status')->default(0);
            $table->string('note');
            $table->string('expected_delivery');
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
        Schema::dropIfExists('trackvtp');
    }
}
