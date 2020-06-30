@extends ('layouts.theme')



@auth

@include('partials.avatar')

@include('partials.profile')

@include('partials.signout')

@endauth



@section ('stats-section')
  <!-- Stats-->

  <section class="stats-section" id="stats">

    <div class="container-fluid statcont" style="padding:0; background-color:black;">

      <div class="row" >

        <div class="col-lg-4 col-md-12" >
          <p class="statsp">New Books Everyday</p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp">Track Your Read Books</p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp">Personalized Alerts</p>
        </div>

      </div>

    </div>

  </section>

@endsection ('stats-section')


@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">


        <div class="card">
          <div class="card-header">
            <h1>About Us</h1>
          </div>
          <div class="card-body">
            <h3>Who We Are</h3>
            <p>
              eLibrary is the new and trending site for readers.<br>
              Our mission is to help people explore and keep track of the books they love.<br>
              eLibrary was launched in June 2020.
            </p>
            <br>
            <h3>A Few Things You Can Do On eLibrary</h3>
            <p>
              See what books are read by most people and the top readers.<br>
              Track the books you have read and explore new books.<br>
              See which authors are being read most and the top categories.
            </p>
            <a href="/" style='color:white;'><button class="btn btn-lg btn-block btn-dark" type="button">Back to Homepage</button></a>

          </div>
        </div>


  </section>

@endsection ('main-section')
