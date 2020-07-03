@extends ('layouts.theme')



@include('partials.signout')

@include('partials.arrange')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">
    <div class="container-fluid working-area">

      <form class="" action="/readers" method="post">
        @csrf
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search all readers...">
        <br>

      </form>

      <?php
        $contents =  array();
      ?>

            <?php
            foreach ($readers as $reader):
            ?>

              <?php ob_start(); ?>



            <div class="card">
                <div class="row">
                    <?php

                      $reader_img = "images\users\user.png";

                      if (file_exists("{{ URL::asset('/') }}images/users/" . $reader->email . ".png")) {
                          $reader_img = "{{ URL::asset('/') }}images/users/" . $reader->email . ".png" ;
                      } elseif (file_exists("{{ URL::asset('/') }}images/users/" . $reader->email . ".jpg")) {
                          $reader_img = "{{ URL::asset('/') }}images/users/" . $reader->email . ".jpg" ;
                      } elseif (file_exists("{{ URL::asset('/') }}images/users/" . $reader->email . ".gif")) {
                          $reader_img = "{{ URL::asset('/') }}images/users/" . $reader->email . ".gif" ;
                      }?>

                    <a title="{{$reader->email}}">
                      <img class='userimg' src="{{$reader_img}}">
                    </a>

                </div>

                <div class="row" style="display:block;">

                        <h3>Name :  {{ucwords($reader->name)}}</h3>
                        <p>Email :  {{$reader->email}}</p>
                        <p>{{$reader->readcount}} Books Read</p>

                </div>

          </div>



              <?php $content = ob_get_clean(); ?>




              <?php array_push($contents, $content);?>


            <?php
              endforeach;
            ?>


          <div id="tbody">
            <?php Arrange(sizeof($readers), $contents);   ?>
          </div>




      <script type="text/javascript">
          const search = document.getElementById('searchbar');
          const tableBody = document.getElementById('tbody');
          function getContent(){

            const searchValue = search.value;

                const xhr = new XMLHttpRequest();
                xhr.open('GET','{{route('search_readers')}}/?search=' + searchValue  ,true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function() {

                    if(xhr.readyState == 4 && xhr.status == 200)
                    {
                        tableBody.innerHTML = xhr.responseText;
                        console.log(xhr.responseText);
                    }
                }
                xhr.send()
          }
          search.addEventListener('input',getContent);

      </script>



  </section>

@endsection ('main-section')
