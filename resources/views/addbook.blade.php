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
      <form class="form-signin" action="/addbook" method="POST">
        @csrf



      <div class="row ">



          <div class="pricing-column col-lg-6">
            <img  style="margin:0 0 50px 0; height:50%; width:50%; " src="images\books\book1.jpg" alt="">
            <br>
            <button type="button" class="btn btn-lg btn-light" name="changepic">Change picture</button>
          </div>



          <div class="col-lg-6">

              <p>Enter Book Name</p>
              <input type="text" name="bookname" value="" required>
              <br>
              <p>Enter Author Name</p>
              <input type="text" name="author_name" value="" required>
              <br>
              <p>Add Categories</p>
              <h6 style="font-size: 0.8rem; margin-top: -8px;">(comma separated)</h6>
              <!-- should be comma separated -->
              <input type="text" name="categories" value="" pattern="^[0-9a-zA-z]+(, [0-9a-zA-z]+)*" required>
              <br><br>
              <button type="submit" name="button" class="btn btn-lg btn-dark">Submit</button>
              <br><br>

          </div>

        </form>

      </div>


    </div>

  </section>

@endsection ('main-section')
