@extends ('layouts.theme')



@section('title', 'All Authors')

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
                        <h3><?php echo(ucwords($author->name)); ?></h3>
                        <p>
                          <?php echo($author->bookscount . " Books"); ?>
                        </p>
                        <p>
                          <?php echo($author->readcount . " Readers"); ?>
                        </p>
                        <br>

                          


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


@include('partials.scripts.allauthorsscript')


  </section>

@endsection ('main-section')
