@extends('layouts.auth')

@section('content')
<div class="container" style="padding-top: 80px">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header" style="background-color: rgb(51, 51, 51)">{{ __('Reset Password') }}</div>

                <div class="card-body" style="background-color: rgb(26, 26, 26)">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
