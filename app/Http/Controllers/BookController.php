<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookPages;
use App\Models\Category;
use App\Models\Language;
use App\Models\UserNotificationTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        $categories = Category::all();
        return view('pages.book.index', ["books" => $books, "categories" => $categories]);
    }

    public function filter(Request $request)
    {
        $books = Book::where('category', $request->id)->get();
        return $books->toJson();
    }

    /*     Create and Update Book Pages */

    public function publish(Request $request)
    {
        if (count($request->input('title')) > 0 && $request->input('title.0') != "") {
            for ($i = 0; $i < count($request->input('title')); $i++) {
                if (isset($request->input('id')[$i])) {
                    $id = $request->input('id')[$i];
                    $page = BookPages::find($id);
                } else {
                    $page = new BookPages();
                }
                $page->book_id = $request->input('book_id');
                $page->title = $request->input('title')[$i];
                $page->description = $request->input('description')[$i];
                $page->save();
            }
        }

        return redirect('books')->with('succes', 'Book updated');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $languages = Language::all();
        $data = [
            "categories" => $categories,
            "languages" => $languages
        ];
        return view('pages.book.add-book', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = Book::create($request->input());
        if ($request->hasFile('book_image') && $request->file('book_image')->isValid()) {
            $image_path = $request->file('book_image')->store('uploads/images/books', 'public');
            $book->image_path = '/storage/' . $image_path;
        }
        if ($request->hasFile('book_audio') && $request->file('book_audio')->isValid()) {
            $audio_path = $request->file('book_audio')->store('uploads/audio', 'public');
            $book->audio_path = '/storage/' . $audio_path;
        }
        $book->save();

        // Send Push notification to users

        $app_users = UserNotificationTokens::all();
        $notifiables = array();
        foreach ($app_users as $app_user) {
            $notifiables[] = "ExponentPushToken[".$app_user["token"]."]";
        }

        Http::post("https://exp.host/--/api/v2/push/send", [
            "to" => $notifiables,
            "title" => "New book published!",
            "body" => "$book->name by $book->author"
        ]);

        return view('pages.book.publish-book', ["id" => $book->id, "pages" => array()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        $categories = Category::all();
        $languages = Language::all();
        $data = [
            "book" => $book,
            "categories" => $categories,
            "languages" => $languages
        ];
        return view("pages.book.edit", $data);
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
        $book = Book::findOrFail($id);
        if ($request->hasFile('book_image') && $request->file('book_image')->isValid()) {
            $image_path = $request->file('book_image')->store('uploads/images/books', 'public');
            $book->image_path = '/storage/' . $image_path;
        }
        if ($request->hasFile('book_audio') && $request->file('book_audio')->isValid()) {
            $audio_path = $request->file('book_audio')->store('uploads/audio', 'public');
            $book->audio_path = '/storage/' . $audio_path;
        }
        $book->fill($request->input());
        $book->save();

        $pages = BookPages::where('book_id', $id)->get();
        return view('pages.book.publish-book', ["id" => $book->id, "pages" => $pages, "update" => true]);
        //return redirect('books')->with('succes',"Book updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();
        return redirect('/books')->with('succes', 'Book deleted!');
    }

    private function saveImage($request)
    {
    }
}
