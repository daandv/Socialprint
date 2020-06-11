@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')


<div class="container">
  <div class="printJobDate">
    {{ Carbon\Carbon::parse($printJobDate)->format('d/m/Y') }}
    <br>
    <span>{{ Carbon\Carbon::parse($printJobDate)->format('H:i') }}</span>
  </div>
  @if($isPrinter)
  <div class="centered">

    <h1 class="bigTitle">Printaanvraag van {{$requesterName}}</h1>

    <h1 class="bigTitle printJobStatus
    @if($printJobStatus=='Geaccepteerd') green @endif
    @if($printJobStatus=='Geweigerd') red @endif
    @if($printJobStatus=='Klaar') gold @endif
    "
    >[{{$printJobStatus}}]</h1>

  </div>

  <div class="printJobDetailsRow">

    @if($printJobStatus=="Klaar")
    <div class="printjobDone">
      <img src="{{ asset('images/checkmark.svg') }}" alt=""><br>
      Bestanden afgedrukt!<br>
      Overleg de verdere <br> afhandeling met elkaar.
    </div>
    @endif
    <div class="detailsForPrinter">
      <p class="accountSubtitle">Opdracht details:</p>
      <div class="printerTags">
        @if($printerColorId==1)
        <span>kleur</span>
        @endif
        @if($printerColorId==2)
        <span>z/w</span>
        @endif

        @if($printerFormatId==1)
        <span>A4</span>
        @endif
        @if($printerFormatId==2)
        <span>A3</span>
        @endif
      </div>
      <span>{{$totalPages}} Pagina's</span><br>
      <span class="totalPricePrintjob">= €{{$price}}</span>
    </div>
    @if($printJobStatus!=="Klaar")
    <div class="actionsForPrinter">
      <p class="accountSubtitle">Acties:</p>
      @if($printJobStatus=="Aangevraagd")
      <a href="{{ route('printjob.reject', [$printJobId]) }}">WEIGER</a>
      <br>
      <a href="{{ route('printjob.accept', [$printJobId]) }}">ACCEPTEER</a>
      @endif

      @if($printJobStatus=="Geaccepteerd")
      <a href="{{ route('printjob.done', [$printJobId]) }}">GEPRINT</a>
      @endif
    </div>
    @endif

    <div class="printJobDetailsFiles">
      <p class="accountSubtitle">Bestanden: ({{count($fileNames)}})</p>
      @foreach ($fileNames as $filename)
        <a href="{{ route('getfile', [$filename->file_name]) }}" download>{{$filename->file_name}}</a>
        <br>
      @endforeach
      <p class="smallGrey">Bestanden worden verwijderd na 30 dagen.</p>
    </div>
  </div>
  @else



  <div class="centered">
    <h1 class="bigTitle">Printaanvraag bij {{$userThatPrintsName}}</h1>
    <h1 class="bigTitle printJobStatus
    @if($printJobStatus=='Geaccepteerd') green @endif
    @if($printJobStatus=='Geweigerd') red @endif
    @if($printJobStatus=='Klaar') gold @endif
    "
    >[{{$printJobStatus}}]</h1>
  </div>
  <div class="printJobDetailsRow">
    @if($printJobStatus=="Klaar")
      <div class="printjobDone">
        <img src="{{ asset('images/checkmark.svg') }}" alt=""><br>
        Bestanden afgedrukt!<br>
        Overleg de verdere <br> afhandeling met elkaar.
      </div>
    @endif
    <div class="detailsForPrinter">
      <p class="accountSubtitle">Opdracht details:</p>

      <div class="printerTags">
        @if($printerColorId==1)
        <span>kleur</span>
        @endif
        @if($printerColorId==2)
        <span>zw</span>
        @endif

        @if($printerFormatId==1)
        <span>A4</span>
        @endif
        @if($printerFormatId==2)
        <span>A3</span>
        @endif
      </div>

      <span>{{$totalPages}} Pagina's</span><br>
      <span class="totalPricePrintjob">= €{{$price}}</span>
    </div>

    <div class="printJobDetailsFiles">
      <p class="accountSubtitle">Bestanden: ({{count($fileNames)}})</p>
      @foreach ($fileNames as $filename)
        <a href="{{ route('getfile', [$filename->file_name]) }}" download>{{$filename->file_name}}</a>
        <br>
      @endforeach
      <p class="smallGrey">Bestanden worden verwijderd na 30 dagen.</p>
    </div>
  </div>
  @endif



  <br>
  @if ($isPrinter)
  <div class="centered">
    <h1 class="chatTitle">Chat met {{$requesterName}}</h1>
  </div>
  @else
  <div class="centered">
    <h1 class="chatTitle">Chat met {{$userThatPrintsName}}</h1>
  </div>
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

    @if(count($messages)==0)
    <div class="sysMessageWrapper">
      <li class="sysMessage">Stuur als eerste een bericht</li>
    </div>
    @endif
  </ul>
  </div>



  </div>
  <br>
  <form class="" action="{{ route('chat.send', [$printJobId])}}" method="post">
    @csrf
    <div class="centered">
      <input class="sendInput" type="text" name="message" placeholder="Typ je bericht hier">
      <input class="button-primary" type="submit" value="Verstuur">
    </div>

  </form>

</div>

  @include('layouts.footer')
@endsection
