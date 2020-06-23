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

        $mybooks_namesauth = explode(',' , str_replace("_", " ", Auth::user()->readbooks));
        $mybooks_names = array();
        foreach ($mybooks_namesauth as $namea) {
          $mybooksna = explode('-', $namea);
          $i=0;
          foreach ($mybooksna as $name) {
            if($i % 2 != 0){
              array_push($mybooks_names, $name);
            }
            $i++;
          }
        }
        $mybooks = Book::whereIn('name', $mybooks_names)->take(5)->get();

        $authors= Author::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 authors
        $categories= Category::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 categories
        $books = Book::latest()->orderBy('readerscount', 'desc')->take(5)->get(); //top 5 books
        return view('userdashboard', ['categories' => $categories, 'authors' => $authors, 'mybooks' => $mybooks,
         'books' => $books, 'num_authors' => $num_authors, 'num_books' => $num_books, 'num_readers' => $num_readers]);

    }

    public function indexadmin() {

      $authors= Author::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 authors
      $readers = User::latest()->orderBy('readcount', 'desc')->take(5)->get(); //top 5 readers
      $categories= Category::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 categories
      $books = Book::latest()->orderBy('readcount', 'desc')->take(5)->get(); //top 5 books
      return view('admindashboard', ['categories' => $categories, 'readers' => $readers, 'authors' => $authors, 'books' => $books]);

    }


    public function myBooks() {

        $mybooks_namesauth = explode(',' , str_replace("_", " ", Auth::user()->readbooks));
        $mybooks_names = array();
        foreach ($mybooks_namesauth as $namea) {
          $mybooksna = explode('-', $namea);
          $i=0;
          foreach ($mybooksna as $name) {
            if($i % 2 != 0){
              array_push($mybooks_names, $name);
            }
            $i++;
          }
        }
        $mybooks = Book::whereIn('name', $mybooks_names)->get();

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

          DB::table('users')->where('id', Auth::user()->id)->update(
          ['readbooks' => DB::raw("CONCAT(readbooks,'" . str_replace(" " , "_", urldecode($request->auth)) . "-" . str_replace(" " , "_", urldecode($request->name)) . "," . "')"),
           'readcount' => DB::raw('readcount + 1')
          ]
          );

          DB::table('authors')->where('name', urldecode($request->auth))->update(
          ['readcount' => DB::raw('readcount + 1')
          ]
          );

          DB::table('books')->where('name', urldecode($request->name))->where('author_name', urldecode($request->auth))->update(
          ['readers_email' => DB::raw("CONCAT(readers_email,'" . Auth::user()->email . "," . "')"),
           'readerscount' => DB::raw('readerscount + 1')
          ]
          );

          foreach (explode(',', urldecode($request->categ)) as $categ) {

            DB::table('categories')->where('name', trim($categ))->update(
            ['readcount' => DB::raw('readcount + 1')
            ]
            );

          }


          $message = "Book marked as read";
          return json_encode($message);

      }

    }



    public function searchbooks(Request $request)
  {

     if($request->ajax()){

       $output="";
       if($request->categ === "all"){
         $results = DB::table('books')->where('name','LIKE',$request->search."%")->get();
       } else {
         $results = DB::table('books')->where('name','LIKE',$request->search."%")->where('categories', 'like', "%$request->categ%")->get();
       }
       $content = $this->showbooks($results);
       $output = $this->Arrange(sizeof($content), $content);
       return $output;

       }

  }


  public function searchmybooks(Request $request)
{

   if($request->ajax()){

     $output="";
     $mybooks_namesauth = explode(',' , str_replace("_", " ", Auth::user()->readbooks));
     $mybooks_names = array();
     foreach ($mybooks_namesauth as $namea) {
       $mybooksna = explode('-', $namea);
       $i=0;
       foreach ($mybooksna as $name) {
         if($i % 2 != 0){
           array_push($mybooks_names, $name);
         }
         $i++;
       }
     }
     if($request->categ === "all"){
      $results = DB::table('books')->whereIn('name',  $mybooks_names)->where('name','LIKE',$request->search."%")->get();
     } else {
      $results = DB::table('books')->whereIn('name',  $mybooks_names)->where('name','LIKE',$request->search."%")->where('categories', 'like', "%$request->categ%")->get();
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
                <img class='book-img' src=<?php echo ($book->img_path); ?> alt="">
              </div>
              <div class="col-lg-6" style="padding:0;">
                <h3><?php echo (ucwords($book->name)); ?></h3>
                <p>
                  <?php echo ("By " . ucwords($book->author_name)); ?>
                </p>
                <br>

                <?php foreach (array_slice(explode(',', $book->categories), 0, 3) as $categ): ?>
                  <h4 style="display:inline-block; margin-right:10px;">
                    <?php echo (ucwords($categ) . " "); ?>
                  </h4>
                <?php endforeach; ?>

              </div>
            </div>

            <div class="readers" style="display:inline-block;">
              <?php foreach (array_slice(explode(',', $book->readers_email), 0, 8) as $reader): ?>

                <?php if($reader!="") { ?>

                  <?php
                    $reader_img = "images\users\user.png";
                    if (file_exists("images\users" . '/' . $reader . ".png")) {
                      $reader_img = "images\users"  . '/' . $reader . ".png" ;
                    } elseif (file_exists("images\users" . '/'  . $reader . ".jpg")) {
                      $reader_img = "images\users"  . '/' . $reader . ".jpg" ;
                    } elseif (file_exists("images\users" .  '/' . $reader . ".gif")) {
                      $reader_img = "images\users"  . '/' . $reader . ".gif" ;
                    }
                  ?>
                  <a title=<?php echo($reader); ?>>
                        <img class='userimg' src=<?php echo($reader_img); ?>>
                  </a>

                <?php } ?>

              <?php endforeach; ?>
            </div>

            <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
              <a class='normal-a' href=<?php echo ('//books/' . urlencode($book->author_name) . '/' . urlencode($book->name)); ?> >
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
               <img class='book-img' src=<?php echo ($book->img_path); ?> alt="">
             </div>
             <div class="col-lg-6" style="padding:0;">
               <h3><?php echo (ucwords($book->name)); ?></h3>
               <p>
                 <?php echo ("By " . ucwords($book->author_name)); ?>
               </p>
               <br>

               <?php foreach (array_slice(explode(',', $book->categories), 0, 3) as $categ): ?>
                 <h4 style="display:inline-block; margin-right:10px;">
                   <?php echo (ucwords($categ) . " "); ?>
                 </h4>
               <?php endforeach; ?>

             </div>
           </div>

           <div class="readers" style="display:inline-block;">
             <?php foreach (array_slice(explode(',', $book->readers_email), 0, 8) as $reader): ?>

               <?php if($reader!="") { ?>

                 <?php
                   $reader_img = "images\users\user.png";
                   if (file_exists("images\users" . '/' . $reader . ".png")) {
                     $reader_img = "images\users"  . '/' . $reader . ".png" ;
                   } elseif (file_exists("images\users" . '/'  . $reader . ".jpg")) {
                     $reader_img = "images\users"  . '/' . $reader . ".jpg" ;
                   } elseif (file_exists("images\users" .  '/' . $reader . ".gif")) {
                     $reader_img = "images\users"  . '/' . $reader . ".gif" ;
                   }
                 ?>
                 <a title=<?php echo($reader); ?>>
                       <img class='userimg' src=<?php echo($reader_img); ?>>
                 </a>

               <?php } ?>

             <?php endforeach; ?>
           </div>

           <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
             <a class='normal-a' href=<?php echo ("\books\\" . urlencode($book->author_name) . "\\" . urlencode($book->name)); ?> >
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

                <?php foreach (array_slice(explode(',', $author->categories), 0, 3) as $categ): ?>
                  <h4 style="display:inline-block; margin-right:10px;">
                    <?php echo (ucwords($categ) . " "); ?>
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
