@extends('layouts.app')
@section('content')
<div class="container">
  <div class="centered">


    <h1 class="bigTitle">&#128272; Privacy</h1>
    <div class="a-staticpage">
      <ul class="a-container">

        <li class="a-items">
          <input type="radio" name="ac" id="a1" />
          <label for="a1">About Us</label>
          <div class="a-content">
            <h2>What's Up?</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam beatae maiores possimus sequi non quidem ad necessitatibus fugiat consectetur veritatis laboriosam ut soluta quis deleniti deserunt! Voluptate qui excepturi architecto.</p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a2" />
          <label for="a2">Our Services</label>
          <div class="a-content">
            <h3>Design</h3>
            <p>Lorem ipsum dolor sit amet, quidem ad necessitatibus fugiat consectetur veritatis laboriosam ut soluta quis deleniti deserunt! Voluptate qui excepturi architecto.</p>
            <h3>Development</h3>
            <p>Lorem ipsum dolor sit amet, quidem ad necessitatibus fugiat consectetur veritatis laboriosam ut soluta quis deleniti deserunt! Voluptate qui excepturi architecto.</p>
          </div>
        </li>

        <li class="a-items">
          <input type="radio" name="ac" id="a3" />
          <label for="a3">Keep In Touch</label>
          <div class="a-content">
            <h2>hello world!</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam beatae maiores possimus sequi non quidem ad necessitatibus fugiat consectetur veritatis laboriosam ut soluta.</p>
          </div>
        </li>


      </ul>
    </div>
    <br><br>
  </div>
</div>


  @include('layouts.footer')
@endsection
