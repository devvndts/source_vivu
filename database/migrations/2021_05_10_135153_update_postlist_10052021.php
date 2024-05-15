<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostlist10052021 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postlist', function (Blueprint $table) {
            //
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
        Schema::table('postlist', function (Blueprint $table) {
            //
            $table->string('titlevi')->nullable();
            $table->string('keywordsvi')->nullable();
            $table->text('descriptionvi')->nullable();
            $table->string('titleen')->nullable();
            $table->string('keywordsen')->nullable();
            $table->text('descriptionen')->nullable();
        });
    }
}
