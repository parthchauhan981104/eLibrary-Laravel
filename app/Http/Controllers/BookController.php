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
      return view('addbook');
  }


  public function addBook(Request $request)
 {
     // Form validation
     $request->validate([
         'name'              =>  'required',
         'img_path'     =>  'required|image|mimes:png,jpg,jpeg,gif|max:2048'
     ]);

//////////////////////////////////////////////
     $bookname = strtolower(request('name'));
     $author_name = strtolower(request('author_name'));
     $categories = strtolower(trim(request('categories')));
     $img_path = "images/books/book1.jpg";

     // Check if a profile image has been uploaded
     if ($request->has('img_path')) {
         // Get image file
         $image = $request->file('img_path');
         // Make a image name based on user name and current timestamp
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

       $id = DB::table('authors')->insertGetId(
       ['name' => $author_name, 'bookscount' => 1,
        'categories' => request('categories')
       ]
       );

       DB::table('books')->insert(
       ['name' => $bookname, 'author_name' => $author_name,
        'categories' => $categories, 'author_id' => $id, 'img_path' => $img_path
       ]
       );

       // Upload image
       $this->uploadOne($image, $folder, 'public', $name);


     } else{

         //author exists - add book if not exists
         $book = DB::table('books')->where('name', '=', $bookname )->first();
         if ($book === null) {

           DB::table('books')->insert(
           ['name' => $bookname ,
            'author_id' => $author->id,
            'author_name' => $author_name,
            'categories' => $categories,
            'img_path'=> $img_path
           ]
           );

           DB::table('authors')->where('name', $author_name)->update(
           ['bookscount' => DB::raw('bookscount + 1')
           ]
           );

           // Upload image
           $this->uploadOne($image, $folder, 'public', $name);

         } else{
           return view('/addbook', ['message' => "Book with same name and author already exists"]);
         }

     }

     //finally add or apdate Categories and redirect

     foreach (explode(',' , $categories) as $categ) {

       if ($categ!="") {

         DB::table('categories')->updateOrInsert(
         ['name' => trim($categ)],
         ['authors' => DB::raw("CONCAT(authors,'" . $author_name . "')"),
          'books' => DB::raw("CONCAT(books,'" . $author_name . "_" . "$bookname" . "')"),
          'bookscount' => DB::raw('bookscount + 1')
         ]
         );
       }

     }


     return redirect('/books');

 }

 public function deleteOne($folder = null, $disk = 'public', $filename = null)
  {
     Storage::disk($disk)->delete($folder.$filename);
  }

}
