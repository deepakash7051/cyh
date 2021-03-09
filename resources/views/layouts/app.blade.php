<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('global.site_title') }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    @yield('styles')
    
</head>
<body class="login-page dots">
    <input type="hidden" value="{{url('/')}}" id="base_url">
    <header class="header-type1">
        <div class="logo-wrap"><a href=""><img src="{{ asset('images/SWA-Logo.png') }}" alt=""></a></div>
    </header>

    @yield('content')

    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
   <!--  <script src="{{ asset('js/main.js') }}"></script> -->

    @yield('scripts')

</body>
</html>
