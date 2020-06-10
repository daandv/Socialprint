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
