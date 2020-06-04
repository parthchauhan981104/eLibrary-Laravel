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
                  <img class='book-img' src=<?php echo ($book->img_path); ?> alt="">
                </div>
                <div class="col-lg-6" style="padding:0;">
                  <h3><?php echo ($book->name); ?></h3>
                  <p>
                    By
                    <a class='normal-a' href=<?php echo ("\authors\\" . $book->author_name); ?>>
                      <?php echo ($book->author_name); ?>
                    </a>
                  </p>

                  <?php foreach (array_slice(explode(',', $book->categories), 0, 3) as $categ): ?>
                    <h4>
                      <a class='normal-a' href= <?php echo ("\categories\\" . $categ); ?>>
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
                        }elseif (file_exists("images\users\\" . $reader . ".gif")) {
                        $reader_img = "images\users\\" . $reader . ".gif" ;
                        }?>
                        <a title=<?php echo($reader); ?>>
                          <img class='userimg' src=<?php echo($reader_img); ?>>
                        </a>
                      <?php } ?>

                <?php endforeach; ?>
              </div>


              <a class='normal-a' href=<?php echo ("//books/" . urlencode($book->author_name) . "/" . urlencode($book->name)); ?> >
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





<script type="text/javascript">
            const search = document.getElementById('searchbar');
            const tableBody = document.getElementById('tbody');
            function getContent(){

            const searchValue = search.value;

                const xhr = new XMLHttpRequest();
                xhr.open('GET','{{route('searchbooks')}}/?search=' + searchValue ,true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function() {

                    if(xhr.readyState == 4 && xhr.status == 200)
                    {
                        tableBody.innerHTML = xhr.responseText;
                        console.log(xhr.responseText);
                    }
                }
                xhr.send()
            }
            search.addEventListener('input',getContent);
</script>





  </section>




@endsection ('main-section')
