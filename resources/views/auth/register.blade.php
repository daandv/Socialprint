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
        <p>Registreer</p>
        <form class="login-form" method="POST" action="{{ route('register') }}" novalidate>
            @csrf
          <input id="name" type="text" placeholder="Naam" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

          <input id="email" type="email" placeholder="E-mail" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

          <input id="password" type="password" placeholder="Wachtwoord" class="@error('password') is-invalid @enderror" name="password">
          <input id="password-confirm" type="password" placeholder="Bevestig wachtwoord" class="form-control" name="password_confirmation" required autocomplete="new-password">
          <button type="submit">
              login
          </button>


          <p class="message">Al een account? <a href="{{route('login')}}">Login</a></p>

        </form>
      </div>

    </div>


</div>
@include('layouts.footer')
@endsection
