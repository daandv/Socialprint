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
    <h1 class="bigTitle">Mijn account</h1>

  <form action="{{ route('update.storenonprinter') }}" method="POST">
    @csrf
    <span class="accountSubtitle">Profiel:</span><br>
    <label for="name">Naam:</label><br><br>
    <input type="text" id="name" class="accountInputStyled" name="name" value="{{$name}}"><br><br>

    <span class="accountSubtitle">Privacy:</span><br>
    <input type="checkbox" name="mailNotif" value="1"
    @if($emailNotif)
      checked
    @endif
    >
    <label for="mailNotif">Ontvang e-mail updates</label><br><br>
    <a class="greyLink" href="{{route('changetoprinter')}}">Ik wil mijn printer beschikbaar stellen</a>
    <br><br><br>
    <input class="button-primary" type="submit" value="Opslaan">

  </form>

  </div>
</div>

@include('layouts.footer')

@endsection
