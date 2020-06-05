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
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search all authors...">

      </form>




      <?php
        $contents =  array();
      ?>

      <?php
      foreach ($authors as $author):
      ?>


              <?php ob_start(); ?>

                  <div class="card h-100">
                    <div class="row card-body">
                      <div class="col-lg-6">
                        <img class='book-img' src="images\author-icon.jpg" alt="">
                      </div>
                      <div class="col-lg-6" style="padding:0;">
                        <h3><?php echo (ucwords($author->name)); ?></h3>
                        <p>
                          <?php echo ($author->bookscount . " Books"); ?>
                        </p>
                        <p>
                          <?php echo ($author->readcount . " Readers"); ?>
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
              endforeach;
            ?>

            <div id="tbody">
        <?php Arrange(sizeof($authors), $contents);   ?>
      </div>


<script type="text/javascript">
            const search = document.getElementById('searchbar');
            const tableBody = document.getElementById('tbody');
            function getContent(){

            const searchValue = search.value;

                const xhr = new XMLHttpRequest();
                xhr.open('GET','{{route('searchauthors')}}/?search=' + searchValue ,true);
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
