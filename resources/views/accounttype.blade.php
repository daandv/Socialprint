@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/accountcomplete.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">

  <h3>Wat wil je doen?</h3>
    <a href="{{ route('notaprinter') }}" class="btn btn-primary">Bij iemand afprinten</a>
    <a href="{{ route('addprinter') }}"class="btn btn-primary">Mijn printer beschikbaar stellen</a>
</div>
@include('layouts.footer')

@endsection
