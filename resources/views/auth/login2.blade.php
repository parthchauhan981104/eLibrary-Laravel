@extends ('logreg')

  @section ('content')
      <div class="row mainsec">
          <div style="background-color:#303960; border-radius: 1rem; padding:0 4px 0 4px; margin-bottom: 1rem;">
            <h5 class="card-title text-center" style="font-size: 1.8rem; font-family: 'Patua One', cursive; font-weight: lighter;" ><strong>Sign in</strong> to continue</h5>
          </div>
            <form class="form-signin" action="/login" method="POST">
              @csrf
              <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

              <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>



              <input type="checkbox" id="remember" name="Rememberme" value="Remember">
              <label for="remember"> Remember me</label><br>

              <button class="btn btn-lg btn-primary btn-block text-uppercase sign-btn" type="submit">Sign In</button>

              <hr class="my-4">
              <button class="btn btn-lg btn-google btn-block text-uppercase ggfb-btn" type="submit"><i class="fab fa-google mr-2"></i>Google</button>

              <button class="btn btn-lg btn-facebook btn-block text-uppercase ggfb-btn" type="submit"><i class="fab fa-facebook-f mr-2"></i>Facebook</button>
            </form>


      </div>

  @endsection ('content')
