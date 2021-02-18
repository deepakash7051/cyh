@extends('layouts.app')
@section('content')
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

                    @if (\Session::has('error'))
                        <div class="alert alert-error mb-0">
                            {!! \Session::get('error') !!}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('verifyusercode') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}"> 
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <input class="login-field {{ $errors->has('isd_code') ? ' is-invalid' : '' }}" type="text" name="isd_code" id="isd_code" placeholder="{{ trans('global.user.fields.isd_code') }}" maxlength="10" readonly value="{{$user->isd_code}}">

                                    @if ($errors->has('isd_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('isd_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <input class="login-field onlynumeric {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" name="phone" id="phone" placeholder="{{ trans('global.user.fields.phone') }}" maxlength="10" readonly value="{{$user->phone}}">

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> 
                        </div>
                        
                        <div class="form-group verification-code">
                            <input class="login-field" type="text" name="code" placeholder="{{ trans('global.pages.frontend.verifycode.verification_code') }}" required>
                            @if ($errors->has('code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif

                            <a class="resend" href="">{{ trans('global.pages.frontend.login.resend') }}</a>
                        </div>
                        <button type="submit" class="btnn">{{ trans('global.pages.frontend.verifycode.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="check-phone">
    <div class="check-phone-main">
        <h3>{{ trans('global.pages.frontend.verifycode.check_mobile') }}</h3>
        <p>{{ trans('global.pages.frontend.verifycode.send_verification_code') }}</p>
        <img src="{{ asset('images/planeicon.png') }}" alt="">
    </div>
</div>

@section('scripts')
@parent
<script type="text/javascript">
    $(document).ready(function() {

        $('.select2').select2()
        $(".check-phone").show();
        $("body").click(function(){
            $(".check-phone").fadeOut(1000);
        });
    
    });
</script>
@endsection

@endsection