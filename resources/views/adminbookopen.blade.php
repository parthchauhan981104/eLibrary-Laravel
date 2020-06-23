@extends ('layouts.theme')



@section ('sign-out')
<li class="nav-item">
  <a class="nav-link" href="/logout" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
    Sign Out
  </a>
</li>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection ('sign-out')

@section ('avatar')
<a title=<?php echo(Auth::user()->email) ?>>
  <img class="userimg" src=<?php echo(Auth::user()->img_path) ?> >
</a>
@endsection ('avatar')

@section ('profile')
<li class="nav-item">
  <a class="nav-link" href="/profile">Profile</a>
</li>
@endsection ('profile')

@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">

    <div class="container-fluid" style=" border-style: ridge;
      border-color: black;
      border-width: thin;
      background-color: #e5e5e5;
      padding:15px 5px 5px 0;">

      <form class="form-signin" action="/admviewbook" method="POST" role="form" enctype="multipart/form-data">
        @csrf

        <div class="row ">


          <div class="pricing-column col-lg-6">
            <img  style="margin:0 0 50px 0; height:50%; width:50%;" src="images\book1.jpg" alt="">
            <br>
            <button type="button" name="button">Change picture</button>
          </div>


          <div class="col-lg-6">

              <p>Change Name</p>
              <input type="text" id='bookname' name="bookname" value=<?php echo (ucwords($book->name)); ?> pattern="^[0-9a-zA-z]*" >
              <br>
              <p>Change Author</p>
              <input type="text" name="" id="author_name" value=<?php echo (ucwords($book->author_name)); ?> pattern="^[0-9a-zA-z]*">
              <br>
              <p>Change Categories</p>
              <h6 style="font-size: 0.8rem; margin-top: -8px;">(comma separated)</h6>
              <!-- should be comma separated -->
              <input type="text" name="" id='categories' value=<?php echo (str_replace(',' , ', ' , ucwords($book->categories))); ?> pattern="^[0-9a-zA-z]+(, [0-9a-zA-z]+)*">
              <br><br>
              <button type="submit" name="button">Submit</button>
              <br><br><br>

            </form>

            <form class=""  method="post">
              <button type="submit" name="button">Delete book</button>
              <br>
              <p id="readp2" class="readp2" name="readp" style="color:red; visibility:hidden;">Book has been deleted. Redirecting in 4 seconds.</p>
              <input type="text" id="auth" name="auth" value=<?php echo $auth?> style="visibility: hidden;">
              <input type="text" id="name" name="name" value=<?php echo $name?> style="visibility: hidden;">
            </form>
          </div>

        </div>



      <div class="readers" style="display:inline-block;">
        <?php foreach (array_slice(explode(',', $book->readers_email), 0, 8) as $reader): ?>

            <?php
              if($reader != "") {
                $reader_img = "images\users\user.png";
                if (file_exists("images\users\\" . $reader . ".png")) {
                  $reader_img = "images\users\\" . $reader . ".png" ;
                } elseif (file_exists("images\users\\" . $reader . ".jpg")) {
                  $reader_img = "images\users\\" . $reader . ".jpg" ;
                } elseif (file_exists("images\users\\" . $reader . ".gif")) {
                $reader_img = "images\users\\" . $reader . ".gif" ;
              } elseif (file_exists("images\users\\" . $reader . ".jpeg")) {
                $reader_img = "images\users\\" . $reader . ".jpeg" ;
                }?>
                <a title=<?php echo($reader); ?>>
                  <img class='userimg' src=<?php echo($reader_img); ?>>
                </a>
              <?php } ?>

        <?php endforeach; ?>
      </div>

    </div>

    <script type="text/javascript">

      const readbutton = document.getElementById('readbutton');
      const message = document.getElementById('message');
      const valinp = document.getElementById('val');
      const authinp = document.getElementById('auth');
      const nameinp = document.getElementById('name');
      const categinp = document.getElementById('categories');


      function edit(){

        const val = valinp.value;
        const auth = authinp.value;
        const name = nameinp.value;
        const categ = categinp.value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET','{{route('mark_read')}}/?val=' + val + '&auth=' + auth + '&name=' + name + '&categ=' + categ ,true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {

            if(xhr.readyState == 4 && xhr.status == 200)
            {
                message.innerHTML = xhr.responseText;
                $(".readbutton").css("visibility", "hidden");
                $(".readp2").css("visibility", "visible");
                console.log(xhr.responseText);
            }
        }
        xhr.send()

      }

      readbutton.addEventListener('click', edit);

    </script>

  </section>

@endsection ('main-section')
