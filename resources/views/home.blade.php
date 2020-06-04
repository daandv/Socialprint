@extends('layouts.app')

@push('script')
<script src="{{ asset('js/mainmap.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form class="algoliabox">
      <label for="adress">Typ in</label>
      <input type="text" id="adress">
    </form>

    <br><br>
    <div id="mymap"></div>


</div>
@endsection
