<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new \Faker\Provider\pt_BR\Person($this->faker));

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'ra' => strval(fake()->randomNumber(7)),
            'cpf' =>fake()->cpf(false),
        ];
    }
}
