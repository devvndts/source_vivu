<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsers2806211 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('social_name')->nullable()->after('social_provider');
            $table->string('diachi')->nullable()->after('phonenumber');
            $table->integer('ngaysinh')->default(0);
            $table->integer('gioitinh')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('social_name')->nullable()->after('social_provider');
            $table->string('diachi')->nullable()->after('phonenumber');
            $table->integer('ngaysinh')->default(0);
            $table->integer('gioitinh')->default(0);
        });
    }
}
