<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LocalAuthority>
 */
class LocalAuthorityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Kotte',
            'code' => 'KOT',
            'address' => 'Sri Jayawardenepura Kotte',
            'telephone_no' => $this->faker->numerify("011#######"),
            'area' => $this->faker->randomFloat(2, 0, 1000),
            'population' => $this->faker->numberBetween(1, 1000000),
            'wards_count' => $this->faker->numberBetween(1, 100),
            'factory_count' => $this->faker->numberBetween(1, 100),
        ];
    }
}
