@extends('layouts.app')
@section('content')
<?php 

    $CountryCodesJson = file_get_contents(base_path('uploads/CountryCodes.json'));
    $CountryCodes = json_decode($CountryCodesJson);
?>
<body class="login-page dots">
<header class="header-type1">
    <div class="logo-wrap"><a href=""><img src="{{ asset('images/logo.png') }}" alt=""></a></div>
</header>
<div class="login-wrap">
    <div class="container container-l">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-6"><img src="{{ asset('images/login-img.png') }}"></div>
            <div class="col-lg-4 col-md-5 col-sm-6">
                <div class="login-form">
                    <div class="login-head">
                        <h2><span>Hello!</span></h2>
                        <p>Register for new account</p>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <input class="login-field {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" placeholder="Enter your name"  value="{{ old('name') }}" id="name" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input class="login-field {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" id="email" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <select class="login-field {{ $errors->has('isd_code') ? ' is-invalid' : '' }}" name="isd_code" id="isd_code" required>
                                        <option value="">Select</option>
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
                                <div class="col-md-7">
                                    <input class="login-field {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" name="phone" id="phone" placeholder="Enter your phone" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="10" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> 
                        </div>
                        <div class="form-group">
                            <input class="login-field {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Enter your password" id="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input class="login-field" type="password" name="password_confirmation" placeholder="Confirm your password" id="password-confirm" >

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button id="continue-btn" type="submit" class="btnn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection