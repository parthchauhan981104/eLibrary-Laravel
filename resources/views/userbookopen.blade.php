@extends ('layouts.theme')

@section ('css-special')
<link rel="stylesheet" href="css\theme.css">
@endsection ('css-special')

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
  <img class="userimg" src=<?php echo("\\".Auth::user()->img_path) ?> >
</a>
@endsection ('avatar')

@section ('profile')
<li class="nav-item">
  <a class="nav-link" href="/profile">Profile</a>
</li>
@endsection ('profile')

@section ('main-section')
  <!-- Main content-->

  <p id="message"><?php echo json_decode($message); ?></p>

  <section class="main-section" id="pricing">

    <div class="container-fluid" style=" border-style: ridge;
      border-color: black;
      border-width: thin;
      background-color: #e5e5e5;
      padding:15px 5px 5px 0;">

      <?php $auth_name = $book->author->name; ?>


      <div class="row ">

        <div class="pricing-column col-lg-6">
          <img class='small-img' style="height:300px;width:300px;" src="<?php echo("\\".$book->img_path) ?>" alt="">
        </div>

        <div class="col-lg-6">
          <br><br>
          <h2><?php echo("Name :   " . ucwords($book->name)) ?></h2>
          <br><br>
          <h3><?php echo("Author :   " . ucwords($auth_name)) ?></h3>
          <br><br>
          <h3>Categories</h3>
          <?php foreach ($book->categories->toArray() as $categ): ?>
            <h4 style="display: inline-block;">
              <?php echo (ucwords($categ['name']) . " "); ?>
            </h4>
          <?php endforeach; ?>
          <br><br>
        </div>

      </div>

      <?php

      $auth=urlencode($auth_name);
      // $name=urlencode($book->name);
      $val="unread";
      $isread = Auth::user()->books->where('id', $book->id)->first();
      // dd($isread);

      if( $isread ) {

          $val="read"; ?>

          <p id="readp1" name="readp" style="color:red;"> <img style="margin:-3px 3px 0 0;" class='userimg' src="{{ URL::asset('/') }}images/tick.png"> This book has been read by you</p>

        <?php } else{ ?>

          <form class=""  method="post" >
            @csrf
            <button id="readbutton" type="button" class="btn btn-dark readbutton" value=<?php echo($val) ?> name="button"><?php echo("Mark " . ($val==="read" ? "unread" : "read")) ?></button>
            <br>
            <p id="readp2" class="readp2" name="readp" style="color:red; visibility:hidden;"><img style="margin:-3px 3px 0 0;" class='userimg' src="{{ URL::asset('/') }}images/tick.png">This book has been read by you</p>
            <input type="text" id="val" name="val" value=<?php echo($val) ?> style="visibility: hidden;">
            <input type="text" id="book_id" name="book_id"" value=<?php echo urlencode($book->id) ?> style="visibility: hidden;">
            <input type="text" id="auth" name="auth" value=<?php echo $auth?> style="visibility: hidden;">
            
            <input type="text" id="user_id" name="user_id" value=<?php echo urlencode(Auth::user()->id) ?> style="visibility: hidden;">
          </form>

        <?php } ?>









    <script type="text/javascript">

      const readbutton = document.getElementById('readbutton');
      const message = document.getElementById('message');
      const valinp = document.getElementById('val');
      const bidinp = document.getElementById('book_id');
      const uidinp = document.getElementById('user_id');
      const authinp = document.getElementById('auth');


      function markread(){

        const val = valinp.value;
        const book_id = bidinp.value;
        const user_id = uidinp.value;
        const auth = authinp.value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET','{{route('mark_read')}}/?val=' + val + '&uid=' + user_id + '&bid=' + book_id + '&auth=' + auth, true);
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

      readbutton.addEventListener('click', markread);

    </script>

  </section>

@endsection ('main-section')
