<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\BookMail;
use App\Models\Book;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Mail;
use wapmorgan\Mp3Info\Mp3Info;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book_count = 5;
        $books_by_categories = Category::get_books_by_categories($book_count);
        $latest_books = Book::orderBy('created_at', 'desc')->take($book_count)->get();
        $recommended = Book::where("recommended", 1)->take($book_count)->get();
        $popular = Book::where("popular", 1)->take($book_count)->get();
        return response()->json(compact('books_by_categories', 'latest_books', 'recommended', 'popular'));
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
       // dd($this->getFileDuration(public_path() . $book->audio_path));
        $audio = new Mp3Info(public_path() . $book->audio_path, true);
        $book->audio_size = $audio->duration;
        $pages = Book::get_book_pages($book);
        return response()->json(compact('book', 'pages'));
    }


    public function latest(Request $request)
    {
        $offset = $request->offset;
        $count = $request->count;
        return Book::orderBy('created_at', 'desc')->skip($offset)->take($count)->get();
    }

    public function recommended(Request $request)
    {
        $offset = $request->offset;
        $count = $request->count;
        return Book::where("recommended", 1)->skip($offset)->take($count)->get();
    }

    public function popular(Request $request)
    {
        $offset = $request->offset;
        $count = $request->count;
        return Book::where("popular", 1)->skip($offset)->take($count)->get();
    }

    public function filterCategory(Request $request)
    {
        $offset = $request->offset;
        $count = $request->count;
        $cat_id = $request->cat_id;
        return Category::with(['books' => function ($query) use ($count, $offset) {
            $query->skip($offset)->take($count);
        }])->where('id', $cat_id)->get();
    }

    public function search(Request $request)
    {
        $value = '%' . $request->value . '%';
        // return Book::with('category')->join('categories','books.category','=','categories.id')->where('books.name','like',$value)->orWhere('author','like',$value)->orWhere('categories.name','like',$value)->get(['books.*']);

        return Book::with('category')->where('books.name', 'like', $value)->orWhere('author', 'like', $value)->orWhereHas('category', function ($query) use ($value) {
            $query->where('name', 'like', $value);
        })->get(['books.*']);
    }

    public function markViewed($id)
    {
        $book = Book::find($id);
        $book->views = $book->views + 1;
        $book->save();
        return $book;
    }

    public function mailBook(Request $request)
    {
        $book = Book::with('pages')->find($request->id);
        Mail::to($request->user()->email)->send(new BookMail($book));
        return response()->json(["message" => "Email sent successfully"]);
    }

    public function getFileDuration($file)
    {
        if (file_exists($file)) {
            ## open and read video file
            $handle = fopen($file, "r");

            ## read video file size
            $contents = fread($handle, filesize($file));
            fclose($handle);
            $make_hexa = hexdec(bin2hex(substr($contents, strlen($contents) - 3)));
            if (strlen($contents) > $make_hexa) {
                $pre_duration = hexdec(bin2hex(substr($contents, strlen($contents) - $make_hexa, 3)));
                $post_duration = $pre_duration / 1000;
                $timehours = $post_duration / 3600;
                $timeminutes = ($post_duration % 3600) / 60;
                $timeseconds = ($post_duration % 3600) % 60;
                $timehours = explode(".", $timehours);
                $timeminutes = explode(".", $timeminutes);
                $timeseconds = explode(".", $timeseconds);
                $duration = $timehours[0] . ":" . $timeminutes[0] . ":" . $timeseconds[0];
            }
            return $duration;
        } else {
            return false;
        }
    }

   
}
