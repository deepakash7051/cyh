@extends('layouts.app')
@section('content')

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
                        <h2><span>Hello!</span> Welcome Back</h2>
                        <p>Login to your account</p>
                    </div>
                    <form>
                        <div class="form-group"><input class="login-field" type="text" name="phone-number" placeholder="Enter your number"></div>
                        <div class="form-group verification-code">
                            <input class="login-field" type="text" name="verification-code" placeholder="Verification code">
                            <a class="resend" href="">Resend</a>
                        </div>
                        <button id="continue-btn" type="button" class="btnn">Continue</button>
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