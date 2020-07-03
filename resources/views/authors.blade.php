@extends ('layouts.theme')



@include('partials.signout')

@include('partials.avatar')

@include('partials.profile')


@include('partials.arrange')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">
    <div class="container-fluid working-area">

      <form class="" action="/books" method="post">
        @csrf
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search all authors...">

      </form>




      <?php
        $contents =  array();
      ?>

      <?php
      foreach ($authors as $author):
      ?>


              <?php ob_start(); ?>

                  <div class="card h-100">
                    <div class="row card-body">
                      <div class="col-lg-6">
                        <img class='book-img' src="images\author-icon.jpg" alt="">
                      </div>
                      <div class="col-lg-6" style="padding:0;">
                        <h3><?php echo(ucwords($author->name)); ?></h3>
                        <p>
                          <?php echo($author->bookscount . " Books"); ?>
                        </p>
                        <p>
                          <?php echo($author->readcount . " Readers"); ?>
                        </p>
                        <br>

                          


                      </div>
                    </div>
                  </div>


              <?php $content = ob_get_clean(); ?>


              <?php array_push($contents, $content);?>


            <?php
              endforeach;
            ?>

            <div id="tbody">
        <?php Arrange(sizeof($authors), $contents);   ?>
      </div>


<script type="text/javascript">
            const search = document.getElementById('searchbar');
            const tableBody = document.getElementById('tbody');
            function getContent(){

            const searchValue = search.value;

                const xhr = new XMLHttpRequest();
                xhr.open('GET','{{route('search_authors')}}/?search=' + searchValue ,true);
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
