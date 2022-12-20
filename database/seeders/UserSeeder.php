<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* [
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@argon.com',
            'password' => bcrypt('secret'),
            "phone" => fake()->e164PhoneNumber(),
            "membership" => rand(1,2),
            "status" => 1,
            "access_level" => 3,
            "category" => 1,
            "avatar" => "/img/defaults/avatar/".rand(1,4).".jpg"
        ] */

        // Create admin accounts
        $admin_avatar = "/img/defaults/avatar/farhan.png";
        User::factory()
            ->count(3)
            ->sequence(
                [
                    "username" => 'khalidfarhan',
                    "email" => 'khalidfarhan@gmail.com',
                    "name" => "Khalid Farhan",
                    "access_level" => 3,
                    "avatar" => $admin_avatar,
                    "password" => "admin@123"
                ],
                [
                    "username" => 'sohankhan',
                    "name" => "Sohan Khan",
                    "access_level" => 3,
                    "avatar" => $admin_avatar,
                    "password" => "admin@123"
                ],
                [
                    "username" => 'mirzafor',
                    "name" => "Mir Zafor",
                    "access_level" => 3 ,
                    "avatar" => $admin_avatar,
                    "password" => "admin@123"
                ],
            )
            ->create();
        
        //Create Random Users
        User::factory()
            ->count(100)
            ->create();
    }
}
