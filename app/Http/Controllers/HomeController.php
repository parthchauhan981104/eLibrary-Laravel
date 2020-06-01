<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response
use App\Authors;
use App\Books;
use App\categories;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        $num_books = DB::table('books')->count(); //no. of books
        $num_authors = DB::table('authors')->count(); //no. of authors
        $num_readers = DB::table('users')->count(); //no. of readers
        $mybooks = Auth::user()->readbooks;
        $authors= Authors::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 authors
        $categories= Categories::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 categories
        $books = Books::latest()->orderBy('readerscount', 'desc')->take(5)->get(); //top 5 books
        return view('userdashboard', ['categories' => $categories, 'authors' => $authors, 'mybooks' => $mybooks,
         'books' => $books, 'num_authors' => $num_authors, 'num_books' => $num_books, 'num_readers' => $num_readers]);

    }


    public function myBooks() {

        $mybooks_names = explode(', ' , Auth::user()->readbooks);
        $mybooks = Books::whereIn('name', $mybooks_names)->get();

        return view('mybooks', ['mybooks' => $mybooks]);

    }


    public function authors() {

      $authors= Authors::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 authors
      return view('authors', ['authors' => $authors]);

    }


    public function categories() {

      $categories= Categories::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 categories
      return view('categories', ['categories' => $categories]);

    }


    public function profile() {

      $categories= Categories::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 categories
      return view('categories', ['categories' => $categories]);

    }


    public function search(Request $request) {

      if($request->ajax()) {

        $output="";
        if ($request->searchbar != "") {

          $results=DB::table('books')->where('name','LIKE','%'.$request->searchbar."%")->get();
          return Response($results);

        } else {

          $results=DB::table('books')->take(12)->get();
          return Response($results);

        }

        // if($products)
        // {
        //
        //   foreach ($products as $key => $product) {
        //
        //     $output.='<div>'.
        //     '<p>'.$product->name.'</p>'.
        //     '<p>'.$product->author_name.'</p>'.
        //     '<p>'.$product->categories.'</p>'.
        //     '<p>'.$product->price.'</p>'.
        //     '</div>';
        //
        //   }
        //
        //   return Response($output);
        //
        // }

      }
    }

    public function showBooks() {

        $contents =  array();

            foreach ($books as $book) {


              <?php ob_start(); ?>

                  <div class="card">
                    <div class="row card-body">
                      <div class="col-lg-6">
                        <img class='book-img' src=<?php echo ($book->img_path); ?> alt="">
                      </div>
                      <div class="col-lg-6" style="padding:0;">
                        <h3><?php echo ($book->name); ?></h3>
                        <p>
                          By
                          <a class='normal-a' href="\authors?auth=aname">
                            <?php echo ($book->author_name); ?>
                          </a>
                        </p>

                        <?php foreach (array_slice(explode(',', $book->categories), 0, 3) as $categ): ?>
                          <h4>
                            <a class='normal-a' href= <?php echo ("\categories?categ=" . $categ); ?>>
                              <?php echo ($categ . " "); ?>
                            </a>
                          </h4>
                        <?php endforeach; ?>

                      </div>
                    </div>

                    <div class="readers" style="display:inline-block;">
                      <?php foreach (array_slice(explode(',', $book->readers), 0, 8) as $reader): ?>

                          <?php
                            $reader_img = "images\users\user.png";
                            if (file_exists("images\users\\" . $reader . ".png")) {
                              $reader_img = "images\users\\" . $reader . ".png" ;
                            } elseif (file_exists("images\users\\" . $reader . ".jpg")) {
                              $reader_img = "images\users\\" . $reader . ".jpg" ;
                            }
                          ?>
                          <a title=<?php echo($reader); ?>>
                            <img class='userimg' src=<?php echo($reader_img); ?>>
                          </a>

                      <?php endforeach; ?>
                    </div>


                    <a class='normal-a' href=<?php echo ("/viewbook?name=" . $book->name . "&auth=" . $book->author); ?> >
                      <button class="btn btn-lg btn-block btn-dark open-button" style="" type="button">
                        Open
                      </button>
                    </a>
                  </div>


              <?php $content = ob_get_clean(); ?>




              array_push($contents, $content);


            }


    }



}

?>
