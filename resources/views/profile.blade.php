@extends('layouts.app')

@push('script')
<script src="{{ asset('js/mainmap.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
  <div class="centered">
    <img class="profileProfilePicture" src="{{$userThatPrints->profile_picture_url}}" alt="Profielfoto {{$userThatPrints->name}}">
    <h1 class="bigTitle">{{$userThatPrints->name}}
      @if($reputation==1)
        <span data-tippy-content="Dit is een nieuwe printer." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"> &#128153;</span>
      @elseif($reputation==2)
        <span data-tippy-content="Dit is een zeer betrouwbare printer." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"> &#128154;</span>
      @endif
    </h1>
    <div class="biography">
      <p>biogasdfaskdfasd;flkas biogasdfaskdfasdasd asdf</p>
    </div>

  @if(!$userThatPrints->available)
    Niet beschikbaar
  @endif


  <div class="profilePrinterDetails">
    <div class="profileBubble profileAddress">
      <span>
        {{$userThatPrintsAddressInfo->street_and_number}}
        @if($userThatPrintsAddressInfo->bus_number!=0)
        , bus {{$userThatPrintsAddressInfo->bus_number}}
        @endif
        <br>
        {{$userThatPrintsAddressInfo->zip}} {{$userThatPrintsAddressInfo->city}}
      </span>
      <br>
      <a target="_blank" class="darkLink routeLink" href="https://www.google.com/maps/dir/Current+Location/{{$userThatPrintsAddressInfo->lat}},{{$userThatPrintsAddressInfo->lng}}">Route</a>
    </div>
    <div class="profileBubble profilePrinter">
      <p>€{{$printer->price}} per pagina</p>
      <div class="profilePrinterTags">
        @if($printer->color_id==1)
        <span>kleur</span>
        @endif
        @if($printer->color_id==2)
        <span>z/w</span>
        @endif

        @if($printer->format_id==1)
        <span>A4</span>
        @endif
        @if($printer->format_id==2)
        <span>A3</span>
        @endif
      </div>
    </div>
  </div>

  <a href="{{route('printat',[$printer->id])}}" class="button-primary">Print bij mij</a>
  @if(!$favourited)
      <a href="{{ route('user.star', [$userThatPrints->id]) }}" class="button-primary button-red" data-tippy-content="Voeg toe aan favorieten." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle">&#128149;</a>
  @endif


  </div>
</div>
  @include('layouts.footer')
@endsection
