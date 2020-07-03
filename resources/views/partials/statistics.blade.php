@section ('stats-section')
  <!-- Stats-->

  <section class="stats-section" id="stats">

    <div class="container-fluid statcont" >

      <div class="row" style="text-align: center;">

        <div class="col-lg-4 col-md-12">
          <p class="statsp">{{$numBooks}} BOOKS ADDED</p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp">{{$numReaders}} READERS</p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp">WORKS FROM {{$numAuthors}} AUTHORS</p>
        </div>

      </div>

    </div>

  </section>

@endsection ('stats-section')