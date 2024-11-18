@extends('staff.layouts.auth')

@section('title', __('Reset Password'))

@section('content')
    <div class="card">
        <div class="card-body p-4 p-sm-5">
            <div class="row text-left justify-content-between align-items-center mb-2">
                <div class="col-auto">
                    <h5>@lang('Reset Password')</h5>
                </div>
            </div>
            <form method="post" action="{{ route('staff.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <input class="form-control @error('email') is-invalid @enderror" type="email" placeholder="@lang('Email address')" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus />
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="@lang('Password')" required autocomplete="new-password" />
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation" placeholder="@lang('Confirm Password')" required autocomplete="new-password" />
                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">{{ __('Reset Password') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
