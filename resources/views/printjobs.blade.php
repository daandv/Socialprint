@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">
  <div class="centered">
    <h1 class="bigTitle">Mijn drukkerij</h1>

    @if($fullPrintJobInfo->count()>0)
    <table class="printTasksContainer">
      <tr>
        <th></th>
        <th>Datum</th>
        <th>Status</th>
        <th>Details</th>
        <th>Aangevraagd door</th>
        <th>Afgedrukt door</th>
      </tr>
      @foreach ($fullPrintJobInfo as $printJob)
      <tr>
        <td>
          @if($printJob['unreadMessages'])
            Nieuw!
          @else

          @endif
        </td>
        <td>{{$printJob['date']}}</td>
        @if($printJob['status']=="Klaar")
          <td class="statusGreen" data-tippy-content="{{$printJob['status']}}" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle"> &#9989;</td>
        @elseif($printJob['status']=="Geweigerd")
          <td class="statusRed" data-tippy-content="{{$printJob['status']}}" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle"> &#128532;</td>
        @elseif($printJob['status']=="Geaccepteerd")
          <td class="statusGreen" data-tippy-content="{{$printJob['status']}}" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle"> &#128077;</td>
        @else
          <td class="" data-tippy-content="{{$printJob['status']}}" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle"> &#128073;</td>
        @endif
        <td>
          <a href="{{ route('printjob.details', [$printJob['id']]) }}">details</a>
        </td>

        @if ($printJob['requesterId']==$userId)
          <td>Mijzelf</td>
        @else
          <td>{{$printJob['requesterName']}}</td>
        @endif

        @if ($printJob['userThatPrintsId']==$userId)
          <td>Mijzelf</td>
        @else
          <td>{{$printJob['userThatPrintsName']}}</td>
        @endif

      </tr>
      @endforeach

    </table>
    {{ $fullPrintJobInfo->links() }}

    @else
    <p class="InfoText">Het is nog leeg hier...</p><br>
    <a class="button-primary" href="{{route('home')}}">Bekijk kaart</a>
    @endif
<!--
    <div class="row">
      <div class="item">ONE</div>
      <div class="item">TWO</div>
    </div> -->
      </div>
</div>
  @include('layouts.footer')
@endsection
