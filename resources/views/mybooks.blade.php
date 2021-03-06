@extends ('layouts.theme')



@section('title', ucwords(Auth::user()->name))

@include('partials.signout')

@include('partials.avatar')

@include('partials.profile')

@include('partials.functions.arrange')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">
    <div class="container-fluid working-area">

      <form class="" action="/books" method="post">
        @csrf
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search my books...">
        <br>

          <?php
            $i=1;
            foreach ($allCategories as $categ) {
                if ($categ->name!="") { ?>

                <div class="category" style="display:inline-block; margin: 0 3px 0 3px;">
                  <input type="radio" name="catradios" value="{{$categ->name}}" id="cat{{$i}}" >
                  <label style="color:black" for="cat{{$i}}" class='cat-check'>{{ucwords($categ->name)}}</label>
                </div>

        <?php $i++; }
            } ?>
            <div class="category" style="display:inline-block; margin: 0 3px 0 3px;">
              <input type="radio" name="catradios" value="all" id="catall" checked>
              <label style="color:#1644ad" for="catall" class='cat-check'>All</label>
            </div>

      </form>



<?php
  $contents =  array();
?>

      <?php
      foreach ($myBooks as $book):
      ?>

        <?php ob_start(); ?>

            <div class="card h-100">
              <div class="row card-body">
                <div class="col-lg-6">
                  <img class='book-img' src="{{$book['img_path']}}" alt="">
                </div>
                <div class="col-lg-6" style="padding:0;">
                  <h3>{{ucwords($book['name'])}}</h3>
                  <p>
                    By {{ ucwords($book->author->name)}}
                  </p>
                  <br>

                  <?php foreach (array_slice($book->categories->toArray(), 0, 3) as $categ): ?>
                    <h4 style="display:inline-block; margin-right:10px;">
                      <?php echo(ucwords($categ['name']) . " "); ?>
                    </h4>
                  <?php endforeach; ?>

                </div>
              </div>


              <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
                <a class='normal-a' href="\books\{{urlencode($book->author->name)}}\{{urlencode($book->name)}}" >
                  <button class="btn btn-lg btn-block btn-dark open-button" type="button">
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
        <?php Arrange(sizeof($myBooks), $contents);   ?>
      </div>


@include('partials.scripts.mybooksscript')



  </section>

@endsection ('main-section')
