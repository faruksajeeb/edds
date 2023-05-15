<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserReponseDetail>
 */
class UserResponseDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'response_id' => fake()->numberBetween($min = 1, $max = 1000),
            'question_id' => fake()->numberBetween($min = 3, $max = 3),
            'sub_question_id' => fake()->numberBetween($min = 1, $max = 9),
            'response' => fake()->numberBetween($min = 1, $max = 50),
        ];
    }
}
