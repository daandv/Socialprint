@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">

<p>Files:</p>
@foreach ($fileNames as $filename)
  <a href="{{ route('getfile', [$filename->file_name]) }}" download>{{$filename->file_name}}</a>
  <br>
@endforeach
  <br><br>

@if ($isPrinter)
<div style="border:1px solid black">
  <b>Actions:</b><br>
  <a href="{{ route('printjob.reject', [$printJobId]) }}">WEIGER</a>
  <br>
  <a href="{{ route('printjob.accept', [$printJobId]) }}">ACCEPTEER</a>
  <br>
  <a href="{{ route('printjob.done', [$printJobId]) }}">GEPRINT</a>
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
  @foreach($messages as $message)
    @if($message["fromId"]==$currentUserId)
    <p>Jij:{{$message["message"]}} {{$message["date"]}}</p>
    @else
    <p>{{$message["fromName"]}}:{{$message["message"]}} {{$message["date"]}}</p>
    @endif
  @endforeach
</div>
<br>
<form class="" action="{{ route('chat.send', [$printJobId])}}" method="post">
  @csrf
<input type="text" name="message" value="">
<input type="submit" name="" value="Verstuur">
</form>

</div>
@endsection
