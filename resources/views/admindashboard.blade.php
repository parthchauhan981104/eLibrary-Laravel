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

@section ('stats-section')

  <!-- Stats-->

  <section class="stats-section" id="stats">

    <div class="container-fluid statcont" style="padding:0; background-color:black;">

      <div class="row" >

        <div class="col-lg-4 col-md-12" >
          <p class="statsp">Number of books</p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp">Number of readers</p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp">Number of authors</p>
        </div>

      </div>

    </div>

  </section>

@endsection ('stats-section')


@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">


    <div class="row">

      <div class="pricing-column col-lg-6 col-md-12">
        <div class="card ">
          <div class="card-header">
            <h3>Top Books</h3>
          </div>
          <div class="card-body">
            <p>5 Matches Per Day</p>
            <p>10 Messages Per Day</p>
            <p>Unlimited App Usage</p>
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
            <p>Priority Listing</p>
            <p>Unlimited Matches</p>
            <p>Unlimited Messages</p>
            <a class='normal-a' href="/readers">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all readers</button>
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
            <p>Unlimited Matches</p>
            <p>Unlimited Messages</p>
            <p>Unlimited App Usage</p>
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
            <p>Unlimited Matches</p>
            <p>Unlimited Messages</p>
            <p>Unlimited App Usage</p>
            <a class='normal-a' href="/categories">
              <button class="btn btn-lg btn-block btn-dark" type="button">See all categories</button>
            </a>
          </div>
        </div>
      </div>

    </div>

    <div class="">
      <p style="color:white; font-size:2rem;">Add Book</p>
      <a style="margin: 50px 40px 0 50px;" href="/addbook"><img style="height:130px; width:130px; color:white;" src="images\add.png" alt="add book"></a>

    </div>



  </section>



@endsection ('main-section')
