<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("memberships")->insert([
            [
                "name" => "Newbie",
                "price" => 50,
                "cycle_days" => 30,
                "description" => "A small description about the pricing package.",
                "package_detail" => "1 Book a Month",
                "cycle_text" => "Month"
            ],
            [
                "name" => "Nerd",
                "price" => 1000,
                "cycle_days" => 365,
                "description" => "A small description about the pricing package.",
                "package_detail" => "Unlimited Books",
                "cycle_text" => "Year"
            ]
        ]);
    }
}
