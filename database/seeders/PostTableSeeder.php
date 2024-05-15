<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $faker = Faker::create();
        $limit = 2;
        for ($i=0; $i < $limit; $i++) {
            DB::table('post')->insert([
                'tenkhongdauvi' => $faker->unique->slug(),
                'tenkhongdauen' => $faker->unique->slug(),
                'noidungen' => $faker->paragraphs(5, true),
                'noidungvi' => $faker->paragraphs(5, true),
                'motaen' => $faker->paragraph(),
                'motavi' => $faker->paragraph(),
                'tenen' => $faker->unique->sentence(),
                'tenvi' => $faker->unique->sentence(),
                'photo' => $faker->imageUrl(360, 360, null, true, null, false, 'jpg'),
                'hienthi' => 1,
                'draft' => 0,
                'type' => 'tin-tuc',
                'ngaytao' => $faker->unixTime(),
                'ngaysua' => $faker->unixTime(),
                'titlevi' => $faker->sentence(),
                'keywordsvi' => $faker->sentence(),
                'descriptionvi' => $faker->sentence(),
                'titleen' => $faker->sentence(),
                'keywordsen' => $faker->sentence(),
                'descriptionen' => $faker->sentence(),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
