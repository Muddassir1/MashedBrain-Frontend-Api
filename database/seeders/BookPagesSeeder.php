<?php

namespace Database\Seeders;

use App\Models\BookPages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookPages::factory()->count(3)->create(["book_id" => 1]);
        BookPages::factory()->count(4)->create(["book_id" => 2]);
        BookPages::factory()->count(2)->create(["book_id" => 3]);
    }
}
