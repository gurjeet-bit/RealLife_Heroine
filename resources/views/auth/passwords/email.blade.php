@extends('layouts.app')

@section('content')


 <style>
    .main-wrapper
    {
        padding: 0;
    }
</style>
    <div class="login-page">
        <div class="login-body container">
            <div class="loginbox">
                <div class="login-right-wrap">
                    <div class="account-header">
                        <div class="account-logo text-center mb-4">
                            <a href="index.html">
                                <img src="assets/img/logo.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>
                    <div class="login-header text-center">
                        <h3>FORGOT PASSWORD</h3>
                    </div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Email</label>
                             <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary btn-block account-btn" type="submit"> {{ __('Send Password Reset Link') }}</button>
                        </div>
                    </form>
                    <div class="text-center forgotpass mt-4">Remember your password?<a href="{{ url('/login') }}">Login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
