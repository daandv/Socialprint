@extends('layouts.app')

@section('content')
<div class="container">


<div class="lr-page">
    <div class="form-lr">
      <div class="errors">
        @if($errors->any())
            @foreach ($errors->all() as $error)
               <p>{{ $error }}</p>
            @endforeach
        @endif
      </div>

      <img class="lr-icon" src="{{asset('images/logo_icon.png')}}" alt="">
      <p>Login</p>
      <form class="login-form" method="POST" action="{{ route('login') }}" novalidate>
          @csrf
        <input id="email" type="email" placeholder="E-mail" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autofocus>

        <input id="password" type="password" placeholder="Wachtwoord" class="@error('password') is-invalid @enderror" name="password">
        <button type="submit" class="btn btn-primary">
            login
        </button>

        <div class="remember">
          <input class="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="label" for="remember">
              Onthoud mij
          </label>
        </div>

        <p class="message">Nog geen account? <a href="{{route('register')}}">Registreer</a></p>

      </form>
    </div>
  </div>

</div>
@endsection
