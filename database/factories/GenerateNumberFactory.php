<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenerateNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nohandphone' => $this->faker->unique()->numerify('############'),
            'provider' => $this->faker->randomElement(['xl','telkomsel', 'tri'])
        ];
    }
}
