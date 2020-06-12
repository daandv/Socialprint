@extends('layouts.app')

@section('content')
<div class="container">
  <div class="centered">

    @if (session('resent'))
        <div class="success">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

      <h1 class="bigTitle">{{ __('Verify Your Email Address') }}</h1>



      {{ __('Before proceeding, please check your email for a verification link.') }} Dit kan tot 15 minuten duren.<br><br>
      {{ __('If you did not receive the email') }}<br><br>
      <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
          @csrf
          <button type="submit" class="button-primary">{{ __('click here to request another') }}</button><br><br>
      </form>
      <a class="greyLink" href="{{ route('logout') }}"
         onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
          Uitloggen
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>

  </div>
</div>
@include('layouts.footer')
@endsection
