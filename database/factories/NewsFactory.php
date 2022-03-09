<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText(70, 2),
            'category_id' => rand(1, 4),
            'short_description' => $this->faker->realText(400, 2),
            'description' => $this->faker->realText(4000, 2),
        ];
    }
}
