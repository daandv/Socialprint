@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/accountcomplete.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">
  <div class="centered">
    <h1 class="bigTitle">Wat wil je doen? <img class="infoIcon" src="{{asset('images/question.svg')}}" data-tippy-content="Dit kan later nog worden aangepast." data-tippy-arrow ="false" data-tippy-placement="right" data-tippy-animation="scale-subtle"></img></h1>

        <div class="row accountTypeWrapper">
          <div class="item accountTypeItem">
              <a class="bigTitle accountTypeOption" href="{{ route('notaprinter') }}">Enkel bij anderen afdrukken</a>
          </div>
          <div class="item accountTypeItem">
              <a class="bigTitle accountTypeOption" href="{{ route('addprinter') }}">Mijn eigen printer beschikbaar stellen</a>
              <p></p>
          </div>
        </div>

  </div>
</div>
@include('layouts.footer')

@endsection
