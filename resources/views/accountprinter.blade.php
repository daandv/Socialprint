@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountEditPrinter.js') }}" defer></script>
@endpush


@section('content')
<div class="container">
  <a class="logoutBtn" href="{{ route('logout') }}"
     onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
      Uitloggen
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>
  <div class="centered">
    @if ($errors->any())
        <div class="errors marginTop">
            @foreach ($errors->unique() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <h1 class="bigTitle">&#128125; Mijn account</h1>

  <form action="{{ route('update.storeprinter') }}" enctype="multipart/form-data" method="POST">
    @csrf
    <span class="accountSubtitle">Profiel:</span><br>
    <label for="name">Profielfoto:</label><br><br>
    <img onclick="document.getElementById('fileBtnHidden').click();" class="profileImageUpload" id="profilePicture" src="{{$profilePictureUrl}}" alt="Profielfoto" data-tippy-content="Klik om te wijzigen." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle">
    <input type="file" id="fileBtnHidden" name="profielfoto" accept="image/*" style="display: none;">

    <br><br>

    <label for="name">Naam:</label><br><br>
    <input type="text" id="name" class="accountInputStyled" name="name" value="{{$name}}">

    <br><br>

    <label for="bio">Korte beschrijving (optioneel):</label><br><br>
    <textarea placeholder="/" rows="2" type="text" id="bio" class="accountInputStyled accountTextareaStyled" name="bio">{{$bio}}</textarea>

    <br><br>



    <label for="name">E-mail: <img class="infoIcon" src="{{asset('images/question.svg')}}" data-tippy-content="Deze kan je niet wijzigen." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"></img></label><br><br>
    <input type="text" id="name" class="accountInputStyled" name="name" value="{{$email}}" disabled>

    <br><br><br>

    <span class="accountSubtitle">Adres:</span><br>
    <label for="address">Straat + huisnummer:</label><br><br>
    <div class="algoliaboxProfile">
        <input class="algoliabox" type="text" id="address" name="address" value="{{$address}}">
    </div>
    <br>
    <label for="busnummer">Busnummer (optioneel):</label><br><br>
    <input placeholder="/" type="text" id="busnummer" class="accountInputStyled busNr" name="busNumber" value="{{$busNumber ?? ''}}"><br>

    <br>
    <label for="city">Gemeente:</label><br><br>
    <input type="text" id="city" class="accountInputStyled" name="city" value="{{$city}}" readonly><br>

    <br>
    <label for="">Exacte locatie op de kaart: <img class="infoIcon" src="{{asset('images/question.svg')}}" data-tippy-content="Klikken om exacte locatie aan te passen." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"></img></label><br><br>
    <div id="minimap" class="accountmap"></div>

    <br><br>

    <span class="accountSubtitle">Mijn printer:</span><br>
    <label><input type="radio" name="printColor" id="color" value="color"
      @if($colorId===1)
      checked
      @endif
      >Kleur</label>
    <label><input type="radio" name="printColor" id="bw" value="bw"
      @if($colorId===2)
      checked
      @endif
      >Zwart-wit</label>

    <br><br>

    <label for="pp">Prijs per pagina: <img class="infoIcon" src="{{asset('images/question.svg')}}" data-tippy-content="Gemiddeld 10-50 cent per pagina." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"></img></label><br><br>
    <span>€ </span><input id="pp" class="accountInputStyled accountInputPp" type="text" name="pp" value="{{$pp}}">

    <input id="lat" type="hidden" name="lat" value="{{$lat}}">
    <input id="lng" type="hidden" name="lng" value="{{$lng}}">
    <input id="zip" type="hidden" name="zip" value="{{$zip}}">

    <br><br><br>

    <span class="accountSubtitle">Privacy:</span><br>
    <input type="checkbox" name="mailNotif" value="1"
    @if($emailNotif)
      checked
    @endif
    >
    <label for="mailNotif">Ontvang e-mail updates</label><br>
    <br>
    @if($available)
      <a class="greyLink" href="./notavailable">Ik wil niet (tijdelijk) meer printen</a>
    @else
      <a class="greyLink" href="./setavailable">Ik wil weer printen</a>
    @endif
    <br><br><br>
    <input class="button-primary" type="submit" value="Opslaan">
    <br><br>
  </form>



  </div>
</div>

@include('layouts.footer')

@endsection
