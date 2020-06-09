<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">
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
              font-family: 'Montserrat-Bold', sans-serif;
              background-color: #464646;
              color: black;
              background-image: url("\\images\\lib4.jpg");
              /* below code to make image scale proportionally and
              cover whole viewport even while scrolling */
              background-position: center center;
              background-repeat: no-repeat;
              background-attachment: fixed;
              background-size: cover;
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
                font-size: 8rem;
                font-family: "Ubuntu" !important;
                font-weight: bold;
                background: #cb2d3e;  /* fallback for old browsers */
                background: -webkit-linear-gradient(to top, #ef473a, #cb2d3e);  /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to top, #ef473a, #cb2d3e); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                border-style: ridge;
            }

            .links > a, .top-links > a {
                color: white;
                background-color: rgb(199, 0, 57, 0.4);
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
              background-color: rgb(199, 0, 57, 0.8);

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
                   eLibrary
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
