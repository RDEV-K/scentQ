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
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="post" action="{{ route('staff.password.email') }}">
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
                    <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">{{ __('Send Password Reset Link') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
