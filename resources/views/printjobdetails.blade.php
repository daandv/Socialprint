@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">


@foreach ($fileNames as $filename)
  <p>Files:</p>
  <a href="{{ route('getfile', [$filename->file_name]) }}" download>{{$filename->file_name}}</a>
  <br><br>

@endforeach
@if ($isPrinter)
<a href="{{ route('printjob.reject', [$printJobId]) }}">WIJGER</a>
<br>
<a href="{{ route('printjob.accept', [$printJobId]) }}">ACCEPTEER</a>
<br>
<a href="{{ route('printjob.done', [$printJobId]) }}">GEPRINT</a>
@endif
<p>{{$totalPages}} Pagina's</p>
<p>x €{{$pricePp}} per pagina</p>
<p>= €{{$totalPrice}}</p>
</div>
@endsection
