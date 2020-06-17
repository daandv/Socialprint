@extends('layouts.app')





@push('script')
@notifyCss
<script src="{{ asset('js/mainmap.js') }}" defer></script>
@endpush



@section('content')


    <div id="mymap">
      <form class="algoliabox algoliaboxmap">
        <input type="text" id="adress" placeholder="Zoek in een gemeente">
      </form>
      <img onclick="location.href='{{route('welcome')}}';" class="logo_icon" src="{{ asset('images/logo_icon.png')}}">
      <span onclick="location.href='{{route('faq')}}';" class="faq_icon" data-tippy-content="Ik begrijp iets niet." data-tippy-arrow ="false" data-tippy-placement="left" data-tippy-animation="scale-subtle">&#10067;</span>
    </div>



@include('notify::messages')

@notifyJs
@endsection
