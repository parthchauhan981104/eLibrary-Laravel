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


@section ('stats-section')
  <!-- Stats-->

  <section class="stats-section" id="stats">

    <div class="container-fluid statcont" style="padding:0; background-color:black;">

      <div class="row" style="text-align: center;">

        <div class="col-lg-4 col-md-12">
          <p class="statsp"><?php echo($num_books . " BOOKS ADDED"); ?></p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp"><?php echo($num_readers . " READERS"); ?></p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp"><?php echo("WORKS FROM " . $num_authors . " AUTHORS"); ?></p>
        </div>

      </div>

    </div>

  </section>

@endsection ('stats-section')


@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">

    <?php  //for proper sizng of cards when less than 5 elements present to show in them
    $nm = sizeof($readers);
    $nb = sizeof($books);
    $nc = abs($nm - $nb);

    ?>

    <div class="row ">

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>Top Books</h3>
          </div>
          <div class="card-body">
            <?php $n = sizeof($books); ?>
            <?php if ($n===0){
              for ($x = 0; $x < 13; $x++) { ?>
                <p>
                  <?php echo ($x==7 ? "No Books" : ""); ?>
                </p>
            <?php }} ?>

            <?php foreach ($books as $book): ?>
              <p>
                <a class='normal-a' href= <?php echo ( '.\books\\' . urlencode($book->author_name) . "\\" . urlencode($book->name) ); ?>>
                  <?php echo (ucwords($book->name)); ?>
                </a>
              </p>
            <?php endforeach; ?>

            <?php
              if($nb<$nm){
                for($x=0; $x<$nc*2; $x++){ ?>
                  <p></p>
              <?php }
              }
             ?>

            <a class='normal-a' href="/books">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all books</button>
            </a>
          </div>
        </div>
      </div>

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>Top Readers</h3>
          </div>
          <div class="card-body">
            <?php $n = sizeof($readers); ?>
            <?php if ($n===0){
              for ($x = 0; $x < 13; $x++) { ?>
                <p>
                  <?php echo ($x==7 ? "No Readers" : ""); ?>
                </p>
            <?php } ?>

            <?php } ?>
            <?php foreach ($readers as $reader): ?>
              <p>
                <?php echo (ucwords($reader->name)); ?>
              </p>
            <?php endforeach; ?>

            <?php
              if($nm<$nb){
                for($x=0; $x<$nc*2; $x++){ ?>
                  <p></p>
              <?php }
              }
             ?>
            <a class='normal-a' href=<?php echo ("/readers")?>>
              <button class="btn btn-lg btn-block btn-dark" type="button">See all readers</button>
            </a>
          </div>
        </div>
      </div>

    </div>



    <div class="row" style="display: flex; justify-content: center;">

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>Top Authors</h3>
          </div>
          <div class="card-body">
            <?php $n = sizeof($authors); ?>
            <?php if ($n===0){
              for ($x = 0; $x < 13; $x++) { ?>
                <p>
                  <?php echo ($x==7 ? "No Authors" : ""); ?>
                </p>
            <?php }} ?>

            <?php foreach ($authors as $author): ?>
              <p>
                <?php echo (ucwords($author->name)); ?>
              </p>
            <?php endforeach; ?>
            <a class='normal-a' href="/authors">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all authors</button>
            </a>
          </div>
        </div>
      </div>


    </div>

    <div class="">
      <p style="color:white; font-size:2rem;">Add Book</p>
      <a style="margin: 50px 40px 0 50px;" href="/addbook"><img style="height:130px; width:130px; color:white;" src="{{ URL::asset('/') }}images/add.png" alt="add book"></a>

    </div>



  </section>



@endsection ('main-section')
