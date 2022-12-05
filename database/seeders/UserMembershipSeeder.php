<?php

namespace Database\Seeders;

use App\Models\UserMemberships;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $max = 20;
        for ($c = 1; $c <= $max; $c++) {
            UserMemberships::factory()->create();
        }
    }
}
