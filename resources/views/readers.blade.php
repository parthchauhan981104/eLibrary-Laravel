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

      <form class="" action="/readers" method="post">
        @csrf
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search all readers...">
        <br>

      </form>

      <?php
        $contents =  array();
      ?>

            <?php
            foreach ($readers as $reader):
            ?>

              <?php ob_start(); ?>



            <div class="card">
                <div class="row">
                    <?php

                      $reader_img = "images\users\user.png";

                      if (file_exists("{{ URL::asset('/') }}images/users/" . $reader->email . ".png")) {
                        $reader_img = "{{ URL::asset('/') }}images/users/" . $reader->email . ".png" ;
                      } elseif (file_exists("{{ URL::asset('/') }}images/users/" . $reader->email . ".jpg")) {
                        $reader_img = "{{ URL::asset('/') }}images/users/" . $reader->email . ".jpg" ;
                      }elseif (file_exists("{{ URL::asset('/') }}images/users/" . $reader->email . ".gif")) {
                      $reader_img = "{{ URL::asset('/') }}images/users/" . $reader->email . ".gif" ;
                      }?>

                    <a title=<?php echo($reader->email); ?>>
                      <img class='userimg' src=<?php echo($reader_img); ?>>
                    </a>

                </div>

                <div class="row" style="display:block;">

                        <h3><?php echo("Name :    " . ucwords($reader->name))?> </h3>
                        <p><?php echo ("Email :    " . $reader->email); ?> </p>
                        <p><?php echo ($reader->readcount . " Books read"); ?> </p>

                </div>

          </div>



              <?php $content = ob_get_clean(); ?>




              <?php array_push($contents, $content);?>


            <?php
              endforeach;
            ?>


          <div id="tbody">
            <?php Arrange(sizeof($readers), $contents);   ?>
          </div>




      <script type="text/javascript">
          const search = document.getElementById('searchbar');
          const tableBody = document.getElementById('tbody');
          function getContent(){

            const searchValue = search.value;

                const xhr = new XMLHttpRequest();
                xhr.open('GET','{{route('search_readers')}}/?search=' + searchValue  ,true);
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
