<?php


namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

class BookController extends Controller
{

  use UploadTrait;

  public function __construct()
  {
      $this->middleware('auth');
  }


  public function index()
  {
      return view('add_book');
  }


  public function addBook(Request $request)
 {
     // Form validation
     $request->validate([
         'name'              =>  'required',
         'img_path'     =>  'required|image|mimes:png,jpg,jpeg,gif|max:2048'
     ]);

//////////////////////////////////////////////
     $bookname = strtolower(trim(request('name')));
     $author_name = strtolower(trim(request('author_name')));
     $categories = strtolower(trim(request('categories')));
     $img_path = "images/books/book1.jpg";

     // Check if a profile image has been uploaded
     if ($request->has('img_path')) {
         // Get image file
         $image = $request->file('img_path');
         // Make a image name based on author name and book name
         $name = (str_replace(" ", "_", $author_name) . "_" . str_replace(" ", "_", $bookname));
         // Define folder path
         $folder = 'images/books//';
         // Make a file path where image will be stored [ folder path + file name + file extension]
         $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();

         $img_path = $filePath;
     }


     $author = DB::table('authors')->where('name', '=', $author_name )->first();
     if ($author === null) {

       //author does not exist - add author->add book

       $author_id = DB::table('authors')->insertGetId(
       ['name' => $author_name, 'bookscount' => 1,
        "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
        "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
       ]
       );

       $book_id = DB::table('books')->insertGetId(
       ['name' => $bookname, 'author_id' => $author_id, 'img_path' => $img_path,
        "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
        "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
       ]
       );

       // Upload image
       $this->uploadOne($image, $folder, 'public', $name);


     } else{

         //author exists - add book if not exists
         $book = DB::table('books')->where('name', '=', $bookname )->first();
         if ($book === null) {

           $book_id = DB::table('books')->insertGetId(
           ['name' => $bookname ,
            'author_id' => $author->id,
            'img_path'=> $img_path,
        "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
        "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
           ]
           );

           DB::table('authors')->where('name', $author_name)->update(
           ['bookscount' => DB::raw('bookscount + 1'),
           "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
           ]
           );

           // Upload image
           $this->uploadOne($image, $folder, 'public', $name);

         } else{
           return view('/addbook', ['message' => "Book with same name and author already exists"]);
         }

     }

     //finally add or update Categories and redirect

     foreach (explode(',' , $categories) as $categ) {

       if ($categ!="") {

         $category = DB::table('categories')->where('name', '=', trim($categ) )->first();

         if ($category === null) {

           $categ_id = DB::table('categories')->insertGetId(
           ['name' => trim($categ),
           "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
           ]
           );

           DB::table('book_category')->insertOrIgnore(
           ['book_id' => $book_id, 'category_id' => $categ_id,
        "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
        "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
           ]
           );

         } else{

          DB::table('book_category')->insertOrIgnore(
           ['book_id' => $book_id, 'category_id' => $category->id,
        "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
        "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
           ]
           );

         }

       }

     }


     return redirect('/books');

 }

 public function deleteBook(Request $request)
  {

     $book_id = strtolower(trim(request('bid')));
     $bookname = strtolower(trim(request('name')));
     $author_name = strtolower(trim(request('auth')));

     $folder = 'images/books//';
     $name = (str_replace(" ", "_", $author_name) . "_" . str_replace(" ", "_", $bookname));
     

     DB::table('books')->where('id', $book_id)->delete();
     DB::table('authors')->where('name', $author_name)->update(
           ['bookscount' => DB::raw('bookscount - 1'),
           "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
           ]
           );
     DB::table('authors')->where('bookscount', 0)->delete();

     $user = user::find(Auth::user()->id);
     DB::table('users')->where('id', Auth::user()->id)->update(
           ['readcount' => DB::raw('readcount - 1'),
           "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
           ]
           );
     $book = Book::find($book_id);
     $user->books()->detach($book);


     // Delete image
     $this->deleteOne($folder, 'public', $name);
     return redirect('/books');

  }

}
