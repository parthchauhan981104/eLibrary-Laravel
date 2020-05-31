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
<img class="userimg" src="images/users/user.png" >
@endsection ('avatar')

@section ('profile')
<li class="nav-item">
  <a class="nav-link" href="/profile">Profile</a>
</li>
@endsection ('profile')

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
        <input id='search' type="text" name="search" value="" placeholder="Search all readers...">
        <button type="submit" class="btn btn-light" name="button">Search</button>
      </form>



      <div class="row ">

        <div class="pricing-column col-lg-3 col-md-6">
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='small-img' src="images\book.png" alt="">
              </div>
              <div class="col-lg-6">
                <h3>Name:  </h3>
                <p>Email:  </p>
                <p>Books: <a class='normal-a' href="\books?book=bname"></a>
              </div>
            </div>
            <p>Categories: <a class='normal-a' href="\books?book=bname"></a>
          </div>
        </div>

        <div class="pricing-column col-lg-3 col-md-6">
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='small-img' src="images\book.png" alt="">
              </div>
              <div class="col-lg-6">
                <h3>Name:  </h3>
                <p>Email:  </p>
                <p>Books: <a class='normal-a' href="\books?book=bname"></a>
              </div>
            </div>
            <p>Categories: <a class='normal-a' href="\books?book=bname"></a>
          </div>
        </div>

        <div class="pricing-column col-lg-3 col-md-6">
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='small-img' src="images\book.png" alt="">
              </div>
              <div class="col-lg-6">
                <h3>Name:  </h3>
                <p>Email:  </p>
                <p>Books: <a class='normal-a' href="\books?book=bname"></a>
              </div>
            </div>
            <p>Categories: <a class='normal-a' href="\books?book=bname"></a>
          </div>
        </div>

        <div class="pricing-column col-lg-3 col-md-6">
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='small-img' src="images\book.png" alt="">
              </div>
              <div class="col-lg-6">
                <h3>Name:  </h3>
                <p>Email:  </p>
                <p>Books: <a class='normal-a' href="\books?book=bname"></a>
              </div>
            </div>
            <p>Categories: <a class='normal-a' href="\books?book=bname"></a>
          </div>
        </div>


      </div>

      <div class="row ">

        <div class="pricing-column col-lg-3 col-md-6">
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='small-img' src="images\book.png" alt="">
              </div>
              <div class="col-lg-6">
                <h3>Name:  </h3>
                <p>Email:  </p>
                <p>Books: <a class='normal-a' href="\books?book=bname"></a>
              </div>
            </div>
            <p>Categories: <a class='normal-a' href="\books?book=bname"></a>
          </div>
        </div>

        <div class="pricing-column col-lg-3 col-md-6">
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='small-img' src="images\book.png" alt="">
              </div>
              <div class="col-lg-6">
                <h3>Name:  </h3>
                <p>Email:  </p>
                <p>Books: <a class='normal-a' href="\books?book=bname"></a>
              </div>
            </div>
            <p>Categories: <a class='normal-a' href="\books?book=bname"></a>
          </div>
        </div>

        <div class="pricing-column col-lg-3 col-md-6">
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='small-img' src="images\book.png" alt="">
              </div>
              <div class="col-lg-6">
                <h3>Name:  </h3>
                <p>Email:  </p>
                <p>Books: <a class='normal-a' href="\books?book=bname"></a>
              </div>
            </div>
            <p>Categories: <a class='normal-a' href="\books?book=bname"></a>
          </div>
        </div>

        <div class="pricing-column col-lg-3 col-md-6">
          <div class="card">
            <div class="row card-body">
              <div class="col-lg-6">
                <img class='small-img' src="images\book.png" alt="">
              </div>
              <div class="col-lg-6">
                <h3>Name:  </h3>
                <p>Email:  </p>
                <p>Books: <a class='normal-a' href="\books?book=bname"></a>
              </div>
            </div>
            <p>Categories: <a class='normal-a' href="\books?book=bname"></a>
          </div>
        </div>


      </div>



  </section>

@endsection ('main-section')
