@extends('layouts.app')
@section('content')

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
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="form-group">
                            <input class="login-field  @error('email') is-invalid @enderror" value="{{ old('email') }}" type="email" name="email" placeholder="Enter your email" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="login-field @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btnn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection