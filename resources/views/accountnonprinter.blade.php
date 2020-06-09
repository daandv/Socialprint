@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountedit.js') }}" defer></script>
@endpush


@section('content')
<div class="container">

  <div class="centeredDiv">
    <h1 class="biGTitle">Mijn account</h1>
  </div>

  <a href="./changetoprinter">Ik wil mijn printer beschikbaar stellen</a>
  <form action="{{ route('update.storenonprinter') }}" method="POST">
    @csrf
    <label for="name">Naam</label>
    <input type="text" id="name" class="form-control" name="name" value="{{$name}}">

    <input type="checkbox" name="mailNotif" value="1"
    @if($emailNotif)
      checked
    @endif
    >
    <label for="mailNotif">Ontvang e-mail updates</label><br>

    <br>
    <br>
    <input class="btn btn-primary" type="submit" value="Opslaan">

  </form>

  <a class="" href="{{ route('logout') }}"
     onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
      {{ __('Logout') }}
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>

</div>
@endsection
