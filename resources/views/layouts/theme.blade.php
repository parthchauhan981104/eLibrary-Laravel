<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="_token" content="{{ csrf_token() }}">

  <title>eLibrary</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ URL::asset('/') }}css/theme.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/8f9d76b8b8.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">

</head>

  <div class="wrapper">

  <div class="header" id="myHeader">

    <section class="header-section" id="title">
    <div class="container-fluid" >


      <!-- Nav Bar -->

      <nav class="navbar navbar-expand-lg navbar-dark"> <?php //(strpos( url()->current(), "adm" ) ? "/adm" : "/home") ?>
        <a title="Home" class="navbar-brand" href="/home"> <img style="margin-right:3px;" class='userimg' src="{{ URL::asset('/') }}images/logo.png">  eLibrary</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            @yield ("avatar")
            @yield ("profile")
            <li class="nav-item">
              <a class="nav-link" href="/contact">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/about">About Us</a>
            </li>

            @yield ('sign-out')
          </ul>
        </div>
      </nav>

    </div>

  </section>

  </div>
  

@yield ('stats-section')
@yield ('carousel-section')



@yield ('main-section')

<div class="push"></div>

</div>

  <!-- Footer -->

  <footer class="footer-section" id="footer" >
    <div class="container-fluid" >
      <a href="https://www.linkedin.com/in/parth11chauhan/" target="_blank"><img class='userimg' src="{{ URL::asset('/') }}images/creator.png" alt=""></a>
      <p id="footp">© 2020 eLibrary <br>Parth Chauhan</p>
    </div>
  </footer>

  </body>



  </html>
