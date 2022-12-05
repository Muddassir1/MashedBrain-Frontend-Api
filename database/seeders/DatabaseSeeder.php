<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AccessLevelSeeder::class,
            CategorySeeder::class,
            LanguageSeeder::class,
            MembershipSeeder::class,
            PaymentMethodSeeder::class,
            UserSeeder::class,
            UserMembershipSeeder::class,
            BookSeeder::class,
            TransactionSeeder::class
        ]);
    }
}
