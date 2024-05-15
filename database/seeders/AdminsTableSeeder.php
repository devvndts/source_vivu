<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'lastlogin' => time(), 'password' => bcrypt('admin123')]
        ]);
    }
}
