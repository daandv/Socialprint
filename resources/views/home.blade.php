@extends('layouts.app')

@notifyCss



@push('script')
<script src="{{ asset('js/mainmap.js') }}" defer></script>
@endpush

@section('content')
<div class="container">

    <!-- @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>

        <script>

        </script>
    @endif -->

    <div id="mymap">
      <form class="algoliabox">
        <input type="text" id="adress" placeholder="Zoek in een gemeente">
      </form>
      <img class="logo_icon" src="{{ asset('images/logo_icon.png')}}">
    </div>


</div>
@include('notify::messages')

@notifyJs
@endsection
