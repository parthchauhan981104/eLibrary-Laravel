@section ('stats-section')
  <!-- Stats-->

  <section class="stats-section" id="stats">

    <div class="container-fluid statcont" style="padding:0; background-color:black;">

      <div class="row" style="text-align: center;">

        <div class="col-lg-4 col-md-12">
          <p class="statsp"><?php echo($numBooks . " BOOKS ADDED"); ?></p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp"><?php echo($numReaders . " READERS"); ?></p>
        </div>
        <div class="col-lg-4 col-md-12">
          <p class="statsp"><?php echo("WORKS FROM " . $numAuthors . " AUTHORS"); ?></p>
        </div>

      </div>

    </div>

  </section>

@endsection ('stats-section')