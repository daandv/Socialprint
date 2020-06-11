@extends('layouts.app')

@push('script')
<script src="{{ asset('js/accountEditNonPrinter.js') }}" defer></script>
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

  <form action="{{ route('update.storenonprinter') }}" enctype="multipart/form-data" method="POST">
    @csrf
    <span class="accountSubtitle">Profiel:</span><br>
    <label for="name">Profielfoto:</label><br><br>
    <img onclick="document.getElementById('fileBtnHidden').click();" class="profileImageUpload" id="profilePicture" src="{{$profilePictureUrl}}" alt="Profielfoto" data-tippy-content="Klik om te wijzigen." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle">
    <input type="file" id="fileBtnHidden" name="profielfoto" accept="image/*" style="display: none;">

    <br><br>
    <label for="name">Naam:</label><br><br>
    <input type="text" id="name" class="accountInputStyled" name="name" value="{{$name}}"><br><br>

    <label for="name">E-mail: <img class="infoIcon" src="{{asset('images/question.svg')}}" data-tippy-content="Deze kan je niet wijzigen." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"></img></label><br><br>
    <input type="text" id="name" class="accountInputStyled" name="name" value="{{$email}}" disabled><br><br>

    <span class="accountSubtitle">Privacy:</span><br>
    <input type="checkbox" name="mailNotif" value="1"
    @if($emailNotif)
      checked
    @endif
    >
    <label for="mailNotif">Ontvang e-mail updates</label><br><br>
    <a class="greyLink" href="{{route('changetoprinter')}}">Ik wil mijn printer beschikbaar stellen</a>
    <br><br><br>
    <input class="button-primary" type="submit" value="Opslaan">

  </form>

  </div>
</div>

@include('layouts.footer')

@endsection
