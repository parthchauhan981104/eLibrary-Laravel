@extends ('layouts.theme')



@include('partials.signout')

@include('partials.avatar')

@include('partials.profile')

@include('partials.arrange')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">
    <div class="container-fluid" style=" border-style: ridge;
      border-color: black;
      border-width: thin;
      background-color: #e5e5e5;
      padding:15px 5px 5px 0;">

      <form class="" action="/books" method="post">
        @csrf
        <input  id="searchbar" type="text" name="searchbar" value="" placeholder="Search my books...">
        <br>

          <?php
            $i=1;
            foreach ($allCategories as $categ) {
              if ($categ->name!="") { ?>

                <div class="category" style="display:inline-block; margin: 0 3px 0 3px;">
                  <input type="radio" name="catradios" value=<?php echo($categ->name); ?> id=<?php echo("cat" . $i); ?> >
                  <label style="color:black" for=<?php echo("cat" . $i); ?> class='cat-check'><?php echo(ucwords($categ->name)); ?></label>
                </div>

        <?php $i++; }
            } ?>
            <div class="category" style="display:inline-block; margin: 0 3px 0 3px;">
              <input type="radio" name="catradios" value="all" id="catall" checked>
              <label style="color:blue" for="catall" class='cat-check'>All</label>
            </div>

      </form>



<?php
  $contents =  array();
?>

      <?php
      foreach ($myBooks as $book):
      ?>

        <?php ob_start(); ?>

            <div class="card h-100">
              <div class="row card-body">
                <div class="col-lg-6">
                  <img class='book-img' src=<?php echo ($book['img_path']); ?> alt="">
                </div>
                <div class="col-lg-6" style="padding:0;">
                  <h3><?php echo (ucwords($book['name'])); ?></h3>
                  <p>
                    <?php echo ("By " . ucwords($book->author->name)); ?>
                  </p>
                  <br>

                  <?php foreach (array_slice($book->categories->toArray(), 0, 3) as $categ): ?>
                    <h4 style="display:inline-block; margin-right:10px;">
                      <?php echo (ucwords($categ['name']) . " "); ?>
                    </h4>
                  <?php endforeach; ?>

                </div>
              </div>


              <div class="card-footer text-muted mx-auto" style="width:100%;margin-top:5px;">
                <a class='normal-a' href=<?php echo ("\books\\" . urlencode($book->author->name) . "\\" . urlencode($book->name)); ?> >
                  <button class="btn btn-lg btn-block btn-dark open-button" style="" type="button">
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
        <?php Arrange(sizeof($myBooks), $contents);   ?>
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
                xhr.open('GET','{{route('search_my_books')}}/?search=' + searchValue + '&categ=' + category ,true);
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
            for (const radiob of categoriesradiob) {
                radiob.addEventListener("click", getContent);
            }
</script>



  </section>

@endsection ('main-section')
