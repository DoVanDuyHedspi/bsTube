@extends('layouts.auth')

@section('content')
<div class="container" style="padding-top: 80px">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header" style="background-color: rgb(51, 51, 51)">{{ __('Register') }}</div>

                <div class="card-body" style="background-color: rgb(26, 26, 26)">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <label for="username" class="col-form-label text-md-left">{{ __('Username') }}</label>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="username" style="background-color: rgb(26, 26, 26); color: white" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <label for="email" class="col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" style="background-color: rgb(26, 26, 26); color: white" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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

                        <label for="password-confirm" class="col-form-label text-md-left">{{ __('Confirm Password') }}</label>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password-confirm" style="background-color: rgb(26, 26, 26); color: white" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
