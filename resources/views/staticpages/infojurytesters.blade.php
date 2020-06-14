@extends('layouts.app')
@section('content')
<div class="container">
  <div class="centered">


    <h1 class="bigTitle">&#128075; Informatie voor jury/testers</h1>
    <div class="a-staticpage">
      <ul class="a-container">

        <li class="a-items">
          <input type="radio" name="ac" id="a1" />
          <label for="a1">Voorwoord</label>
          <div class="a-content">
            <h2>Hoi!</h2>
            <p>Leuk dat u een bezoek brengt aan mijn website! Ik ben Daan De Vry en heb als eindwerk het Socialprint platform op poten gezet.
              Op deze pagina vindt u wat info over mijn website & het gebruik ervan.
            </p>
            <h3>Concept in het kort</h3>
            <p>Socialprint is een platform waar studenten hun printer met elkaar kunnen delen. Zelf merkte ik onder andere tijdens mijn periode op
              kot dat het voor mijzelf niet de moeite was om een printer aan te schaffen.
              Dit platform maakt het mogelijk om bij andere personen of vrienden in de buurt af te drukken. Er wordt op een informele manier een prijs opgesteld om zonder schuldgevoel te kunnen printen.
            </p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a2" />
          <label for="a2">Rekening houden bij registreren</label>
          <div class="a-content">
            <h3>E-mail</h3>
            <p>Om de kosten van een jaarlijkse dedicated IP mailserver te vermijden, is het mogelijk dat mijn e-mails
              voor onder andere de verificatie van uw account worden tegen gehouden door spamfilters of in uw spamfolder terechtkomen.
              Moest het zijn dat u de e-mails niet ontvangt, kan u nogmaals proberen met een <b>Gmail adres</b> of eventueel een tijdelijke online mailbox.
            </p>

            <h3>Accounttypes</h3>
            <p>Bij het registreren krijgt u de keuze tussen een "Enkel printen bij anderen" account of een "Zelf printen" account. U kan te allen tijde switchen tussen deze accounts bij "Account"
            </p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a3" />
          <label for="a3">Vragen & contact</label>
          <div class="a-content">
            <p>Enkele vragen worden beantwoord op de <a href="{{route('faq')}}">FAQ</a> pagina.</p>
            <p>Indien uw vraag hier niet tussen staat, kan u mij bereiken op:
            <br>daandevry@live.be
            <br>info@socialprint.site</p>
          </div>
        </li>


      </ul>
    </div>
    <br><br>
  </div>
</div>


  @include('layouts.footer')
@endsection
