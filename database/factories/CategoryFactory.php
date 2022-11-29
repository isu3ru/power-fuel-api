<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->words(2, true),
            'icon' => $this->faker->image('storage/app/public', 512, 512, null, false),
            'comments' => $this->faker->sentence(10),
            'color_key' => $this->faker->safeHexColor(),
        ];
    }
}
