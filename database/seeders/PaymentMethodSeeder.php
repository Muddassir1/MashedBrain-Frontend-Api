<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            [
                "name" => "bKash",
                "category" => "mobile_banking"
            ],
            [
                "name" => "Rocket",
                "category" => "mobile_banking"
            ],
            [
                "name" => "Islami Bank mCash",
                "category" => "mobile_banking"
            ],
            [
                "name" => "MyCash",
                "category" => "mobile_banking"
            ],
            [
                "name" => "AB Direct",
                "category" => "mobile_banking"
            ],
            [
                "name" => "Tap",
                "category" => "mobile_banking"
            ],
            [
                "name" => "OK Wallet",
                "category" => "mobile_banking"
            ],
            [
                "name" => "DMoney",
                "category" => "mobile_banking"
            ],
            [
                "name" => "City Touch",
                "category" => "net_banking"
            ],
            [
                "name" => "MTB",
                "category" => "net_banking"
            ],
            [
                "name" => "Tap'n Pay",
                "category" => "net_banking"
            ],
            [
                "name" => "iPay",
                "category" => "net_banking"
            ]
        ]);
    }
}
