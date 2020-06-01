@extends ('layouts.theme')



@section ('sign-out')
<li class="nav-item">
  <a class="nav-link" href="/logout" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
    Sign Out
  </a>
</li>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection ('sign-out')

@section ('avatar')
<a title=<?php echo(Auth::user()->email) ?>>
  <img class="userimg" src=<?php echo(Auth::user()->img_path) ?> >
</a>
@endsection ('avatar')

@section ('profile')
<li class="nav-item">
  <a class="nav-link" href="/profile">Profile</a>
</li>
@endsection ('profile')


<?php


function Arrange($count, $contents){
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


?>


@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">
    <div class="container-fluid" style=" border-style: ridge;
      border-color: black;
      border-width: thin;
      background-color: #e5e5e5;
      padding:15px 5px 5px 0;">

      <form class="" action="/mybooks" method="post">
        @csrf
        <input id='search' type="text" name="search" value="" placeholder="Search all my books...">
        <button type="submit" class="btn btn-light" name="button">Search</button>
      </form>



<?php
  $contents =  array();
?>

      <?php
      foreach ($mybooks as $book):
      ?>

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
                      <?php echo ($book->author); ?>
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
                    <img class='userimg' src=<?php echo($reader_img); ?>>

                <?php endforeach; ?>
              </div>


              <a class='normal-a' href=<?php echo ("/viewbook?name=" . $book->name . "&auth=" . $book->author); ?> >
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

    <?php
      Arrange(sizeof($mybooks), $contents);
    ?>



  </section>

@endsection ('main-section')
