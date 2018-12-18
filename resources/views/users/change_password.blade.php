@extends('layouts.auth')
@section('content')
    <div class="container" style="padding-top: 80px">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header" style="background-color: rgb(51, 51, 51)">{{ __('Change Password') }}</div>

                    <div class="card-body" style="background-color: rgb(26, 26, 26)">
                        <form method="POST" action="{{ route('changePassword') }}">
                            @csrf
                            @if (session('success'))
                                <div class="form-group row">
                                    <label for="current-password" class="col-form-label text-md-left" style="color: green; padding-left: 20px">
                                        {{ session('success') }}
                                    </label>
                                </div>
                            @endif
                            <label for="current-password" class="col-form-label text-md-left">{{ __('Current Password') }}</label>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="current-password" style="background-color: rgb(26, 26, 26); color: white" type="password" class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}" name="current-password" required autofocus>
                                    @if ($errors->has('current-password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <label for="new-password" class="col-form-label text-md-left">{{ __('New Password') }}</label>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="new-password" style="background-color: rgb(26, 26, 26); color: white" type="password" class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}" name="new-password" required>
                                    @if ($errors->has('new-password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('new-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <label for="password-confirmation" class="col-form-label text-md-left">{{ __('Confirm Password') }}</label>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password-confirmation" style="background-color: rgb(26, 26, 26); color: white" type="password" class="form-control" name="password-confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Change') }}
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

