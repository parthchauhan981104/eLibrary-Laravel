@extends ('layouts.theme')



@include('partials.signout')

@include('partials.avatar')

@include('partials.profile')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">

    <div class="container-fluid" style=" border-style: ridge;
      border-color: black;
      border-width: thin;
      background-color: #e5e5e5;
      padding:15px 5px 5px 0;">

      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif

      @if ($errors->any())
          <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>
                          {{ $error }}
                      </li>
                  @endforeach
              </ul>
          </div>
      @endif

      <div class="row ">


        <div class="pricing-column col-lg-6">
          <form action="{{ route('profile.update') }}" method="POST" role="form" enctype="multipart/form-data">
             @csrf

             <a title="Hello">
               <img style="margin:0 0 50px 0; height:60%; width:50%;" src=<?php echo(Auth::user()->img_path) ?> alt="">
             </a>
             <input id="name" type="text" style="visibility:hidden;"class="form-control" name="name" value="{{ old('name', auth()->user()->name) }}">

             <div class="form-group row">
                 <label style="color:black; font-weight:bold;"for="profile_image" class="col-md-4 col-form-label text-md-right">Profile Image</label>

                 <div class="col-md-6">
                   <input id="profile_image" type="file" class="form-control" name="img_path">
                     <!-- @if (auth()->user()->image)
                         <code>{{ auth()->user()->image }}</code>
                     @endif -->
                 </div>
             </div>

             <div class="form-group row mb-0 mt-5">
                 <div class="col-md-8 offset-md-4" style="margin-left:25%;">
                     <button type="submit" class="btn btn-primary btn-dark">Update Picture</button>
                 </div>
             </div>
           </form>

        </div>

        <div class="col-lg-6">
          <br><br>
          <h2><?php echo("Name : " . ucwords(Auth::user()->name)) ?></h2>
          <br><br>
          <h3><?php echo("Email : " . Auth::user()->email) ?></h2>
          <br><br>
          <h4><?php echo(Auth::user()->readcount . " Books Read" ) ?></h4>
          <br><br>

        </div>


      </div>


    </div>

  </section>



@endsection ('main-section')
