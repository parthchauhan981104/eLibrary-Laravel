@extends ('layouts.logreg')

  @section ('content')
      <div class="row mainsec">
          <div style="background-color:#303960; border-radius: 1rem; padding:0 4px 0 4px; margin-bottom: 1rem;">
            <h5 class="card-title text-center" style="font-size: 1.8rem; font-family: 'Patua One', cursive; font-weight: lighter;" ><strong>Sign in</strong> to continue</h5>
          </div>
            <form class="form-signin" action="/login" method="POST">
              @csrf
              <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" required autocomplete="email" autofocus>
              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>`
              @enderror


                <input class="form-check-input"  style="position: absolute; margin-top: 0.3rem; margin-left: -1.25rem;" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" style="display:inline-block;" for="remember">Remember Me</label><br>


              <button class="btn btn-lg btn-primary btn-block text-uppercase sign-btn" type="submit">Sign In</button>
              @if (Route::has('password.request'))
                  <a class="btn btn-link" href="{{ route('password.request') }}" style="color:white; margin-top:-5px;">
                      Forgot Your Password?
                  </a>
              @endif

              <hr class="my-4">
              
                <a class="normal-a" href='auth/google'><button type="button" class="btn btn-lg btn-google btn-block text-uppercase ggfb-btn" ><i class="fab fa-google mr-2">  Google</i></button></a>
              
            </form>


      </div>

  @endsection ('content')
