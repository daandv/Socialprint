@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountedit.js') }}" defer></script>
@endpush


@section('content')
<div class="container">

  <div class="centeredDiv">
    <h1 class="biGTitle">Mijn account</h1>
  </div>


  @if($available)
    <a href="./notavailable">Ik wil niet meer printen</a>
  @else
    <a href="./setavailable">Ik wil weer printen</a>
  @endif

  <form action="{{ route('update.storeprinter') }}" method="POST">
    @csrf
    <label for="name">Naam</label>
    <input type="text" id="name" class="form-control" name="name" value="{{$name}}">

    <label for="address">Straat + nr</label>
    <input class="algoliabox" type="text" id="address" class="form-control" name="address" value="{{$address}}">

    <label for="city">Gemeente</label>
    <input type="text" id="city" class="form-control" name="city" value="{{$city}}" readonly>

    <br>
    <div id="minimap"></div>
    <br>

    <label><input type="radio" name="printColor" id="color" value="color"
      @if($colorId===1)
      checked
      @endif
      >Kleur</label>
    <label><input type="radio" name="printColor" id="bw" value="bw"
      @if($colorId===2)
      checked
      @endif
      >Zwart-wit</label>

    <br>

    <label for="pp">Prijs per pagina</label>
    <input id="pp" class="form-control" type="text" name="pp" value="{{$pp}}">

    <input id="lat" type="hidden" name="lat" value="{{$lat}}">
    <input id="lng" type="hidden" name="lng" value="{{$lng}}">
    <input id="zip" type="hidden" name="zip" value="{{$zip}}">

    <br>
    <input class="btn btn-primary" type="submit" value="Opslaan">

  </form>

  <a class="" href="{{ route('logout') }}"
     onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
      {{ __('Logout') }}
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>

</div>
@endsection
