<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lang', function (Blueprint $table) {
            //
            $table->string('giatri')->nullable();
            $table->string('langvi')->nullable();
            $table->string('langen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lang', function (Blueprint $table) {
            //
            $table->string('giatri')->nullable();
            $table->string('langvi')->nullable();
            $table->string('langen')->nullable();
        });
    }
}
