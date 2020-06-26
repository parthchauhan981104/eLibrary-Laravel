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
       ['name' => $author_name, 'bookscount' => 1]
       );

       $book_id = DB::table('books')->insertGetId(
       ['name' => $bookname, 'author_id' => $author_id, 'img_path' => $img_path
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

     //finally add or update Categories and redirect

     foreach (explode(',' , $categories) as $categ) {

       if ($categ!="") {

         $category = DB::table('categories')->where('name', '=', trim($categ) )->first();

         if ($category === null) {

           $categ_id = DB::table('categories')->insertGetId(
           ['name' => trim($categ)]
           );

           DB::table('book_category')->insertOrIgnore(
           ['book_id' => $book_id, 'category_id' => $categ_id]
           );

         } else{

          DB::table('book_category')->insertOrIgnore(
           ['book_id' => $book_id, 'category_id' => $category->id]
           );

         }

       }

     }


     return redirect('/books');

 }

 public function deleteOne($folder = null, $disk = 'public', $filename = null)
  {
     Storage::disk($disk)->delete($folder.$filename);
  }

}
