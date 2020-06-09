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
  <a href="{{ route('user.star', [$userThatPrints->id]) }}">star</a>
  <a href="{{ route('user.star', [$userThatPrints->id]) }}">unstar</a>
  <p>{{$userThatPrintsAddressInfo}}</p>
</div>
@endsection
