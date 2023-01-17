<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $image_path = "/img/defaults/categories";
        DB::table('categories')->insert([
            ["name" => "Career & Success",
            "image_path" => "$image_path/career-active.png"],
            ["name" => "Philosophy",
            "image_path" => "$image_path/philosophy.png"],
            ["name" => "Politics",
            "image_path" => "$image_path/politics.png"],
            ["name" => "History",
            "image_path" => "$image_path/history.png"],
            ["name" => "Productivty",
            "image_path" => "$image_path/productivity.png"]
        ]);
    }
}
