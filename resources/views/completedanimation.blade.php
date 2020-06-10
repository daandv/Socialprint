@extends('layouts.app')

@push('script')

<script defer>
$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "./home";
    }, 1500);
});
</script>
@endpush

@section('content')

<div class="verifiedwrapper">

  <svg id="checkmark" width="73px" height="73px" data-name="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 73.8 73.8">
    <g id="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
      <circle id="filled-circle" fill="#FF0066" cx="36.9" cy="36.9" r="26.9"/>
      <circle id="white-circle" fill="#FFFFFF" cx="36.9" cy="36.9" r="26.9"/>
      <circle id="outline" stroke="#FF0066" stroke-width="5" cx="36.9" cy="36.9" r="26.9"/>
      <polygon id="check" fill="#FFFFFF" points="30.29 53.81 17.33 40.85 23.42 34.77 30.29 41.64 50.38 21.54 56.47 27.63 30.29 53.81"/>
    </g>
  </svg>

</div>

@include('layouts.footer')

@endsection
