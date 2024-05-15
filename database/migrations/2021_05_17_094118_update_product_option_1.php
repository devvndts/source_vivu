<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductOption1 extends Migration
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
            $table->dropColumn('gia_km');
            $table->dropColumn('gia_moi');
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
            $table->dropColumn('gia_km');
            $table->dropColumn('gia_moi');
        });
    }
}
