<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latest_books_count = 10;
        $books_by_categories = Category::get_books_by_categories();
        $latest_books = Book::orderBy('created_at', 'desc')->take($latest_books_count)->get();
        $recommended = Book::where("recommended",1)->get();
        $popular = Book::where("popular",1)->get();
        return response()->json(compact('books_by_categories', 'latest_books','recommended','popular'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $pages = Book::get_book_pages($book);
        return response()->json(compact('book','pages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function latest()
    {
        return Book::orderBy('created_at', 'desc')->get();
    }

    public function search(Request $request)
    {
        $value = '%' . $request->value . '%';
        // return Book::with('category')->join('categories','books.category','=','categories.id')->where('books.name','like',$value)->orWhere('author','like',$value)->orWhere('categories.name','like',$value)->get(['books.*']);

        return Book::with('category')->where('books.name', 'like', $value)->orWhere('author', 'like', $value)->orWhereHas('category', function ($query) use ($value) {
            $query->where('name', 'like' ,$value);
        })->get(['books.*']);
    }
}
