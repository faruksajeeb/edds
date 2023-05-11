<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserResponse>
 */
class UserResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'division_id' => fake()->numberBetween($min = 1, $max = 8),
            'district_id' => fake()->numberBetween($min = 1, $max = 64),
            'thana_id' => fake()->numberBetween($min = 1, $max = 495),
            'area_id' => fake()->numberBetween($min = 1, $max = 50),
            'market_id' => fake()->numberBetween($min = 1, $max = 100),
            'respondent_id' =>fake()->numberBetween($min = 1, $max = 3),
            'mobile_no' => fake()->phoneNumber(),
            'gender' => fake()->randomElement(['male' ,'female', 'common']),
        ];
    }
}
