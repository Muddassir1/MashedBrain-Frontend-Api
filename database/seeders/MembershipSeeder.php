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
                "cycle_days" => 30
            ],
            [
                "name" => "Nerd",
                "price" => 1000,
                "cycle_days" => 365
            ]
        ]);
    }
}
