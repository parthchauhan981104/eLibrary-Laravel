<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
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



    public function searchbooks(Request $request)
  {

     if($request->ajax()){

       $output="";
       $results = DB::table('Books')->where('name','LIKE',$request->search."%")->get();
       $content = $this->showbooks($results);
       $output = $this->Arrange(sizeof($content), $content);
        return $output;

       }

  }


  public function searchmybooks(Request $request)
{

   if($request->ajax()){

     $output="";
     $mybooks_names = explode(', ' , Auth::user()->readbooks);
     $results = DB::table('Books')->whereIn('name',  $mybooks_names)->where('name','LIKE',$request->search."%")->get();
     $content = $this->showmybooks($results);
     $output = $this->Arrange(sizeof($content), $content);
      return $output;

     }

}


public function searchauthors(Request $request)
{

 if($request->ajax()){

   $output="";
   $results = DB::table('Authors')->where('name','LIKE',$request->search."%")->get();
   $content = $this->showauthors($results);
   $output = $this->Arrange(sizeof($content), $content);
    return $output;

   }

}


public function searchcategories(Request $request)
{

 if($request->ajax()){

   $output="";
   $results = DB::table('Categories')->where('name','LIKE',$request->search."%")->get();
   $content = $this->showcategories($results);
   $output = $this->Arrange(sizeof($content), $content);
    return $output;

   }

}

  public function Arrange($count, $contents){
    $columns = 3; // 3 items in a row
    $rows = ceil($count / $columns);
    $remainder = $count % $columns;
    $postChunks = array_chunk($contents, $columns);
    $p=0;
    if($remainder > 0){
      $p=1;
    }

    foreach (array_slice($postChunks, 0, $rows-$p) as $posts) {
        echo('<div class="row">');
            foreach ($posts as $post) {
                echo('<div class="pricing-column col-md-4">');
                    echo($post);
                echo('</div>');
            }
        echo('</div>');
    }

    if($remainder > 0) {
      foreach (array_slice($postChunks, -1) as $remposts) {
        echo('<div class="row">');
            foreach ($remposts as $rempost) {
                echo('<div class="pricing-column col-md-' . 12/$remainder . '">');
                    echo($rempost);
                echo('</div>');
            }
        echo('</div>');
      }
    }
  }


  public function showbooks($books) {
    $contents = array();

    foreach ($books as $book){

        ?><?php ob_start();
        ?>
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='book-img' src=<?php echo ($book->img_path); ?> alt="">
              </div>
              <div class="col-lg-6" style="padding:0;">
                <h3><?php echo ($book->name); ?></h3>
                <p>
                  By
                  <a class='normal-a' href=<?php echo ("//authors/" . $book->author_name); ?>>
                    <?php echo ($book->author_name); ?>
                  </a>
                </p>

                <?php foreach (array_slice(explode(',', $book->categories), 0, 3) as $categ): ?>
                  <h4>
                    <a class='normal-a' href= <?php echo ("//categories/" . $categ); ?>>
                      <?php echo ($categ . " "); ?>
                    </a>
                  </h4>
                <?php endforeach; ?>

              </div>
            </div>

            <div class="readers" style="display:inline-block;">
              <?php foreach (array_slice(explode(',', $book->readers_email), 0, 8) as $reader): ?>

                  <?php
                    if($reader != "") {
                      $reader_img = "";
                      if (file_exists("images\users\\" . $reader . ".png")) {
                        $reader_img = "images\users\\" . $reader . ".png" ;
                      } elseif (file_exists("images\users\\" . $reader . ".jpg")) {
                        $reader_img = "images\users\\" . $reader . ".jpg" ;
                      } elseif (file_exists("images\users\\" . $reader . ".gif")) {
                          $reader_img = "images\users\\" . $reader . ".gif" ;
                        }?>
                      <a title=<?php echo($reader); ?>>
                        <img class='userimg' src=<?php echo($reader_img); ?>>
                      </a>
                    <?php } ?>

              <?php endforeach; ?>
            </div>


            <a class='normal-a' href=<?php echo ('//books/' . urlencode($book->author_name) . '/' . urlencode($book->name)); ?> >
              <button class="btn btn-lg btn-block btn-dark open-button" style="" type="button">
                Open
              </button>
            </a>
          </div>


      <?php
      $content = ob_get_clean();
      array_push($contents, $content);

       ?>

  <?php
    }
    return $contents;

   }


   public function showmybooks($mybooks) {
     $contents = array();

     foreach ($mybooks as $book){

         ?><?php ob_start();
         ?>
         <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='book-img' src=<?php echo ($book->img_path); ?> alt="">
              </div>
              <div class="col-lg-6" style="padding:0;">
                <h3><?php echo ($book->name); ?></h3>
                <p>
                  By
                  <a class='normal-a' href=<?php echo ("//authors/" . $book->author_name); ?>>
                    <?php echo ($book->author); ?>
                  </a>
                </p>

                <?php foreach (array_slice(explode(',', $book->categories), 0, 3) as $categ): ?>
                  <h4>
                    <a class='normal-a' href= <?php echo ("//categories/" . $categ); ?>>
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
                    } elseif (file_exists("images\users\\" . $reader . ".gif")) {
                      $reader_img = "images\users\\" . $reader . ".gif" ;
                    }
                  ?>
                  <a title=<?php echo($reader); ?>>
                        <img class='userimg' src=<?php echo($reader_img); ?>>
                  </a>

              <?php endforeach; ?>
            </div>


            <a class='normal-a' href=<?php echo ("//books/" . urlencode($book->author_name) . "/" . urlencode($book->name)); ?> >
              <button class="btn btn-lg btn-block btn-dark open-button" style="" type="button">
                Open
              </button>
            </a>
          </div>


       <?php
       $content = ob_get_clean();
       array_push($contents, $content);

        ?>

   <?php
     }
     return $contents;

    }


  public function showauthors($authors) {

    $contents = array();

    foreach ($authors as $book){

        ?><?php ob_start();
        ?>
        <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='book-img' src="images\author-icon.jpg" alt="">
              </div>
              <div class="col-lg-6" style="padding:0;">
                <h3><?php echo ($author->name); ?></h3>
                <p>
                  <?php echo ($author->bookscount . " Books"); ?>
                </p>
                <p>
                  <?php echo ($author->readcount . " Readers"); ?>
                </p>

                <?php foreach (array_slice(explode(',', $author->categories), 0, 3) as $categ): ?>
                  <h4>
                    <a class='normal-a' href= <?php echo ("\categories?categ=" . $categ); ?>>
                      <?php echo ($categ . " "); ?>
                    </a>
                  </h4>
                <?php endforeach; ?>

              </div>
            </div>
          </div>


                <?php $content = ob_get_clean(); ?>


                <?php array_push($contents, $content);?>



    <?php
      }
      return $contents;

   }


   public function showcategories($categories) {

     $contents = array();

          foreach ($categories as $categ){


            ?><?php ob_start();
            ?>

                <div class="card">
                  <div class="row card-body">
                    <div class="col-lg-6">
                      <img class='book-img' src="images\category-icon.png" alt="">
                    </div>
                    <div class="col-lg-6" style="padding:0;">
                      <h3><?php echo ($categ->name); ?></h3>
                      <p>
                        <?php echo ($categ->bookscount . " Books"); ?>
                      </p>
                      <p>
                        <?php echo ($categ->readcount . " Readers"); ?>
                      </p>

                      <?php foreach (array_slice(explode(',', $categ->books), 0, 3) as $book): ?>
                        <h4>
                          <?php echo ($book . " "); ?>
                        </h4>
                      <?php endforeach; ?>


                    </div>
                  </div>

                  <div class="authors" style="display:inline-block;">
                    <?php foreach (array_slice(explode(',', $categ->authors), 0, 3) as $author): ?>
                      <h4><?php echo ($author . " "); ?></h4>
                    <?php endforeach; ?>
                  </div>



            <?php $content = ob_get_clean(); ?>


            <?php array_push($contents, $content);?>


          }


         <?php
         $content = ob_get_clean();
         array_push($contents, $content);

          ?>

     <?php
       }
       return $contents;

    }





}

?>
