@extends ('layouts.theme')



@section('title', 'User Dashboard')

@include('partials.signout')

@include('partials.avatar')

@include('partials.profile')

@include('partials.carousel')

@include('partials.statistics')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">


    <div class="row">

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card h-100" >
          <div class="card-header">
            <h3>Top Books</h3>
          </div>
          <div class="card-body" >
            <?php $n = sizeof($books); ?>
            <?php if ($n===0) {
    ?>
                <p>
                  No Books
                </p>
            <?php
} ?>

            <?php foreach ($books as $book): ?>
              <p>
                <a class='normal-a' href="\books\{{urlencode($book->author->name)}}\{{urlencode($book->name)}}">
                  {{ucwords($book->name)}}
                </a>
              </p>
            <?php endforeach; ?>
          </div>
          <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
            <a class='normal-a' href="/books">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all books</button>
            </a>
          </div>
        </div>
      </div>

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card h-100" >
          <div class="card-header">
            <h3>My Books</h3>
          </div>
          <div class="card-body"  >
            <?php $n = sizeof($mybooks); ?>
            <?php if ($n===0) {
        ?>
                <p>
                  You haven't read any books.
                </p>
                
            <?php
    } ?>

            <?php foreach ($mybooks as $book): ?>
              <p>
                {{ucwords($book['name'])}}
              </p>
            <?php endforeach; ?>
          </div>
          <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
            <a class='normal-a' href="/mybooks" >
              <button class="btn btn-lg btn-block btn-dark" type="button">See all my books</button>
            </a>
          </div>
        </div>
      </div>

    </div>

    <div class="row" style="display: flex; justify-content: center;">

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card h-100">
          <div class="card-header">
            <h3>Top Authors</h3>
          </div>
          <div class="card-body">
            <?php $n = sizeof($authors); ?>
            <?php if ($n===0) { ?>
                <p>
                  No Authors
                </p>
            <?php } ?>

            <?php foreach ($authors as $author): ?>
              <p>
                {{ucwords($author->name)}}
              </p>
            <?php endforeach; ?>
          </div>
          <div class="card-footer text-muted mx-auto" style="width:100%; margin-top:5px;">
            <a class='normal-a' href="/authors">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all authors</button>
            </a>
          </div>
        </div>
      </div>


    </div>

    <div class="justify-content-center">
      <br>
      <p class="add-book">Add Book</p>
      <a href="{{ route('add_book') }}"><img class="add-book-img" src="{{ URL::asset('/') }}images/add.png" alt="add book"></a>

    </div>

  </section>

@endsection ('main-section')
