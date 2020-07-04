@extends ('layouts.theme')



@section('title', 'My Profile')

@include('partials.signout')

@include('partials.avatar')

@include('partials.profile')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">

    <div class="container-fluid working-area">

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

             <a title="Profile Image">
               <img class="defbookimg" src="{{Auth::user()->img_path}}" alt="">
             </a>
             <input id="name" type="text" style="visibility:hidden;"class="form-control" name="name" value="{{ old('name', auth()->user()->name) }}">

             <div class="form-group row justify-content-center">
                 
                 <div class="col-md-6">
                   <input id="profile_image" type="file" class="form-control" name="img_path">
                     <!-- @if (auth()->user()->image)
                         <code>{{ auth()->user()->image }}</code>
                     @endif -->
                 </div>
             </div>

             <div class="form-group row mb-0 mt-3 justify-content-center">
                 <div class="col-md-8">
                     <button type="submit" class="btn btn-primary btn-dark">Update Picture</button>
                 </div>
             </div>
           </form>

        </div>

        <div class="col-lg-6 justify-content-center">
          <br><br>
          <h2 class="text-dark">Name :  {{ucwords(Auth::user()->name)}}</h2>
          <br><br>
          <h3 class="text-secondary">Email :  {{Auth::user()->email}}</h2>
          <br><br>
          <h4 class="text-info">{{Auth::user()->readcount}} Books Read</h4>
          <br><br>

        </div>


      </div>


    </div>

  </section>



@endsection ('main-section')
