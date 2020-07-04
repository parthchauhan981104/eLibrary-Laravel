@extends ('layouts.theme')



@section('title', 'Admin - All Books')

@include('partials.signout')


@include('partials.functions.arrange')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">
    <div class="container-fluid working-area" >

      <form class="" action="/books" method="post">
        @csrf
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search all books...">
        <button type="submit" class="btn btn-dark" name="button">
          Search <i id="searchicon" class="fas fa-search"></i>
        </button>
      </form>




<?php
  $contents =  array();
?>

      <?php
      foreach ($books as $book):
      ?>

        <?php ob_start(); ?>

            <div class="card">
              <div class="row card-body">
                <div class="col-lg-6">
                  <img class='book-img' src="{{$book->img_path}}" alt="">
                </div>
                <div class="col-lg-6" style="padding:0;">
                  <h3><?php echo($book->name); ?></h3>
                  <p>
                    By
                    <a class='normal-a' href=<?php echo("\authors\\" . $book->author_name); ?>>
                      <?php echo($book->author_name); ?>
                    </a>
                  </p>

                  <?php foreach (array_slice(explode(',', $book->categories), 0, 3) as $categ): ?>
                    <h4>
                      <a class='normal-a' href= <?php echo("\categories\\" . $categ); ?>>
                        <?php echo($categ . " "); ?>
                      </a>
                    </h4>
                  <?php endforeach; ?>

                </div>
              </div>

              <div class="readers" style="display:inline-block;">
                <?php foreach (array_slice(explode(',', $book->readers_email), 0, 8) as $reader): ?>

                    <?php
                      if ($reader != "") {
                          $reader_img = "";
                          if (file_exists("images\users\\" . $reader . ".png")) {
                              $reader_img = "images\users\\" . $reader . ".png" ;
                          } elseif (file_exists("images\users\\" . $reader . ".jpg")) {
                              $reader_img = "images\users\\" . $reader . ".jpg" ;
                          } elseif (file_exists("images\users\\" . $reader . ".gif")) {
                              $reader_img = "images\users\\" . $reader . ".gif" ;
                          } ?>
                        <a title=<?php echo($reader); ?>>
                          <img class='userimg' src=<?php echo($reader_img); ?>>
                        </a>
                      <?php
                      } ?>

                <?php endforeach; ?>
              </div>


              <a class='normal-a' href=<?php echo("//books/" . urlencode($book->author_name) . "/" . urlencode($book->name)); ?> >
                <button class="btn btn-lg btn-block btn-dark open-button" style="" type="button">
                  Open
                </button>
              </a>
            </div>


        <?php $content = ob_get_clean(); ?>




        <?php array_push($contents, $content);?>


      <?php
        endforeach;
      ?>


    <div id="tbody">
      <?php Arrange(sizeof($books), $contents);   ?>
    </div>



@include('partials.scripts.allbooksscript')



  </section>




@endsection ('main-section')
