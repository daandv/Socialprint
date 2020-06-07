@extends('layouts.app')

@push('script')
<!-- <script src="{{ asset('js/fileUpload.js') }}" defer></script> -->
@endpush

@section('content')
<div class="container">

<p>{{$isPrinter}}</p>

@foreach ($fileNames as $filename)
  <a href="{{ route('getfile', [$filename->file_name]) }}" download>{{$filename->file_name}}</p>
@endforeach

</div>
@endsection
