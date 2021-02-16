@extends('layouts.app')
@section('content')

<body class="login-page dots">
<header class="header-type1">
    <div class="logo-wrap"><a href=""><img src="{{ asset('images/logo.png') }}" alt=""></a></div>
</header>

<?php 

    $CountryCodesJson = file_get_contents(base_path('uploads/CountryCodes.json'));
    $CountryCodes = json_decode($CountryCodesJson);
?>
<div class="login-wrap">
    <div class="container container-l">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-6"><img src="{{ asset('images/login-img.png') }}"></div>
            <div class="col-lg-4 col-md-5 col-sm-6">
                <div class="login-form">
                    <div class="login-head">
                        <h2><span>{{ trans('global.pages.frontend.login.hello') }}</span> {{ trans('global.pages.frontend.login.welcome_back') }}</h2>
                        <p>{{ trans('global.pages.frontend.login.login_account') }}</p>
                    </div>
                    <form method="POST" action="{{ route('sendcode') }}">
                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="login-field select2 {{ $errors->has('isd_code') ? ' is-invalid' : '' }}" name="isd_code" id="isd_code" required>
                                        @foreach($CountryCodes as $CountryCode)
                                            <option value="{{$CountryCode->dial_code}}">
                                                {{$CountryCode->dial_code.' ('.$CountryCode->code.')'}}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('isd_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('isd_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <input class="login-field onlynumeric {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" name="phone" id="phone" placeholder="Enter your phone" maxlength="10" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> 
                        </div>
                        
                        <div class="form-group verification-code">
                            <input class="login-field" type="text" name="verification-code" placeholder="Verification code">


                            <a class="resend" href="">{{ trans('global.pages.frontend.login.resend') }}</a>
                        </div>
                        <button type="button" class="btnn">{{ trans('global.pages.frontend.login.continue') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="check-phone">
    <div class="check-phone-main">
        <h3>Check your mobile!</h3>
        <p>We have sent you a verification code.</p>
        <img src="{{ asset('images/planeicon.png') }}" alt="">
    </div>
</div>
</body>
@endsection