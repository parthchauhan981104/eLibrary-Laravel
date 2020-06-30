  @section ('carousel-section')
  <!-- Features -->

  <section class="carousel-section" id="features">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active container-fluid">
              <h2 class="carousel-text">New books added everyday</h2>
              <img class="carousel-img" src="images\book.png" alt="new books">
            </div>
            <div class="carousel-item container-fluid">
              <h2 class="carousel-text">Keep track of your read books</h2>
              <img class="carousel-img" src="images\list.jpg" alt="keep track">
            </div>
            <div class="carousel-item container-fluid">
              <h2 class="carousel-text">Receive personalized alerts</h2>
              <img class="carousel-img" src="images\alerts.jpg" alt="alerts">
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>

  </section>

@endsection ('carousel-section')