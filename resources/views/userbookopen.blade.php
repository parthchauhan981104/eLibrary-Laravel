@extends ('layouts.theme')



@include('partials.avatar')

@include('partials.profile')

@include('partials.signout')



@section ('main-section')
  <!-- Main content-->

  <div class="alert alert-success" style="visibility: hidden">
      <p id="message">{{$message}}</p>
  </div>
    

  <section class="main-section" id="pricing">

    <div class="container-fluid working-area">

      <?php $authName = $book->author->name; ?>


      <div class="row ">

        <div class="pricing-column col-lg-6">
          <img class='small-img' style="height:300px;width:300px;" src="\{{$book->img_path}}" alt="">
        </div>

        <div class="col-lg-6">
          <br><br>
          <h2>{{ucwords($book->name)}}</h2>
          <br>
          <h4 class="text-dark">By {{ ucwords($authName)}}</h4>
          <br>
          
          <?php foreach ($book->categories->toArray() as $categ): ?>
            <h4 style="font-size:1.5rem; display: inline-block;" class="mx-2 my-1 text-success">{{ucwords($categ['name'])}} </h4>
          <?php endforeach; ?>
          <br>
          <h4 style="font-size:1rem; "class="my-5 text-info">Read by {{ucwords($book->readerscount)}} readers</h3>
          <br>
        </div>

      </div>

      <?php

      $auth=urlencode($authName);
      // $name=urlencode($book->name);
      $val="unread";
      $isread = Auth::user()->books->where('id', $book->id)->first();
      // dd($isread);

      if ($isread) {
          $val="read"; ?>

          <p id="readp1" name="readp" class="text-danger"> <img style="margin:-3px 3px 0 0;" class='userimg' src="{{ URL::asset('/') }}images/tick.png"> This book has been read by you</p>

        <?php
      } else { ?>

          <form class=""  method="post" >
            @csrf
            <button id="readbutton" type="button" class="btn btn-success readbutton" value="{{$val}}" name="button"><?php echo("Mark " . ($val==="read" ? "unread" : "read")) ?></button>
            <br>
            <p id="readp2" class="readp2 text-danger" name="readp" style="visibility:hidden;"><img style="margin:-3px 3px 0 0;" class='userimg' src="{{ URL::asset('/') }}images/tick.png">This book has been read by you</p>
            <input type="text" id="val" name="val" value="{{$val}}" style="visibility: hidden;">
            <input type="text" id="book_id" name="book_id" value="{{urlencode($book->id)}}" style="visibility: hidden;">
            <input type="text" id="auth" name="auth" value="{{$auth}}" style="visibility: hidden;">
            
            <input type="text" id="user_id" name="user_id" value="{{urlencode(Auth::user()->id)}}" style="visibility: hidden;">
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
                $(".alert-success").css("visibility", "visible");
                message.innerHTML = JSON.parse(xhr.responseText);
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
