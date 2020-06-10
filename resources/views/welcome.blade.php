@extends('layouts.app')
@section('content')
  <div class="vhFirstPage">
    <div class="graphicContainer">
    <div class="particle-container">
      <!-- <div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>-->
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    	<div class="particle"></div>
    </div>

      <img src="{{asset('images/vrouw-graphic.svg')}}" alt="">
      <div class="frontPageInfoBlock">
        <span class="frontPageTitle">Socialprint</span>
        <span class="frontPageSubtitle">Het <span class="underline">printer deelplatform</span> voor studenten</span>


          @guest
              <a class="button-primary" href="{{route('register')}}">Start vandaag</a>
          @else
              <a class="button-primary" href="{{route('home')}}">Bekijk kaart</a>
          @endguest
              <a class="infoMini" href="#">Info testers - jury</a>
              
      </div>
      <img src="{{asset('images/man-graphic.svg')}}" alt="">
    </div>
  </div>

  @include('layouts.footer')
@endsection
