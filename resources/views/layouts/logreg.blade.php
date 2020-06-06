<!DOCTYPE html>

<?php
  $link = 'login';
  $uri = ltrim($_SERVER['REQUEST_URI'], '/');

  if ( $uri === '' or $uri === 'login' ){

    $link='register';

    if ( $uri === ''){
      $uri='login';
    }

  }

?>

<html>

<head>
  <meta charset="utf-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title><?php echo ('eLibrary ' . ucwords($uri)); ?></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href=<?php echo ('css\\' . $uri . '.css'); ?>>
  <script src="https://kit.fontawesome.com/8f9d76b8b8.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">
</head>

<body>

    <!-- <img class="covr-img" src="images\lib4.jpg" alt="cover"> -->
    <div class="container-fluid">
      <!-- Nav Bar -->
      <div class="row navb">
         <nav class="navbar navbar-expand-lg navbar-dark ">
           <a class="navbar-brand" href="/">eLibrary</a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto bg-custom" style=" background-color: rgb(199, 0, 57); " >
            <li class="nav-item">
              <a class="nav-link" style="color:white;" href=<?php echo '/'.$link ?> ><?php echo (ucwords($link)); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="color:white;" href="/about">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="color:white;" href="/contact">Contact Us</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" style="color:white;" href="/adlogin">Admin</a>
            </li> -->

          </ul>
        </div>
         </nav>
      </div>
      <!-- Title -->

    @yield ('content')

    </div>


      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </body>

    </html>
