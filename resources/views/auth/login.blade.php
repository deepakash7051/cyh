@extends('layouts.app')
@section('content')
<?php 

    $CountryCodesJson = file_get_contents(base_path('uploads/CountryCodes.json'));
    $CountryCodes = json_decode($CountryCodesJson);
?>
<div class="login-wrap">
    <div class="container container-l">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-6">
                <img src="{{ asset('images/login-img.png') }}">
            </div>
            <div class="col-lg-4 col-md-5 col-sm-6">
                <div class="login-form">
                    <div class="login-head">
                        <h2><span>{{ trans('global.pages.frontend.login.hello') }}</span> {{ trans('global.pages.frontend.login.welcome_back') }}</h2>
                        <p>{{ trans('global.pages.frontend.login.login_account') }}</p>
                    </div>

                    @if (\Session::has('error'))
                        <div class="alert alert-error mb-0">
                            {!! \Session::get('error') !!}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('sendcode') }}">
                        @csrf

                        <div class="form-group">
                            <input class="login-field {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" id="email" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input class="login-field {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Enter your password" id="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btnn" id="loginbtn">
                            {{ trans('global.login') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection