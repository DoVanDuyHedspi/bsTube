@extends('layouts.auth')

@section('content')
<div class="container" style="padding-top: 80px">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header" style="background-color: rgb(51, 51, 51)">{{ __('Login') }}</div>

                <div class="card-body" style="background-color: rgb(26, 26, 26)">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <label for="email" class="col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" style="background-color: rgb(26, 26, 26); color: white" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <label for="password" class="col-form-label text-md-left">{{ __('Password') }}</label>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" style="background-color: rgb(26, 26, 26); color: white" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <a class="btn btn-link" style="padding-top: 0" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
