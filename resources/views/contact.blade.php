@extends ('layouts.theme')



@section('title', 'Contact Us')

@auth

@include('partials.avatar')

@include('partials.profile')

@include('partials.signout')

@endauth



@section ('stats-section')
  <!-- Stats-->

  <section class="stats-section" id="stats">

    <div class="container-fluid statcont" >

      <div class="row" >

        <div class="col-lg-6 col-md-12" >
          <p class="statsp">24 X 7 Support</p>
        </div>
        <div class="col-lg-6 col-md-12">
          <p class="statsp">Happy Reading</p>
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
            <h1>Contact Us</h1>
          </div>
          <div class="card-body">
            <h4>Email : pc828@snu.edu.in</h4>
            <h4>Phone: 1234567890</h4>
            <br>
            <a href="/home" ><button class="btn btn-lg btn-block btn-dark" type="button">Back to Homepage</button></a>

          </div>
        </div>

  </section>

@endsection ('main-section')
