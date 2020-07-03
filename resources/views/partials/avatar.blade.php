@section ('avatar')
<a title="{{Auth::user()->email}}">
  <img class="userimg" src="{{URL::asset('/')}}{{Auth::user()->img_path}}">
</a>
@endsection ('avatar')