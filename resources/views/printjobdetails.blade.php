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
<a href="{{ route('printjob.reject', [$printJobId]) }}">WEIGER</a>
<br>
<a href="{{ route('printjob.accept', [$printJobId]) }}">ACCEPTEER</a>
<br>
<a href="{{ route('printjob.done', [$printJobId]) }}">GEPRINT</a>
@endif


<b>Ophaal gegevens:</b>
<p>{{$userThatPrintsName}}</p>
<p>{{$userAddressDetails->street_and_number}}</p>

<p>{{$totalPages}} Pagina's</p>
<p>x €{{$pricePp}} per pagina</p>
<p>= €{{$totalPrice}}</p>
</div>
@endsection
