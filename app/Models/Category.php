<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function get_books_by_categories($book_count)
    {
        return Category::with(['books' => function ($query) use ($book_count) {
            $query->take($book_count);
        }])->get()->groupBy('name');
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'category');
    }
}
