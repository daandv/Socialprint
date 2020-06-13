@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container hiddenSmall">
  <div class="centered">
    <h1 class="bigTitle">&#127981; Mijn drukkerij</h1>

    @if(count($fullPrintJobInfo)>0)
    <table class="printTasksContainer">
      <tr>
        <th>Datum</th>
        <th>Status</th>
        <th>Aanvrager</th>
        <th>Printer</th>
      </tr>
      @foreach ($fullPrintJobInfo as $printJob)

      <tr class="dataRow" onclick="location.href='{{route('printjob.details', [$printJob['id']])}}';">
        <td>{{Carbon\Carbon::parse($printJob['date'])->format('d/m/Y')}}</td>
        @if($printJob['unreadMessages'])
          <td><span class="printJobIcon" data-tippy-content="Nieuw chatbericht" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle">&#128172;</span></td>
        @else
          @if($printJob['status']=="Klaar")
            <td><span class="printJobIcon" data-tippy-content="{{$printJob['status']}}" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle">&#9989;</span></td>
          @elseif($printJob['status']=="Geweigerd")
            <td><span class="printJobIcon" data-tippy-content="{{$printJob['status']}}" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle">&#128532;</span></td>
          @elseif($printJob['status']=="Geaccepteerd")
            <td><span class="printJobIcon" data-tippy-content="{{$printJob['status']}}" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle">&#128077;</span></td>
          @else
            <td><span class="printJobIcon" data-tippy-content="{{$printJob['status']}}" data-tippy-arrow ="false" data-tippy-placement="bottom" data-tippy-animation="scale-subtle">&#128073;</span></td>
          @endif
        @endif
        @if ($printJob['requesterId']==$userId)
          <td>
          <div class="personBubble">
            <img class="profilePictureMini" src="{{$printJob['requesterProfilePicture']}}" alt="">
            <span>Mijzelf</span>
          </div>
          </td>
        @else
          <td>
          <div class="personBubble">
            <img class="profilePictureMini" src="{{$printJob['requesterProfilePicture']}}" alt="">
            <span class="someoneElse">{{$printJob['requesterName']}}</span>
          </div>
          </td>
        @endif

        @if ($printJob['userThatPrintsId']==$userId)
          <td><div class="personBubble">
            <img class="profilePictureMini" src="{{$printJob['userThatPrintsProfilePicture']}}" alt="">
            <span>Mijzelf</span>
          </div></td>
        @else
          <td>
          <div class="personBubble">
            <img class="profilePictureMini" src="{{$printJob['userThatPrintsProfilePicture']}}" alt="">
            <span class="someoneElse">{{$printJob['userThatPrintsName']}}</span>
          </div>
          </td>
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





<div class="container hiddenLarge">
  <div class="centered">
    <h1 class="bigTitle">&#127981; Mijn drukkerij</h1>

    @if($fullPrintJobInfo->count()>0)
      @foreach ($fullPrintJobInfo as $printJob)
          <div class="mobileBubble" onclick="location.href='{{route('printjob.details', [$printJob['id']])}}';">
              <p class="mobileNewChat">
                @if($printJob['unreadMessages'])
                  &#128172;
                @endif
              </p>
              <p class="mobileSort">
                 @if ($printJob['requesterId']==$userId)
                      &#128228; Uitgaand
                  @else
                      &#128229; Binnenkomend
                  @endif
              </p>
            <p class="mobileDate">{{Carbon\Carbon::parse($printJob['date'])->format('d/m/Y')}}</p>
            <p class="mobileStatus
                        @if($printJob['status']=='Geaccepteerd') green @endif
                        @if($printJob['status']=='Geweigerd') red @endif
                        @if($printJob['status']=='Klaar') gold @endif">
                  [{{$printJob['status']}}]

            </p>
          </div>
      @endforeach

    {{ $fullPrintJobInfo->links() }}

    @else
    <p class="InfoText">Het is nog leeg hier...</p><br>
    <a class="button-primary" href="{{route('home')}}">Bekijk kaart</a>
    @endif

      </div>
</div>
  @include('layouts.footer')
@endsection
