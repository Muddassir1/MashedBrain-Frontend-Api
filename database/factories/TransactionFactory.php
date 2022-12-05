<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => rand(2,50),
            "membership_id" => rand(1,2),
            "payment_method_id" => rand(1,PaymentMethod::count()),
            "amount" => mt_rand(ceil(50/10) , floor(1000/10))*10,
            "created_at" => fake()->dateTimeBetween('-1 month')
        ];
    }
}
