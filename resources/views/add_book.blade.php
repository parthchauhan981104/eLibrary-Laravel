@extends ('layouts.theme')



@section('title', 'Add Book')

@include('partials.signout')



@section ('main-section')
  <!-- Main content-->


  <h3 class="message" >{{ $message ?? '' }}</h3>
  <br><br>

  <section class="main-section" id="pricing">

    <div class="container-fluid working-area">


      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif

      @if ($errors->any())
          <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>
                          {{ $error }}
                      </li>
                  @endforeach
              </ul>
          </div>
      @endif



      <form action="{{ route('add_book.save') }}" method="POST" role="form" enctype="multipart/form-data">
        @csrf

      <div class="row ">

          <div class="pricing-column col-lg-6  justify-content-center">
            <br>
            <a title="Book Image">
              <img class="defbookimg" src="images\books\book1.jpg" alt="">
            </a>

            <div class="form-group row justify-content-center">

                <div class="col-md-6">
                  <input id="img_path" type="file" class="form-control mt-1" name="img_path">

                </div>
            </div>

            <br>
          </div>


          <div class="col-lg-6">
              <br>
              <p>Enter Book Name</p>
              <h6 class="guide">(no special characters)</h6>
              <input id="name" type="text" name="name" value="" pattern="^[0-9a-zA-z]+( [0-9a-zA-z]+)*" required>
              <br><br><br>
              <p>Enter Author Name</p>
              <h6 class="guide">(no special characters)</h6>
              <input id="author_name" type="text" name="author_name" value="" pattern="^[0-9a-zA-z]+( [0-9a-zA-z]+)*" required>
              <br><br><br>
              <p>Add Categories</p>
              <h6 class="guide">(comma separated)</h6>
              <!-- should be comma separated -->
              <input id="categories" type="text" name="categories" value="" pattern="^[0-9a-zA-z]+(, [0-9a-zA-z]+)*" required>
              <br><br>
              <button type="submit" name="button" class="btn btn-lg btn-dark mt-3">Save Book</button>
              <br><br>

          </div>

        </form>

      </div>


    </div>

  </section>

@endsection ('main-section')
