<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Meta / SEO -->
    <meta name="description" content="Socialprint is een printer deelplatform voor studenten. Andere printers kunnen worden gevonden en de eigen printer kan beschikbaar worden gesteld.">
    <meta name="keywords" content="printer delen, printshop, drukkerij, thesis afdrukken, online printen, online documenten printen, eindwerk afdrukken, printer delen met studenten"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/MarkerCluster.css') }}">
    <link rel="stylesheet" href="{{ asset('css/MarkerCluster.Default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/MarkerCluster.Default.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">



    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.18.2"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- File specific scripts -->
    @stack('script')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arapey:ital@0;1&display=swap" rel="stylesheet">

</head>
<body>
    <div id="app">

      <header class="header">
    		<a class="logo" href="
        @guest
          {{route('welcome')}}
        @else
          {{route('home')}}
        @endguest
        ">
          <img src="{{ asset('images/logo_white.png')}}">
        </a>
          <ul id="#main-nav" class="main-nav">
              @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Registreer</a></li>
              @else
              <li><a href="{{ route('home') }}">Kaart</a></li>
              <li><a href="{{ route('printjobs') }}">Afdruktaken
                @if(session('notificationPrintjob')||session('notificationMessage'))
                <span class="chatBadge">&#128226;</span>
                @endif
              </a></li>
              <li><a href="{{ route('favorites') }}">Favorieten</a></li>
              <li><a href="{{ route('editaccount') }}">Account</a></li>
              @endguest
          </ul>
    	</header>


      <main class="py-4">
          @yield('content')
      </main>


    </div>
</body>
</html>
