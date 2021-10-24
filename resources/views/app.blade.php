<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>{{ ucwords(str_replace(array('/'), ' ', Request::path())) }} - Free Dashboard for Bootstrap 4</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/assets/img/brand/favicon.png') }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('assets/assets/css/argon.css?v=1.2.0') }}" type="text/css">
  <link href="{{ asset('css/app.css') }}">
</head>
<body>
  <div id="app">
      @if (Request::is('dashboard*'))
          <sidey></sidey>
      @endif
      <div class="main-content" id="panel">
          @if (Request::is('dashboard*'))
              <topny></topny>
          @endif
          <app></app>
          {{ uniqid() }}
      </div>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <!-- Optional JS -->
  <script src="{{ asset('assets/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('assets/assets/js/argon.js?v=1.2.0') }}"></script>
  <script src="//cdn.jsdelivr.net/npm/eruda"></script>
  <script>eruda.init();</script>
</body>

</html>
