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

      <div class="row ">

        <div class="pricing-column col-lg-6">
          <img  style="margin:0 0 50px 0; height:50%; width:50%;" src="images\book1.jpg" alt="">
          <br>
          <button type="button" name="button">Change picture</button>
        </div>



        <div class="col-lg-6">
          <form class="form-signin" action="/admviewbook" method="POST">
            @csrf
            <p>Change Name</p>
            <input type="text" name="" value="name" >
            <br>
            <p>Change Author</p>
            <input type="text" name="" value="author">
            <br>
            <p>Change Categories</p>
            <!-- should be comma separated -->
            <input type="text" name="" value="categories">
            <br><br>
            <button type="submit" name="button">Submit</button>
            <br><br>
            <button type="submit" name="button">Delete book</button>
          </form>
        </div>

      </div>



      <div class="readers">
        <p>Readers <br> <img class='userimg' src="images\user.png" alt=""></p>
      </div>

    </div>

  </section>

@endsection ('main-section')
