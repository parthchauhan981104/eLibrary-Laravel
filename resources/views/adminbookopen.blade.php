@extends ('layouts.theme')



@section('title', 'Admin - View Book')

@include('partials.signout')



@section ('main-section')
  <!-- Main content-->

  <section class="main-section" id="pricing">

    <div class="container-fluid working-area">

      <form action="/adm/books" method="POST" role="form" enctype="multipart/form-data">
        @csrf

        <div class="row ">


          <div class="pricing-column col-lg-6">
            <br>
            <a title="Default Image">
              <img class="defbookimg" src="\\{{$book->img_path}}" alt="">
            </a>

            <div class="form-group row justify-content-center">
                <div class="col-md-6">
                  <input id="img_path" type="file" class="form-control" name="img_path">

                </div>
            </div>

            <br>
          </div>


          <div class="col-lg-6">

              <br><br>
              <h4>Change Book Name</h4>
              <h6 class="guide">(no special characters)</h6>
              <input class="text-center" id="name" type="text" name="name" value="{{ucwords($book->name)}}" pattern="^[0-9a-zA-z]+( [0-9a-zA-z]+)*" required>
              <br><br><br>

              <h4>Change Author Name</h4>
              <?php $author_name = $book->author->name; ?>
              <h6 class="guide">(no special characters)</h6>
              <input class="text-center" id="author_name" type="text" name="author_name" value="{{ucwords($author_name)}}" pattern="^[0-9a-zA-z]+( [0-9a-zA-z]+)*" required>
              <br><br><br>

              <h4>Change Categories</h4>
              <h6 class="guide">(comma separated)</h6>
              <!-- should be comma separated -->

              <?php

                $categories="";
                $c = $book->categories;
                foreach ($c as $categ) {
                    $categories = $categories . ucwords($categ['name']) . ", ";
                }

              ?>
              <input class="text-center" id="categories" type="text" name="categories" value="{{$categories}}" pattern="^[0-9a-zA-z]+(, [0-9a-zA-z]+)*" required>
              <br><br><br>

              <button type="submit" name="button" id="savebutton" class="btn btn-lg btn-warning">Save Book</button>
              

          </div>

        </div>
      </form>
 

      <form class=""  method="post">
        @csrf
        <button type="submit" name="button" id="deletebutton" class="btn btn-sm btn-danger deletebutton">Delete book</button>
        <br>
        <p id="readp2" class="readp2 text-danger" name="readp" style="visibility:hidden;">Book has been deleted. Redirecting in 4 seconds.</p>
        <input type="text" id="bid" name="name" value="{{$book->id}}" style="visibility: hidden;">
      </form>

        


    </div>


@include('partials.scripts.adminbookopenscript')



  </section>

@endsection ('main-section')
