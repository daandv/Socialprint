@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">
  <div class="centeredDiv">
    <h1 class="biGTitle">Mijn drukkerij</h1>
  </div>

    <table class="printTasksContainer">
      <tr>
        <th>Datum</th>
        <th>Status</th>
        <th>Details</th>
        <th>Aangevraagd door</th>
        <th>Afgedrukt door</th>
      </tr>

      @foreach ($fullPrintJobInfo as $printJob)
      <tr>
        <td>{{$printJob['date']}}</td>
        <td class="
        @if($printJob['status']=="Klaar")
          statusGreen
        @endif

        @if($printJob['status']=="Geweigerd")
          statusRed
        @endif
        ">{{$printJob['status']}}</td>
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
<!--
    <div class="row">
      <div class="item">ONE</div>
      <div class="item">TWO</div>
    </div> -->



</div>
@endsection
