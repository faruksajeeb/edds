<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegisteredUser>
 */
class RegisteredUserFactory extends Factory
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
            'gender' => fake()->randomElement(['male' ,'female', 'common']),
            'division' => fake()->name(),
            'district' => fake()->name(),
            'thana' => fake()->name(),
            'respondent_id' =>fake()->numberBetween($min = 1, $max = 3),
            'mobile_no' => fake()->phoneNumber(),
        ];
    }
}
