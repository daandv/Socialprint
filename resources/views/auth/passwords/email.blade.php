@extends('layouts.app')

@section('content')
<div class="container">
  <div class="centered">
    @if (session('status'))
        <div class="success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="errors">
      @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
      @endforeach
    </div>
    <h1 class="bigTitle">Wachtwoord herstellen</h1>
      <form method="POST" action="{{ route('password.email') }}" novalidate>
          @csrf

          <label for="email" class="">E-mailadres:</label><br><br>

          <input id="email" class="accountInputStyled" type="email" name="email" value="{{ old('email') }}" autofocus>
          <br><br>

          <input class="button-primary" type="submit" value="Verstuur reset link">
      </form>
  </div>



</div>
@endsection
