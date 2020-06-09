@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">

<p>Files: (Worden verwijderd na 30 dagen)</p>
@foreach ($fileNames as $filename)
  <a href="{{ route('getfile', [$filename->file_name]) }}" download>{{$filename->file_name}}</a>
  <br>
@endforeach
  <br><br>

@if($isPrinter)
<div style="border:1px solid black">
  <b>Actions:</b><br>
  @if($printJobStatus=="Aangevraagd")
  <a href="{{ route('printjob.reject', [$printJobId]) }}">WEIGER</a>
  <br>
  <a href="{{ route('printjob.accept', [$printJobId]) }}">ACCEPTEER</a>
  @endif

  @if($printJobStatus=="Geaccepteerd")
  <a href="{{ route('printjob.done', [$printJobId]) }}">GEPRINT</a>
  @endif
</div>
<br>
@endif

<div style="border:1px solid black">
  <b>Ophaal gegevens:</b><br>
  <span>{{$userThatPrintsName}}</span><br>
  <span>{{$userAddressDetails->street_and_number}}</span><br>
</div>

<br>

<div style="border:1px solid black">
<b>Opdracht details:</b><br>
  <span>{{$totalPages}} Pagina's</span><br>
  <span>x €{{$pricePp}} per pagina</span><br>
  <span>= €{{$totalPrice}}</span>
</div>

<br>
@if ($isPrinter)
<h2>Chat met {{$requesterName}}</h2>
@else
<h2>Chat met {{$userThatPrintsName}}</h2>
@endif
<div class="chatMessages">

<div class="chatWrapper">
<ul>
  @foreach($messages as $message)
    @if($message["fromId"]==$currentUserId)
    <li class="me"><span class="chatDate">{{ str_replace(['uur', 'minuten'], ['u', 'min'], \Carbon\Carbon::parse($message["date"])->diffForhumans(null,true)) }}</span> <br> {{$message["message"]}}</li>
    @else
    <li class="other"><span class="chatDate">{{ str_replace(['uur', 'minuten'], ['u', 'min'], \Carbon\Carbon::parse($message["date"])->diffForhumans(null,true)) }}</span> <br> {{$message["message"]}}</li>
    @endif
  @endforeach

    <div class="sysMessageWrapper">
      <li class="sysMessage">Systeembericht: nieuwe printopdracht!</li>
    </div>
</ul>
</div>



</div>
<br>
<form class="" action="{{ route('chat.send', [$printJobId])}}" method="post">
  @csrf
<input type="text" name="message" value="">
<input type="submit" name="" value="Verstuur">
</form>

</div>
@endsection
