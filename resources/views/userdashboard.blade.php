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


  @section ('carousel-section')
  <!-- Features -->

  <section class="carousel-section" id="features">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active container-fluid">
              <h2 class="carousel-text">New books added everyday</h2>
              <img class="carousel-img" src="images\book.png" alt="new books">
            </div>
            <div class="carousel-item container-fluid">
              <h2 class="carousel-text">Keep track of your read books</h2>
              <img class="carousel-img" src="images\list.jpg" alt="keep track">
            </div>
            <div class="carousel-item container-fluid">
              <h2 class="carousel-text">Receive personalized alerts</h2>
              <img class="carousel-img" src="images\alerts.jpg" alt="alerts">
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>

  </section>

@endsection ('carousel-section')


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


    <div class="row ">

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>Top Books</h3>
          </div>
          <div class="card-body">
            <?php foreach ($books as $book): ?>
              <p>
                <a class='normal-a' href= <?php echo ("//books/" . urlencode($book->author_name) . "/" . urlencode($book->name)); ?>>
                  <?php echo ($book->name); ?>
                </a>
              </p>
            <?php endforeach; ?>
            <a class='normal-a' href="/books">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all books</button>
            </a>
          </div>
        </div>
      </div>

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>My Books</h3>
          </div>
          <div class="card-body">
            <?php foreach (array_slice(explode(',', $mybooks), 0, 5) as $book): ?>
              <p>
                <?php echo ($book); ?>
              </p>
            <?php endforeach; ?>
            <a class='normal-a' href="/mybooks">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all my books</button>
            </a>
          </div>
        </div>
      </div>

    </div>

    <div class="row ">

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>Top Authors</h3>
          </div>
          <div class="card-body">
            <?php foreach ($authors as $author): ?>
              <p>
                <a class='normal-a' href= <?php echo ("//authors/" . urlencode($author->name)); ?>>
                  <?php echo ($author->name); ?>
                </a>
              </p>
            <?php endforeach; ?>
            <a class='normal-a' href="/authors">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all authors</button>
            </a>
          </div>
        </div>
      </div>

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>Top Categories</h3>
          </div>
          <div class="card-body">
            <?php foreach ($categories as $categ): ?>
              <p>
                <a class='normal-a' href= <?php echo ("//categories/" . urlencode($categ->name)); ?>>
                  <?php echo ($categ->name); ?>
                </a>
              </p>
            <?php endforeach; ?>
            <a class='normal-a' href="/categories">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all categories</button>
            </a>
          </div>
        </div>
      </div>

    </div>

  </section>

@endsection ('main-section')
