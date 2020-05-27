@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountcomplete.js') }}" defer></script>
@endpush

@section('content')
<div class="container">

  <h3>Nog enkele vraagjes</h3>
  <form>
    <div class="row">

      <div class="col md-6">
        <label for="address">Straat + nr</label>
        <input id="address" class="form-control" type="text">
      </div>

      <div class="col md-6">
        <label for="city">Gemeente</label>
        <input id="city" class="form-control" type="text">
      </div>

    </div>

    <br>
    <input class="btn btn-primary" type="submit">

  </form>
</div>
@endsection
