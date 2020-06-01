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

  <section class="main-section" id="pricing">

    <div class="container-fluid" style=" border-style: ridge;
      border-color: black;
      border-width: thin;
      background-color: #e5e5e5;
      padding:15px 5px 5px 0;">

      <div class="row ">

        <div class="pricing-column col-lg-6">
          <img class='small-img' src="images\book.png" alt="">
        </div>

        <div class="col-lg-6">
          <br><br><br><br>
          <h1>Name</h1>
          <br><br>
          <h3>Author: <a class='normal-a' href="\authors?auth=aname">aname</a>
          </h3>
          <br><br>
          <h4> <a class='normal-a' href="\categories?categ=categ">categ</a> </h4>
        </div>

      </div>

      <form class="" action="/books" method="post">
        @csrf
        <button type="submit" class="btn btn-light" name="button">Mark as read</button>
      </form>

      <div class="readers">
        <p>Readers <br> <img class='userimg' src="images\user.png" alt=""></p>
      </div>

    </div>

  </section>

@endsection ('main-section')
