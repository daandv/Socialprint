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

  <span>Ik ga de opdracht verwerken: </span>{{$userThatPrintsName}}
  <br>
  <span>Ik ben de aanvrager: </span>{{$requesterName}}
  <br><br>
  <form class="" action="{{ route('upload', [$printerId]) }}" method="post" enctype="multipart/form-data">
    @csrf
     <div class="form-group">
       <label for="f">Example file input</label>
       <input id="f" type="file" name="file[]" class="form-control-file" multiple data-show-upload="true" data-show-caption="true">
     </div>

     <input id="pp" type="hidden" name="pp" value="{{$pp}}">
     <button id="verzendbtn" type="submit" class="btn btn-primary" disabled="disabled">Verstuur printopdracht</button>
  </form>
  <br><br>
  <p id="calculations"></p>
  <img class="letsEncrypt" src="{{ asset('images/lets-encrypt.png') }}" alt="">


</div>
@endsection
