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


@section ('main-section')
  <!-- Main content-->


  <h3 style="color:white; font-size:1.2rem;">{{ $message ?? '' }}</h3>
  <br><br>

  <section class="main-section" id="pricing">

    <div class="container-fluid" style=" border-style: ridge;
      border-color: black;
      border-width: thin;
      background-color: #e5e5e5;
      padding:15px 5px 5px 0;">


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



      <form action="{{ route('addbook.save') }}" method="POST" role="form" enctype="multipart/form-data">
        @csrf

      <div class="row ">

          <div class="pricing-column col-lg-6">
            <br>
            <a title="Default Image">
              <img style="margin:0 0 50px 0; height:60%; width:50%;" src="images\books\book1.jpg" alt="">
            </a>

            <div class="form-group row">

                <div class="col-md-6">
                  <input id="img_path" style="margin-left:55%;" type="file" class="form-control" name="img_path">

                </div>
            </div>

            <br>
          </div>


          <div class="col-lg-6">
              <br>
              <p>Enter Book Name</p>
              <h6 style="font-size: 0.8rem; margin-top: -8px;">(no special characters)</h6>
              <input id="name" type="text" name="name" value="" pattern="^[0-9a-zA-z]+( [0-9a-zA-z]+)*" required>
              <br><br><br>
              <p>Enter Author Name</p>
              <h6 style="font-size: 0.8rem; margin-top: -8px;">(no special characters)</h6>
              <input id="author_name" type="text" name="author_name" value="" pattern="^[0-9a-zA-z]+( [0-9a-zA-z]+)*" required>
              <br><br><br>
              <p>Add Categories</p>
              <h6 style="font-size: 0.8rem; margin-top: -8px;">(comma separated)</h6>
              <!-- should be comma separated -->
              <input id="categories" type="text" name="categories" value="" pattern="^[0-9a-zA-z]+(, [0-9a-zA-z]+)*" required>
              <br><br>
              <button type="submit" name="button" class="btn btn-lg btn-dark">Save Book</button>
              <br><br>

          </div>

        </form>

      </div>


    </div>

  </section>

@endsection ('main-section')
