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

  <div class="centered">
      <h1 class="bigTitle">Nieuwe printopdracht</h1>
  </div>
  <form class="" action="{{ route('upload', [$printerId]) }}" method="post" enctype="multipart/form-data">
  @csrf

  <div class="rowFilesAndPrinter">
    <div class="wrapper">
      <span>Verstuur printopdracht naar:</span>
      <div class="block" onclick="location.href='{{route('profile', [$userThatPrintsId])}}';">
        <img class="profilePictureMedium" src="{{$userThatPrintsProfilePicture}}" alt="">
        <span class="printerName">{{$userThatPrintsName}}</span>

        <div class="printerTagsUpload">
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


      </div>
    </div>
    <div class="wrapper">
      <span>Upload bestanden:</span>
      <div class="block upload">
          <input id="fileBtnHidden" type="file" name="file[]" multiple style="display: none;">
          <input type="button" class="fileUpload" value="" onclick="document.getElementById('fileBtnHidden').click();" />

          <span class="selectedFiles"></span>
      </div>
    </div>
  </div>


  <div class="centered">
    <p id="calculations" class="fileUploadCalculations"></p>
    <p id="priceTotal" class="fileUploadPrice gold"></p>

     <button id="verzendbtn" type="submit" class="button-primary">Verstuur printopdracht</button><br><br>
     <a href="https://letsencrypt.org/how-it-works/" target="_blank"><img class="letsEncrypt" src="{{ asset('images/lets-encrypt.png') }}" alt=""></a>
  </div>


   <input id="pp" type="hidden" name="pp" value="{{$pp}}">

  </form>
  <br><br>


  <div class="centered">


  </div>

</div>

@include('layouts.footer')
@endsection
