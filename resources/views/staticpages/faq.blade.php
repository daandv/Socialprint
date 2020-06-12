@extends('layouts.app')
@section('content')
<div class="container">
  <div class="centered">


    <h1 class="bigTitle">&#128293; FAQ</h1>
    <div class="a-staticpage">
      <ul class="a-container">

        <li class="a-items">
          <input type="radio" name="ac" id="a7" />
          <label for="a7">Hoe betaal ik mijn prints?</label>
          <div class="a-content">
            <p>Ons platform biedt geen ondersteuning voor (online) betalingen. Wij brengen mensen bij elkaar en geven op een informele manier een prijs(suggestie). Vervolgens is het aan beide partijen om met elkaar verder af te spreken hoe de afhandeling zal gebeuren. Dit kan onder andere via een chat die vasthangt aan elke printopdracht.</p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a1" />
          <label for="a1">Welk soort account moet ik kiezen?</label>
          <div class="a-content">
            <h3>Ik wil zelf ook printen</h3>
            <p>Dit kiest u als u zelf een printer hebt en deze beschikbaar wilt stellen voor andere personen. Je kan zo printopdrachten binnekrijgen.</p>
            <h3>Ik wil niet printen</h3>
            <p>Indien u kiest om zelf niet te printen kan u bij andere afprinten maar zelf geen opdrachten ontvangen. Dit kan u te allen tijde aanpassen bij uw account.</p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a2" />
          <label for="a2">Hoe pas ik mijn accounttype aan?</label>
          <div class="a-content">
            <h3>Ik wil zelf ook printen</h3>
            <p>Indien u bij het registreren hebt gekozen voor een "Enkel printen bij anderen" account maar nu uw eigen printer beschikbaar wil stellen kan u dit aanpassen bij "account" onderaan.</p>
            <h3>Ik wil niet meer printen</h3>
            <p>Indien u bij het registreren hebt gekozen voor een "Zelf printen" account maar nu niet meer wil printen kan u dit aanpassen bij "account" onderaan. Dit is tijdelijk en kan te allen tijde ongedaan gemaakt worden.</p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a3" />
          <label for="a3">Wat zijn de printer badges?</label>
          <div class="a-content">
            <h3>Groen</h3>
            <p>U kan een groene badge (hartje) bekomen door meer dan 50 printopdrachten te hebben binnengekregen en meer dan de helft hiervan te hebben voltooid. U moet ook al langer dan 14 dagen op ons platform actief zijn.</p>
            <h3>Blauw</h3>
            <p>Nieuwe printers ontvangen de eerste 14 dagen een blauwe badge (hartje) om anderen te laten weten dat ze nieuw zijn op ons platform.</p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a4" />
          <label for="a4">Wat is een goede prijs per pagina?</label>
          <div class="a-content">
            <h3>Kleur</h3>
            <p>De gemiddelde prijs voor een kleurenprint ligt rond de 10 - 50 cent per pagina. U kan ervoor kiezon om iets meer te vragen om wat meer over te houden.</p>
            <h3>Zwart/wit</h3>
            <p>De prijs van een zwart/wit afdruk ligt in de regel iets lager dan een kleurenprint.</p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a5" />
          <label for="a5">Waarom kan ik mijn printopdracht niet versturen?</label>
          <div class="a-content">
            <p>Per printopdracht kan u 5 bestanden versturen. Deze bestanden dienen van het formaat .pdf te zijn en maximum 40MB groot. Als onze server de pdf niet kan verwerken wil dit zeggen dat deze niet geldig is. Probeer deze eventueel te converteren naar een geldige pdf.</p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a6" />
          <label for="a6">Kan ik mijn A3 printer beschikbaar stellen?</label>
          <div class="a-content">
            <p>Momenteel ondersteunen wij deze functie nog niet. Als alternatief kan u dit wel aangeven in de beschrijving van uw profiel en eventueel een iets hoger bedrag vragen per pagina.</p>
          </div>
        </li>

      </ul>
    </div>
    <br><br>
  </div>
</div>


  @include('layouts.footer')
@endsection
