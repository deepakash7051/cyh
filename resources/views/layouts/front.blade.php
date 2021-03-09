<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>{{ trans('global.site_title') }}</title>

  <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" />

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
  <!--  <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" /> -->
  <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/select.dataTables.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/coreui.min.css') }}" rel="stylesheet" />

  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />

  <link href="{{ asset('css/dropzone.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">


  @yield('styles')
</head>

<body class="">
<header class="header-type2">
  <div class="d-flex align-items-center justify-content-between">
    <div class="logo-wrap"><a href="{{url('/home')}}"><img src="{{ asset('images/SWA-Logo.png') }}" alt=""></a></div>
    <div class="head-right d-flex align-items-center">
      <div class="user-wrap d-flex align-items-center">
        <p>{{Auth::user()->name}}</p>
        <img src="{{ asset('images/dp.png') }}" alt="">
      </div>

      <!-- <div class="dropdown show"> -->
              <button type="button" class="btn btn-primary dropdown-toggle actions-wrp" data-toggle="dropdown" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span></span>
                  <span></span>
                  <span></span>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @if(count(config('panel.available_languages', [])) > 1)
                    @foreach(config('panel.available_languages') as $langLocale => $langName)
                        <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                    @endforeach
                @endif
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    {{ trans('global.logout') }}
                </a>
              </div>
              
            <!-- </div> -->
    </div>
  </div>
</header>

@yield('content')

<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script src="{{ asset('js/coreui.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/jszip.min.js') }}"></script>
<script src="{{ asset('js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('js/ckeditor.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

<script>
  $(document).ready(function(){
    $(".fixedbar").hide();
    $(".toggle").click(function(){
      $(".fixedbar").slideToggle();
    });
  });
</script>
@yield('scripts')

</body>
</html>