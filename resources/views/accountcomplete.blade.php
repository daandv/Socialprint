@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountcomplete.js') }}" defer></script>
@endpush

@section('content')
<div class="container">

  @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  <h3>Nog enkele vraagjes</h3>
  <form action="adduserprinter" method="POST">
    @csrf

    <label for="address">Straat + nr</label>
    <input class="algoliabox" type="text" id="address" class="form-control" name="address">

    <label for="city">Gemeente</label>
    <input type="text" id="city" class="form-control" name="city" readonly>

    <br>

    <div id="minimap"></div>

    <br>

    <label><input type="radio" name="printColor" id="color" value="color" checked>Kleur</label>
    <label><input type="radio" name="printColor" id="bw" value="bw">Zwart-wit</label>

    <br>

    <label for="pp">Prijs per pagina</label>
    <input id="pp" class="form-control" type="text" name="pp">

    <input id="lat" type="hidden" name="lat" value="">
    <input id="lng" type="hidden" name="lng" value="">
    <input id="zip" type="hidden" name="zip" value="">

    <br>
    <input class="btn btn-primary" type="submit">

  </form>




</div>
@endsection
