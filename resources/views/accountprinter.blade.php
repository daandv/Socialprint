@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountedit.js') }}" defer></script>
@endpush


@section('content')
<div class="container">
  <a class="logoutBtn" href="{{ route('logout') }}"
     onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
      Uitloggen
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>
  <div class="centered">
    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->unique() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <h1 class="bigTitle">Mijn account</h1>

  <form action="{{ route('update.storeprinter') }}" method="POST">
    @csrf
    <span class="accountSubtitle">Profiel:</span><br>
    <label for="name">Naam:</label><br><br>
    <input type="text" id="name" class="accountInputStyled" name="name" value="{{$name}}"><br><br>

    <span class="accountSubtitle">Adres:</span><br>
    <label for="address">Straat + nr:</label><br><br>
    <div class="algoliaboxProfile">
        <input class="algoliabox" type="text" id="address" name="address" value="{{$address}}">
    </div>
    <br>

    <label for="city">Gemeente:</label><br><br>
    <input type="text" id="city" class="accountInputStyled" name="city" value="{{$city}}" readonly><br>

    <br>
    <label for="">Exacte locatie op de kaart:</label><br><br>
    <div id="minimap" class="accountmap"></div>
    <br>
    <span class="accountSubtitle">Mijn printer:</span><br>
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

    <br><br>

    <label for="pp">Prijs per pagina</label><br><br>
    <input id="pp" class="accountInputStyled accountInputPp" type="text" name="pp" value="{{$pp}}">

    <input id="lat" type="hidden" name="lat" value="{{$lat}}">
    <input id="lng" type="hidden" name="lng" value="{{$lng}}">
    <input id="zip" type="hidden" name="zip" value="{{$zip}}">

    <br><br>
    <span class="accountSubtitle">Privacy:</span><br>
    <input type="checkbox" name="mailNotif" value="1"
    @if($emailNotif)
      checked
    @endif
    >
    <label for="mailNotif">Ontvang e-mail updates</label><br>
    <br>
    @if($available)
      <a class="greyLink" href="./notavailable">Ik wil niet meer printen</a>
    @else
      <a class="greyLink" href="./setavailable">Ik wil weer printen</a>
    @endif
    <br><br><br>
    <input class="button-primary" type="submit" value="Opslaan">

  </form>



  </div>
</div>

@include('layouts.footer')

@endsection
