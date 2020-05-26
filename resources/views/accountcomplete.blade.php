@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountcomplete.js') }}" defer></script>
@endpush

@section('content')
<div class="container">

  <h3>Please complete your account</h3>
  <form class="" action="index.html" method="post">
    <div class="row">

      <div class="col md-6">
        <label for="address">Straat + nr</label>
        <input class="form-control" id="address" type="text">
      </div>

      <div class="col md-6">
        <label for="city">Gemeente</label>
        <input class="form-control" id="city" type="text">
      </div>

    </div>

    <br>
    <input class="btn btn-primary" type="submit">

  </form>
</div>
@endsection
