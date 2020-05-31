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
          <a title="Hello">
            <img  style="margin:0 0 50px 0; height:50%; width:50%;" src="images\users\user.png" alt="">
          </a>
          <br>
          <button class="btn btn-light" type="button" name="button">Change picture</button>
        </div>

        <div class="col-lg-6">
          <form class="form-signin" action="/profile" method="POST">
            @csrf
            <br>
            <h1>Name</h1>
            <br><br>
            <p>Email</p>
            <p>xyz@abc.com</p>
            <br><br>
            <p>Change Password</p>
            <input type="password" id="inputPassword" name="inputPassword" placeholder="Enter new password">
            <br>
            <p>Confirm new Password</p>
            <input type="password" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="Confirm password">
            <br><br>
            <button class="btn btn-dark" type="submit" name="button" onclick="return Validate()">Submit</button>
          </form>

        </div>

      </div>


    </div>

  </section>

  <script type="text/javascript">
    function Validate() {
        var password = document.getElementById("inputPassword").value;
        var confirmPassword = document.getElementById("inputConfirmPassword").value;
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
  </script>


@endsection ('main-section')
