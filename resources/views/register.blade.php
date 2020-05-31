@extends ('layouts.logreg')


  @section ('content')
      <div class="row mainsec">
        <div style="background-color:#303960; border-radius: 1rem; padding:0 12px 0 12px; margin-bottom: 1rem;">
          <h5 class="card-title text-center" style="font-size: 1.8rem;font-family: 'Patua One', cursive; font-weight: lighter;" ><strong>Register</strong> your account</h5>
        </div>
            <form class="form-signin" action="/register" method="POST">
              @csrf

              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full Name" value="{{ old('name') }}" required autocomplete="name" autofocus>
              @error('name')
                  <span class="invalid-feedback" style="color:white;" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror

              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-Mail Address" >
              @error('email')
                  <span class="invalid-feedback" style="color:white;" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror

              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password" >
              @error('password')
                  <span class="invalid-feedback" style="color:white;" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror

              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" >
              <!-- <button type="button" name="button" onclick="return Validate()">Check</button> -->

              <button class="btn btn-lg btn-primary btn-block text-uppercase reg-btn" type="submit" onclick="return Validate()">Register</button>

              <hr class="my-4">
              <button class="btn btn-lg btn-google btn-block text-uppercase ggfb-btn" type="submit"><i class="fab fa-google mr-2"></i>Google</button>

              <button class="btn btn-lg btn-facebook btn-block text-uppercase ggfb-btn" type="submit"><i class="fab fa-facebook-f mr-2"></i>Facebook</button>
            </form>


      </div>

      <script type="text/javascript">
        function Validate() {
            var password = document.getElementById("inputPassword").value;
            var confirmPassword = document.getElementById("inputConfirmPassword").value;
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
      </script>

  @endsection ('content')
