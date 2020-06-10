@extends('layouts.app')

@push('script')
<script src="{{ asset('js/mainmap.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
  @if(!$userThatPrints->available)
    Niet beschikbaar
  @endif
  <p>{{$userThatPrints->name}}</p>
  @if($favourited)
      <a href="{{ route('user.unstar', [$userThatPrints->id]) }}">unstar</a>
  @else
      <a href="{{ route('user.star', [$userThatPrints->id]) }}">star</a>
  @endif

  <p>{{$userThatPrintsAddressInfo}}</p>

</div>
@endsection
