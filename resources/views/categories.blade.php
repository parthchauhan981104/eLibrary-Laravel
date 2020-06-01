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

      <form class="" action="/categories" method="post">
        @csrf
        <input id='search' type="text" name="search" value="" placeholder="Search all categories...">
        <button type="submit" class="btn btn-light" name="button">Search</button>
      </form>



      <?php
        $contents =  array();
      ?>

            <?php
            foreach ($categories as $categ):
            ?>

              <?php ob_start(); ?>

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
                            <a class='normal-a' href= <?php echo ("\books?name=" . $book); ?>>
                              <?php echo ($book . " "); ?>
                            </a>
                          </h4>
                        <?php endforeach; ?>



                      </div>
                    </div>

                    <div class="authors" style="display:inline-block;">
                      <?php foreach (array_slice(explode(',', $categ->authors), 0, 3) as $author): ?>
                        <h4><?php echo ($author . " "); ?></h4>
                      <?php endforeach; ?>
                    </div>

                    <a class='normal-a' href=<?php echo ("/categories/{{categ}}"); ?> >
                      <button class="btn btn-lg btn-block btn-dark open-button" style="" type="button">
                        Open
                      </button>
                    </a>


              <?php $content = ob_get_clean(); ?>


              <?php array_push($contents, $content);?>


            <?php
              endforeach;
            ?>

          <?php
            Arrange(sizeof($categories), $contents);
          ?>


  </section>

@endsection ('main-section')
