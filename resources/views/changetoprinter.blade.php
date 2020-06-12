@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountcomplete.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
  <div class="centered">
    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->unique() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h1 class="bigTitle">Nog enkele vraagjes</h1>
    <form action="changetoprinterstore" method="POST">
      @csrf
      <span class="accountSubtitle">Adres:</span><br>
      <label for="address">Straat + huisnummer:</label><br><br>
      <div class="algoliaboxProfile">
          <input placeholder="Straat & huisnummer" class="algoliabox" type="text" id="address" name="address">
      </div><br>

      <label for="busnummer">Busnummer (optioneel):</label><br><br>
      <input placeholder="/" type="text" id="busnummer" class="accountInputStyled busNr" name="busNumber" value="{{$busNumber ?? ''}}"><br><br>

      <label for="city">Gemeente:</label><br><br>
      <input placeholder="Gemeente" type="text" id="city" class="accountInputStyled" name="city" readonly>

      <br><br>

      <label for="">Exacte locatie op de kaart: <img class="infoIcon" src="{{asset('images/question.svg')}}" data-tippy-content="Klikken om exacte locatie aan te passen." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"></img></label><br><br>
      <div id="minimap" class="accountmap"></div>

      <br><br>
    <span class="accountSubtitle">Mijn printer:</span><br>
      <label><input type="radio" name="printColor" id="color" value="color" checked>Kleur</label>
      <label><input type="radio" name="printColor" id="bw" value="bw">Zwart-wit</label>

      <br><br>

      <label for="pp">Prijs per pagina: <img class="infoIcon" src="{{asset('images/question.svg')}}" data-tippy-content="Gemiddeld 10-50 cent per pagina." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"></img></label><br><br>
      <span>€ </span><input id="pp" class="accountInputStyled accountInputPp" type="text" name="pp" value="0.1">

      <input id="lat" type="hidden" name="lat" value="">
      <input id="lng" type="hidden" name="lng" value="">
      <input id="zip" type="hidden" name="zip" value="">

      <br><br><br>
      <input class="button-primary" type="submit" value="Start met printen">
    <br><br>
    </form>
  </div>
</div>

@include('layouts.footer')

@endsection
