<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $name = "The Boundaries Work Book";
        $author = "Jake Morill";
        $desc = $about_book = $about_audience = $about_author = "If you look past the decluttering books, the best books on minimalism help you understand the Why of a minimalist lifestyle. You can declutter your house, but unless you change your mindset about your possessions and your needs versus wants, you are just going to end up right back where you started.";
        $created = $updated = Carbon::now();

        DB::table('books')->insert([
            [
                'name' => $name,
                'author' => $author,
                'language' => 1,
                'category' => 1,
                'image_path' => '/img/books/1.png',
                'about_book' => $about_book,
                'about_audience' => $about_audience,
                'about_author' => $about_author,
                'created_at' => $created,
                'updated_at' => $updated
            ],
            [
                'name' => $name,
                'author' => $author,
                'language' => 1,
                'category' => 1,
                'image_path' => '/img/books/2.png',
                'about_book' => $about_book,
                'about_audience' => $about_audience,
                'about_author' => $about_author,
                'created_at' => $created,
                'updated_at' => $updated
            ],
            [
                'name' => $name,
                'author' => $author,
                'language' => 2,
                'category' => 2,
                'image_path' => '/img/books/3.png',
                'about_book' => $about_book,
                'about_audience' => $about_audience,
                'about_author' => $about_author,
                'created_at' => $created,
                'updated_at' => $updated
            ],
            [
                'name' => $name,
                'author' => $author,
                'language' => 2,
                'category' => 2,
                'image_path' => '/img/books/1.png',
                'about_book' => $about_book,
                'about_audience' => $about_audience,
                'about_author' => $about_author,
                'created_at' => $created,
                'updated_at' => $updated,
            ]
        ]);

        DB::table('books')->insert([
            [
                'name' => $name,
                'author' => $author,
                'language' => 2,
                'category' => 2,
                'image_path' => '/img/books/1.png',
                'about_book' => $about_book,
                'about_audience' => $about_audience,
                'about_author' => $about_author,
                'created_at' => $created,
                'updated_at' => $updated,
                'recommended' => 1,
                'popular' => 1
            ],
            [
                'name' => $name,
                'author' => $author,
                'language' => 2,
                'category' => 2,
                'image_path' => '/img/books/3.png',
                'about_book' => $about_book,
                'about_audience' => $about_audience,
                'about_author' => $about_author,
                'created_at' => $created,
                'updated_at' => $updated,
                'recommended' => 1,
                'popular' => 1
            ]
        ]);
    }
}
