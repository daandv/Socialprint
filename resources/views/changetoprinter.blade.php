@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountcomplete.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
  <div class="centered">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1 class="bigTitle">Nog enkele vraagjes</h1>
    <form action="changetoprinterstore" method="POST">
      @csrf
      <span class="accountSubtitle">Adres:</span><br>
      <div class="algoliaboxProfile">    <label for="address">Straat + nr:</label><br><br>
          <input class="algoliabox" type="text" id="address" name="address">
      </div><br>

      <label for="city">Gemeente:</label><br><br>
      <input type="text" id="city" class="accountInputStyled" name="city" readonly>

      <br><br>

      <label for="">Exacte locatie op de kaart:</label><br><br>
      <div id="minimap" class="accountmap"></div>

      <br>
    <span class="accountSubtitle">Mijn printer:</span><br>
      <label><input type="radio" name="printColor" id="color" value="color" checked>Kleur</label>
      <label><input type="radio" name="printColor" id="bw" value="bw">Zwart-wit</label>

      <br><br>

      <label for="pp">Prijs per pagina:</label><br><br>
      <input id="pp" placeholder="0.09" class="accountInputStyled accountInputPp" type="text" name="pp">

      <input id="lat" type="hidden" name="lat" value="">
      <input id="lng" type="hidden" name="lng" value="">
      <input id="zip" type="hidden" name="zip" value="">

      <br><br><br>
      <input class="button-primary" type="submit" value="Start met printen">

    </form>
  </div>



</div>

@include('layouts.footer')

@endsection
