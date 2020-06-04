@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountedit.js') }}" defer></script>
@endpush


@section('content')
<div class="container">

  <a href="./changetoprinter">Ik wil mijn printer beschikbaar stellen</a>
  <form action="./account/update" method="POST">
    @csrf

    <label for="name">Naam</label>
    <input type="text" id="name" class="form-control" name="name" value="{{$name}}">
    <br>
    <br>
    <input class="btn btn-primary" type="submit" value="Opslaan">

  </form>

</div>
@endsection
