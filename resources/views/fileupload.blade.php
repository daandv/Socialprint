@extends('layouts.app')

@push('script')
<script src="{{ asset('js/fileUpload.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
  @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
          </ul>
      </div>
  @endif

  <div class="centered bigTitle">
    <span>Nieuwe printopdracht</span>
  </div>
  <form class="" action="{{ route('upload', [$printerId]) }}" method="post" enctype="multipart/form-data">
  @csrf

  <div class="rowFilesAndPrinter">
    <div class="wrapper">
      <span>Verstuur printopdracht naar:</span>
      <div class="block">

      </div>
    </div>
    <div class="wrapper">
      <span>Upload bestanden:</span>
      <div class="block">
          <input id="fileBtnHidden" type="file" name="file[]" multiple style="display: none;">
          <input type="button" class="fileUpload" value="" onclick="document.getElementById('fileBtnHidden').click();" />

          <span class="selectedFiles"></span>
      </div>
    </div>
  </div>

  <span>Ik ga de opdracht verwerken: </span>{{$userThatPrintsName}}
  <br>
  <span>Ik ben de aanvrager: </span>{{$requesterName}}
  <br><br>




     <input id="pp" type="hidden" name="pp" value="{{$pp}}">
     <button id="verzendbtn" type="submit" class="btn btn-primary" disabled="disabled">Verstuur printopdracht</button>
  </form>
  <br><br>
  <div class="centered">
    <p id="calculations"></p>
    <p id="priceTotal"></p>
  </div>

  <div class="centered">

  <a href="https://letsencrypt.org/how-it-works/" target="_blank"><img class="letsEncrypt" src="{{ asset('images/lets-encrypt.png') }}" alt=""></a>
  </div>

</div>

@include('layouts.footer')
@endsection
