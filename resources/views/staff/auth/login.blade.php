@extends('staff.layouts.auth')

@section('title', __('Login'))

@section('content')
    <div class="card">
        <div class="card-body p-4 p-sm-5">
            <div class="row text-left justify-content-between align-items-center mb-2">
                <div class="col-auto">
                    <h5>@lang('Login')</h5>
                </div>
            </div>
            <form method="post" action="{{ route('staff.login') }}">
                @csrf
                <div class="form-group">
                    <input class="form-control @error('email') is-invalid @enderror" type="email" placeholder="@lang('Email address')" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="@lang('Password')" required autocomplete="current-password" />
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                            <label class="custom-control-label" for="remember">@lang('Remember me')</label>
                        </div>
                    </div>
                    <div class="col-auto"><a class="fs--1" href="{{ route('staff.password.request') }}">@lang('Forgot Password?')</a></div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">@lang('Login')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
