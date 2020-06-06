@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">
    <table>
      <tr>
        <th>Van</th>
      </tr>
      @foreach ($printJobs as $printJob)
        @if ($printJob->requester_id == $userId)
        <tr>
          <td>Jij aangevraagd: {{ $printJob->id }}</td>
        </tr>
        @endif

        @if ($printJob->printer_id == $userId)
        <tr>
          <td>Binnengekomen: {{ $printJob->id }}</td>
        </tr>
        @endif
      @endforeach
    </table>

    <div class="cards">
      <div class="card">ONE</div>
      <div class="card">TWO</div>
    </div>



</div>
@endsection
