@extends ('layouts.theme')



@include('partials.signout')

@include('partials.avatar')

@include('partials.profile')


@include('partials.arrange')



@section ('main-section')
  <!-- Main content-->

  @if (session('status'))
    <div class="alert alert-success">
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

  <section class="main-section" id="pricing">
    <div class="container-fluid working-area">


      <form class="" action="/books" method="post">
        @csrf
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search all books...">
        <br>

          <?php
            $i=1;
            foreach ($allCategories as $categ) {
              if ($categ->name!="") { ?>

                <div class="category" style="display:inline-block; margin: 0 3px 0 3px;">
                  <input type="radio" name="catradios" value="{{$categ->name}}" id="cat{{$i}}" >
                  <label style="color:black" for="cat{{$i}}" class='cat-check'>{{ucwords($categ->name)}}</label>
                </div>

        <?php $i++; }
            } ?>
            <div class="category" style="display:inline-block; margin: 0 3px 0 3px;">
              <input type="radio" name="catradios" value="all" id="catall" checked>
              <label style="color:#1644ad" for="catall" class='cat-check'>All</label>
            </div>


      </form>


<?php
  $contents =  array();
?>

      <?php
      foreach ($books as $book):
      ?>

        <?php ob_start(); 
        ?>

            <div class="card h-100">
              <div class="row card-body">
                <div class="col-lg-6">
                  <img class='book-img' src="{{$book->img_path}}" alt="">
                </div>
                <div class="col-lg-6" style="padding:0;">
                  <h3>{{ucwords($book->name)}}</h3>
                  <p>
                     By {{ ucwords($book->author->name)}}
                  </p>
                  <br>

                  <?php foreach (array_slice($book->categories->toArray(), 0, 3) as $categ): ?>
                    <h4 style="display:inline-block; margin-right:10px;">
                      <?php echo (ucwords($categ['name']) . " "); ?>
                    </h4>
                  <?php endforeach; ?>

                </div>
              </div>


              <div class="readers" style="display:inline-block;">
                <?php foreach (array_slice($book->users->toArray(), 0, 8) as $reader): ?>

                    <?php
                    // dd($reader);
                      $reader_img = "images\users\user.png";
                      if (file_exists("images\users" . '/' . $reader['email'] . ".png")) {
                        $reader_img = "images\users"  . '/' . $reader['email'] . ".png" ;
                      } elseif (file_exists("images\users" . '/'  . $reader['email'] . ".jpg")) {
                        $reader_img = "images\users"  . '/' . $reader['email'] . ".jpg" ;
                      } elseif (file_exists("images\users" .  '/' . $reader['email'] . ".gif")) {
                        $reader_img = "images\users"  . '/' . $reader['email'] . ".gif" ;
                      } elseif (file_exists("images\users" .  '/' . $reader['email'] . ".jpeg")) {
                        $reader_img = "images\users"  . '/' . $reader['email'] . ".jpeg" ;
                      }
                    ?>
                    <a title="{{$reader['email']}}">
                          <img class='userimg' src="{{$reader_img}}">
                    </a>

                <?php endforeach; ?>
              </div>

              <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
              <a class='normal-a' href="\books\{{urlencode($book->author->name)}}\{{urlencode($book->name)}}" >
                <button class="btn btn-lg btn-block btn-dark open-button" type="button">
                  Open
                </button>
              </a>
            </div>
            </div>


        <?php $content = ob_get_clean(); ?>




        <?php array_push($contents, $content);?>


      <?php
        endforeach;
      ?>


    <div id="tbody">
      <?php Arrange(sizeof($books), $contents);   ?>
    </div>





<script type="text/javascript">
            const search = document.getElementById('searchbar');
            const tableBody = document.getElementById('tbody');
            var categoriesradiob = $('input[name="catradios"]');
            function getContent(){

              const searchValue = search.value;
              var checked = categoriesradiob.filter(function() {
                return $(this).prop('checked');
              });
              const category = checked.val();


                  const xhr = new XMLHttpRequest();
                  xhr.open('GET','{{route('search_books')}}/?search=' + searchValue + '&categ=' + category ,true);
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
            search.addEventListener('input', getContent);
            for (const radiob of categoriesradiob) {
                radiob.addEventListener("click", getContent);
            }

</script>





  </section>




@endsection ('main-section')
