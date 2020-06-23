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

      <form class="" action="/books" method="post">
        @csrf
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search all books...">
        <br>

          <?php
            $i=1;
            foreach ($allcategories as $categ) {
              if ($categ->name!="") { ?>

                <div class="category" style="display:inline-block; margin: 0 3px 0 3px;">
                  <input type="radio" name="catradios" value=<?php echo($categ->name); ?> id=<?php echo("cat" . $i); ?> >
                  <label style="color:black" for=<?php echo("cat" . $i); ?> class='cat-check'><?php echo(ucwords($categ->name)); ?></label>
                </div>

        <?php $i++; }
            } ?>
            <div class="category" style="display:inline-block; margin: 0 3px 0 3px;">
              <input type="radio" name="catradios" value="all" id="catall" checked>
              <label style="color:blue" for="catall" class='cat-check'>All</label>
            </div>


      </form>


<?php
  $contents =  array();
?>

      <?php
      foreach ($books as $book):
      ?>

        <?php ob_start(); ?>

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
                      } elseif (file_exists("images\users" .  '/' . $reader . ".jpeg")) {
                        $reader_img = "images\users"  . '/' . $reader . ".jpeg" ;
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
            var categoriesradiob = $('input[name="catradios"]');
            function getContent(){

              const searchValue = search.value;
              var checked = categoriesradiob.filter(function() {
                return $(this).prop('checked');
              });
              const category = checked.val();


                  const xhr = new XMLHttpRequest();
                  xhr.open('GET','{{route('search_books')}}/?search=' + searchValue + '&categ=' + category ,true);
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
            for (const radiob of categoriesradiob) {
                radiob.addEventListener("click", getContent);
            }

</script>





  </section>




@endsection ('main-section')
