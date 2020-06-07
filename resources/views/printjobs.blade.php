@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">

    <table class="printTasksContainer">
      <tr>
        <th>Details</th>
        <th>Actions</th>
        <th>Datum</th>
        <th>Aangevraagd door</th>
        <th>Afgedrukt door</th>
        <th>Prijs</th>
      </tr>

      @foreach ($fullPrintJobInfo as $printJob)
      <tr>
        <td>
          <a href="{{ route('printjob.details', [$printJob['id']]) }}">details</a>
        </td>
        <td>
          <a href="#">geprint</a>
          <a href="#">cancel</a>
        </td>
        <td>{{$printJob['date']}}</td>
        <td>{{$printJob['requesterName']}}</td>
        <td>{{$printJob['userThatPrintsName']}}</td>
        <td>{{$printJob['price']}}</td>
      </tr>
        <!-- @if ($printJob['requesterId'] == $userId)
        <tr>
          <td>Jij aangevraagd: {{ $printJob['id'] }}</td>
        </tr>
        @endif -->

        <!-- @if ($printJob['userThatPrintsId'] == $userId)
        <tr>
          <td>Binnengekomen: {{ $printJob['id'] }}</td>
        </tr>
        @endif -->
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
