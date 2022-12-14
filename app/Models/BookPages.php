<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookPages extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];
    protected $hidden = ['id'];

    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
