<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdmins24051 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
            //$table->string('lastlogin')->default(0)->change();
            $table->dropColumn('email');
            //$table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
            //$table->string('lastlogin')->default(0)->change();
            $table->dropColumn('email');
            //$table->string('email')->nullable()->change();
        });
    }
}
