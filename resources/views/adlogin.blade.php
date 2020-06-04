<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <title>Admin LogIn</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href='css\login.css'>
  <script src="https://kit.fontawesome.com/8f9d76b8b8.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">

</head>

<body>

    <!-- <img class="covr-img" src="images\lib4.jpg" alt="cover"> -->
    <div class="container-fluid">
      <!-- Nav Bar -->
      <div class="row navb">
         <nav class="navbar navbar-expand-lg navbar-dark">
           <a class="navbar-brand" href="/">eLibrary</a>
         </nav>
      </div>
      <!-- Title -->

      <div class="row mainsec">
        <div style="background-color:#303960; border-radius: 1rem; padding:0 4px 0 4px; margin-bottom: 1rem;">
          <h5 class="card-title text-center" style="font-size: 1.8rem; font-family: 'Patua One', cursive; font-weight: lighter;" ><strong>Hey</strong> Admin</h5>
        </div>
            <form class="form-signin" action="/adlogin" method="POST">
              @csrf

              <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>

              <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>


              <input type="checkbox" id="remember" name="remember" value="Remember">
              <label for="remember"> Remember me</label><br>

              <button class="btn btn-lg btn-primary btn-block text-uppercase sign-btn" type="submit">Sign In</button>

            </form>


      </div>

    </div>


      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </body>

    </html>
