<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tenkhongdauvi' => $this->faker->slug(),
            'tenkhongdauen' => $this->faker->slug(),
            'noidungen' => $this->faker->paragraphs(5, true),
            'noidungvi' => $this->faker->paragraphs(5, true),
            'motaen' => $this->faker->paragraph(),
            'motavi' => $this->faker->paragraph(),
            'tenen' => $this->faker->sentence(),
            'tenvi' => $this->faker->sentence(),
            'photo' => $this->faker->image(null, 360, 360, 'animals', false, true, 'cats', true, 'jpg'),
            'hienthi' => 1,
            'type' => 'tin-tuc',
            'ngaytao' => $this->faker->unixTime(),
            'ngaysua' => $this->faker->unixTime(),
            'titlevi' => $this->faker->sentence(),
            'keywordsvi' => $this->faker->sentence(),
            'descriptionvi' => $this->faker->sentence(),
            'titleen' => $this->faker->sentence(),
            'keywordsen' => $this->faker->sentence(),
            'descriptionen' => $this->faker->sentence(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
    }
    public function customPost($type, $width, $height)
    {
        return $this->state(function (array $attributes, $type, $width, $height) {
            return [
                'type' => $type,
                'photo' => $this->faker->image('post', $width, $height, 'animals', false, true, 'cats', true, 'jpg'),
            ];
        });
    }
}
