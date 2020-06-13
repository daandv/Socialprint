@extends('layouts.app')

@push('script')

@endpush

@section('content')
<div class="container">
  <div class="centered">
    <h1 class="bigTitle">&#128149; Favoriete printers</h1>
  </div>
  @if(count($favorites)>0)
  <div class="favoritesWrapper">
      @foreach($favorites as $favorite)
        <div class="favoriteItem" onclick="location.href='{{route('profile', [$favorite['fullUserInfo']['id']])}}';">
              <div class="userHeader">
                <div class="">
                  <img class="profilePicture" src="{{$favorite['fullUserInfo']['profile_picture_url']}}" alt="Profielfoto {{$favorite['fullUserInfo']['name']}}">
                </div>

                <div class="favoriteTitle">
                  <span class="favoriteName">{{$favorite['fullUserInfo']['name']}}</span><br>
                  <span class="favoriteAddress">{{$favorite['fullAddress']['street_and_number']}}
                    @if($favorite['fullAddress']['bus_number'])
                    , bus {{$favorite['fullAddress']['bus_number']}}
                    @endif
                    , {{$favorite['fullAddress']['city']}}
                  </span>
                </div>
              </div>
            <div class="favoriteButtons">
              <a href="{{route('printat', [$favorite['fullPrinter']['id']])}}" class="button-primary">Print hier</a><br><br>
              <a href="{{route('user.unstar', [$favorite['fullUserInfo']['id']])}}" class="greyLink">verwijder</a>
            </div>

        </div>
      @endforeach
  </div>
  @else
  <div class="centered">
    <p class="InfoText">Het is nog leeg hier...</p><br>
    <a class="button-primary" href="{{route('home')}}">Bekijk kaart</a>
  </div>

  @endif

</div>

@include('layouts.footer')
@endsection
