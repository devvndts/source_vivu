<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductOption2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_option', function (Blueprint $table) {
            //
            $table->double('giakm')->nullable();
            $table->double('giamoi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_option', function (Blueprint $table) {
            //
            $table->double('giakm')->nullable();
            $table->double('giamoi')->nullable();
        });
    }
}
