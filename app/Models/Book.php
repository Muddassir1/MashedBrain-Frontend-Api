<?php

namespace App\Models;

use App\Models\BookPages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'author', 'language', 'category', 'about_book', 'about_audience', 'about_author', 'time', 'recommended', 'popular'];

    public static function get_similar_books($book)
    {
        $catId = $book->category;
        return Book::where('category', '=', $catId)->get(['id', 'name', 'author', 'image_path']);
    }

    public static function get_book_pages($book)
    {
        return BookPages::where('book_id', $book->id)->get();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function pages()
    {
        return $this->belongsTo(BookPages::class,'id','book_id');
    }
}
