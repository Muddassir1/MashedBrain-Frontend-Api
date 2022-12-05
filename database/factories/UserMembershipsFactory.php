<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserMembershipsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "membership_id" => rand(1,2),
            "user_id" => fake()->unique()->numberBetween(1,50),
            "status" => 1,
            "created_at" => fake()->dateTimeBetween('-2 week')
        ];
    }
}
