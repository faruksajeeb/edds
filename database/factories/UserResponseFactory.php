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
            // 'full_name' => fake()->name(),
            // 'email' => fake()->unique()->safeEmail(),
            'registered_user_id' => fake()->numberBetween($min = 1, $max = 500),
            // 'district_id' => fake()->numberBetween($min = 1, $max = 64),
            // 'thana_id' => fake()->numberBetween($min = 1, $max = 495),
            'area_id' => fake()->numberBetween($min = 1, $max = 10),
            'market_id' => fake()->numberBetween($min = 1, $max = 50),
            // 'respondent_id' =>fake()->numberBetween($min = 1, $max = 3),
            // 'mobile_no' => fake()->phoneNumber(),
             'created_at' => fake()->date('Y-m-d H:i:s'),
        ];
    }
}
