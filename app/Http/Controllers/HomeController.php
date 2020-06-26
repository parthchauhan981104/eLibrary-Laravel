<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Author;
use App\Book;
use App\Category;
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

        // dd(array_slice(Auth::user()->books->toArray(), 0, 5));

        $mybooks = array_slice(Auth::user()->books->toArray(), 0, 5);

        $authors= Author::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 authors
        
        $books = Book::latest()->orderBy('readerscount', 'desc')->take(5)->get(); //top 5 books

        return view('userdashboard', [ 'authors' => $authors, 'mybooks' => $mybooks,
         'books' => $books, 'num_authors' => $num_authors, 'num_books' => $num_books, 'num_readers' => $num_readers]);

    }

    public function indexadmin() {

      $authors= Author::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 authors
      $readers = User::latest()->orderBy('readcount', 'desc')->take(5)->get(); //top 5 readers
      // $categories= Category::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 categories
      $books = Book::latest()->orderBy('readcount', 'desc')->take(5)->get(); //top 5 books
      return view('admindashboard', ['readers' => $readers, 'authors' => $authors, 'books' => $books]);

    }


    public function myBooks() {

        $mybooks = Auth::user()->books;
        // dd($mybooks);

        $allcategories = Category::select('name')->get();

        return view('mybooks', ['mybooks' => $mybooks, 'allcategories' => $allcategories]);

    }


    public function authors() {

      $authors= Author::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 authors
      return view('authors', ['authors' => $authors]);

    }


    public function categories() {

      $categories= Category::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 categories
      return view('categories', ['categories' => $categories]);

    }


    public function profile() {

      $categories= Category::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 categories
      return view('categories', ['categories' => $categories]);

    }


    public function markread(Request $request) {

      if($request->ajax()){

        $message="";

        DB::table('book_user')->insertOrIgnore(
           ['book_id' => urldecode($request->bid), 'user_id' => urldecode($request->uid)]
           );

        DB::table('users')->where('id', urldecode($request->uid))->update(
          [
           'readcount' => DB::raw('readcount + 1')
          ]
          );

        DB::table('books')->where('id', urldecode($request->bid))->update(
          [
           'readerscount' => DB::raw('readerscount + 1')
          ]
          );

        DB::table('authors')->where('name', urldecode($request->auth))->update(
          ['readcount' => DB::raw('readcount + 1')
          ]
          );

        $message = "Book marked as read";
        return json_encode($message);

      }

    }



    public function searchbooks(Request $request)
  {

     if($request->ajax()){

       $output="";
       $bname = $request->search;
       $cname = $request->categ;

       if($request->categ === "all") {

         $results = Book::whereHas('categories', function ($query) use($bname) {
         $query->where('books.name', 'like', $bname."%");
         })->get();

         // dd($results->toArray());

       } else {

         $results = Book::whereHas('categories', function ($query) use($bname, $cname) {
         $query->where('categories.name', 'like', $cname."%");
         $query->where('books.name', 'like', $bname."%");
         })->get();

         // dd($results->toArray());
       }

       $content = $this->showbooks($results->toArray());
       $output = $this->Arrange(sizeof($content), $content);
       return $output;

       }

  }


  public function searchmybooks(Request $request)
{

   if($request->ajax()){

     $output="";
     $bname = $request->search;
     $cname = $request->categ;
     $uid = Auth::user()->id;
     
     if($request->categ === "all"){

      $results = Book::whereHas('users', function ($query) use($uid) {
         $query->where('users.id', $uid);
         })->whereHas('categories', function ( $query ) use($bname) {
          $query->where('books.name', 'like', $bname."%");
         })->get();
     
     } else {

      $results = Book::whereHas('users', function ($query) use($uid) {
         $query->where('users.id', $uid);
         })->whereHas('categories', function ( $query ) use($bname, $cname) {
          $query->where('books.name', 'like', $bname."%");
          $query->where('categories.name', 'like', $cname."%");
         })->get();

     }

     $content = $this->showmybooks($results);
     $output = $this->Arrange(sizeof($content), $content);
      return $output;

     }

}


  public function searchauthors(Request $request)
  {

   if($request->ajax()){

     $output="";
     $results = DB::table('authors')->where('name','LIKE',$request->search."%")->get();
     $content = $this->showauthors($results);
     $output = $this->Arrange(sizeof($content), $content);
      return $output;

     }

  }


  public function searchcategories(Request $request)
  {

   if($request->ajax()){

     $output="";
     $results = DB::table('categories')->where('name','LIKE',$request->search."%")->get();
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
          <div class="card h-100">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='book-img' src=<?php echo ($book['img_path']); ?> alt="">
              </div>
              <div class="col-lg-6" style="padding:0;">
                <h3><?php echo (ucwords($book['name'])); ?></h3>
                <p>
                  <?php 
                  $author = Author::where('id', $book['author_id'])->get();
                  $book_obj = Book::where('id', $book['id'])->get();

                  echo ("By " . ucwords($author[0]->name)); ?>
                </p>
                <br>

                <?php foreach (array_slice($book_obj[0]->categories->toArray(), 0, 3) as $categ): ?>
                    <h4 style="display:inline-block; margin-right:10px;">
                      <?php echo (ucwords($categ['name']) . " "); ?>
                    </h4>
                  <?php endforeach; ?>

              </div>
            </div>

              <div class="readers" style="display:inline-block;">
                <?php foreach (array_slice($book_obj[0]->users->toArray(), 0, 8) as $reader): ?>

                    <?php
                    // dd($reader);
                      $reader_img = "images\users\user.png";
                      if (file_exists("images\users" . '/' . $reader['email'] . ".png")) {
                        $reader_img = "images\users"  . '/' . $reader['email'] . ".png" ;
                      } elseif (file_exists("images\users" . '/'  . $reader['email'] . ".jpg")) {
                        $reader_img = "images\users"  . '/' . $reader['email'] . ".jpg" ;
                      } elseif (file_exists("images\users" .  '/' . $reader['email'] . ".gif")) {
                        $reader_img = "images\users"  . '/' . $reader['email'] . ".gif" ;
                      } elseif (file_exists("images\users" .  '/' . $reader['email'] . ".jpeg")) {
                        $reader_img = "images\users"  . '/' . $reader['email'] . ".jpeg" ;
                      }
                    ?>
                    <a title=<?php echo($reader['email']); ?>>
                          <img class='userimg' src=<?php echo($reader_img); ?>>
                    </a>

                <?php endforeach; ?>
              </div>



            <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
              <a class='normal-a' href=<?php echo ("\books\\" . urlencode($author[0]->name) . "\\" . urlencode($book_obj[0]->name)); ?> >
                <button class="btn btn-lg btn-block btn-dark open-button" style="" type="button">
                  Open
                </button>
              </a>
            </div>
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
         <div class="card h-100">
           <div class="row card-body">
             <div class="col-lg-6">
               <img class='book-img' src=<?php echo ($book['img_path']); ?> alt="">
             </div>
             <div class="col-lg-6" style="padding:0;">
               <h3><?php echo (ucwords($book['name'])); ?></h3>
               <p>
                 <?php echo ("By " . ucwords($book->author->name)); ?>
               </p>
               <br>

               <?php foreach (array_slice($book->categories->toArray(), 0, 3) as $categ): ?>
                    <h4 style="display:inline-block; margin-right:10px;">
                      <?php echo (ucwords($categ['name']) . " "); ?>
                    </h4>
                <?php endforeach; ?>

             </div>
           </div>


           <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
                <a class='normal-a' href=<?php echo ("\books\\" . urlencode($book->author->name) . "\\" . urlencode($book->name)); ?> >
                  <button class="btn btn-lg btn-block btn-dark open-button" style="" type="button">
                    Open
                  </button>
                </a>
            </div>

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

    foreach ($authors as $author){

        ?><?php ob_start();
        ?>
        <div class="card h-100">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='book-img' src="images\author-icon.jpg" alt="">
              </div>
              <div class="col-lg-6" style="padding:0;">
                <h3><?php echo (ucwords($author->name)); ?></h3>
                <p>
                  <?php echo (ucwords($author->bookscount) . " Books"); ?>
                </p>
                <p>
                  <?php echo (ucwords($author->readcount) . " Readers"); ?>
                </p>
                <br>


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

                <div class="card h-100">
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
