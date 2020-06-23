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

  <p id="message"><?php echo $message; ?></p>

  <section class="main-section" id="pricing">

    <div class="container-fluid" style=" border-style: ridge;
      border-color: black;
      border-width: thin;
      background-color: #e5e5e5;
      padding:15px 5px 5px 0;">

      <div class="row ">

        <div class="pricing-column col-lg-6">
          <img class='small-img' style="height:300px;width:300px;" src="<?php echo("\\".$book->img_path) ?>" alt="">
        </div>

        <div class="col-lg-6">
          <br><br>
          <h1><?php echo("Name :   " . ucwords($book->name)) ?></h1>
          <br><br>
          <h3><?php echo("Author :   " . ucwords($book->author_name)) ?></h3>
          <br><br>
          <h3>Categories</h3>
          <?php foreach (explode(',', $book->categories) as $categ): ?>
            <h4 style="display: inline-block;">
              <?php echo (ucwords($categ) . " "); ?>
            </h4>
          <?php endforeach; ?>
          <br><br>
        </div>

      </div>

      <?php

      $auth=urlencode($book->author_name);
      $name=urlencode($book->name);
      $categories=urlencode($book->categories);
      $val="unread";

      if(  preg_match( ("/\b" . ( str_replace( " ", "_", $book->auth ) . '-' . str_replace( " ", "_", $book->name ) ) . "\b/i"),  Auth::user()->readbooks) ) {

          $val="read"; ?>

          <p id="readp1" name="readp" style="color:red;">This book has been read by you</p>

        <?php } else{ ?>

          <form class=""  method="post" >
            @csrf
            <button id="readbutton" type="button" class="btn btn-dark readbutton" value=<?php echo($val) ?> name="button"><?php echo("Mark " . ($val==="read" ? "unread" : "read")) ?></button>
            <br>
            <p id="readp2" class="readp2" name="readp" style="color:red; visibility:hidden;">This book has been read by you</p>
            <input type="text" id="val" name="val" value=<?php echo($val) ?> style="visibility: hidden;">
            <input type="text" id="auth" name="auth" value=<?php echo $auth?> style="visibility: hidden;">
            <input type="text" id="name" name="name" value=<?php echo $name?> style="visibility: hidden;">
            <input type="text" id="categories" name="categories" value=<?php echo $categories?> style="visibility: hidden;">
          </form>

        <?php } ?>









    <script type="text/javascript">

      const readbutton = document.getElementById('readbutton');
      const message = document.getElementById('message');
      const valinp = document.getElementById('val');
      const authinp = document.getElementById('auth');
      const nameinp = document.getElementById('name');
      const categinp = document.getElementById('categories');


      function markread(){

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

      readbutton.addEventListener('click', markread);

    </script>

  </section>

@endsection ('main-section')
