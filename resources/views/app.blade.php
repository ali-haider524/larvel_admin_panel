
<!DOCTYPE html>
@if (\Request::is('pages-rtl'))
  <html dir="rtl" lang="ar">
@else
  <html lang="en" >
@endif
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/images/favicon.png')}}">
  <link rel="icon" type="image/png" href="{{ url('/images/favicon.png')}}">
  <title>{{env('APP_NAME')}}</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ URL::asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <link href="{{ URL::asset('css/soft-ui-dashboard.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <link href="{{ URL::asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ URL::asset('assets/css/soft-ui-dashboard.css?v=1.0.4') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100 {{ (\Request::is('pages-rtl') ? 'rtl' : (Request::is('dashboard-virtual-default')||Request::is('dashboard-virtual-info') ? 'virtual-reality' : (Request::is('authentication-error404')||Request::is('authentication-error500') ? 'error-page' : ''))) }}">
  @auth
    @yield('auth')
  @endauth
  @guest
    @yield('guest')
  @endguest

  <!--   Core JS Files   -->
  <script src="{{ URL::asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

  <script src="../../assets/js/plugins/sweetalert.min.js"></script>
<script src="../../assets/js/plugins/action.js"></script>

  <!-- Kanban scripts -->
  <script src="{{ URL::asset('assets/js/plugins/dragula/dragula.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/jkanban/jkanban.js') }}"></script>
  @stack('js')
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ URL::asset('assets/js/soft-ui-dashboard.min.js?v=1.0.4') }}"></script>

</body>

</html>
