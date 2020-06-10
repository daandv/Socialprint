@extends('layouts.app')

@section('content')
<div class="container">
  <div class="centered">
    <h1 class="bigTitle">Wachtwoord resetten</h1>

    @if (session('status'))
        <div class="status" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="errors">
      @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
      @endforeach
    </div>

    <form method="POST" action="{{ route('password.update') }}" novalidate>
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">

      <label for="email">E-mailadres:</label><br><br>
      <input id="email" type="email" class="accountInputStyled" name="email" value="{{ $email ?? old('email') }}" required autofocus><br><br>

      <label for="password" class="col-md-4 col-form-label text-md-right">Wachtwoord:</label><br><br>
      <input id="password" type="password" class="accountInputStyled" name="password" required><br><br>

      <label for="password-confirm" class="">Bevestig wachtwoord:</label><br><br>
      <input id="password-confirm" type="password" class="accountInputStyled" name="password_confirmation" required><br><br>
      <br><br>
      <input class="button-primary" type="submit" value="Reset">
    </form>
  </div>
</div>
@endsection
