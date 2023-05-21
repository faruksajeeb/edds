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
            'question_id' => fake()->numberBetween($min = 5, $max = 5),
            'sub_question_id' => fake()->numberBetween($min = 10, $max = 11),
            'response' => fake()->numberBetween($min = 5, $max = 30),
        ];
    }
}
