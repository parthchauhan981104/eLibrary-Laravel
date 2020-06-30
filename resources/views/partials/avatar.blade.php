@section ('avatar')
<a title="<?php echo(Auth::user()->email) ?>">
  <img class="userimg" src="{{ URL::asset('/') }}<?php echo(Auth::user()->img_path) ?>"  >
</a>
@endsection ('avatar')