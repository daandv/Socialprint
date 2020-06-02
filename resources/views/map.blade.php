@extends('layouts.app')

@push('script')
<script src="{{ asset('js/mainmap.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
  <form class="algoliabox">
    <label for="adress">Typ in</label>
    <input type="text" id="adress">
  </form>

  <br><br>
  <div id="mymap"></div>
</div>
@endsection
