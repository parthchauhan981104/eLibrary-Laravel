<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
        <!-- Styles -->
        <style>
            html{
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            body{
              font-weight: 200;
              height: 100vh;
              margin: 0;
              font-family: 'Exo 2', sans-serif;
              background-color: #222222;
              color: black;

            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                color: white;
                font-size: 7rem;
                font-family: 'Exo 2', sans-serif !important;
                font-weight: bold;
                background: #F19A1A;
                padding:10px;
 
                color: white;
                border-style: ridge;
            }

            .links > a, .top-links > a {
                color: white;
                background-color: rgb(255, 51, 119);
                border-radius: 40%;
                padding: 10px 25px;
                font-family: 'Prompt', sans-serif;
                font-size: 15px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                margin: 5px;
                }

            .top-links > a{
              background-color: #EC454F;

            }

            .links > a:hover, .top-links > a:hover {
              color:grey;
            }



            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
      <div class="container-fluid ">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right top-links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                   <img style="margin-right:10px; height:100px; width:100px;" src="{{ URL::asset('/') }}images/logo.png">eLibrary
                </div>

                <div class="links">
                    <a href="/contact">Contact Us</a>
                    <a href="/about">About Us</a>
                </div>
            </div>
        </div>
      </div>

    </body>
</html>
