<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

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
            "transaction_id" => Random::generate(10),
            "bank_transaction_id" => Random::generate(10),
            "val_id" => Random::generate(10),
            "membership_id" => rand(1,2),
            "payment_method" => rand(1,PaymentMethod::count()),
            "amount" => mt_rand(ceil(50/10) , floor(1000/10))*10,
            "status" => array_rand(['VALID','VALIDATED','INVALID_TRANSACTION','FAILED','EXPIRED']),
            "created_at" => fake()->dateTimeBetween('-1 month')
        ];
    }
}
