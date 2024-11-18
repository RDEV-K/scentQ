@extends('staff.layouts.app')

@section('title', __('Edit Customer'))

@section('css_libs')
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Customer Details')</h5>
        </div>
        <div class="card-body">
            @include('layouts.notify')
            <form action="{{ route('staff.customer.update', $user->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <img class="img-thumbnail w-100"
                                 src="{{ $user->avatar??'https://via.placeholder.com/200' }}"
                                 id="avatar-preview">
                            <input type="hidden" name="avatar" value="{{ $user->avatar }}" id="avatar">
                            <button
                                class="btn btn-outline-info btn-block btn-select">@lang('Change Avatar')
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">@lang('First Name')</label>
                                    <input id="first_name" type="text" class="form-control"
                                           name="first_name" value="{{ $user->first_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">@lang('Last Name')</label>
                                    <input id="last_name" type="text" class="form-control"
                                           name="last_name" value="{{ $user->last_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">@lang('Date of Birth')</label>
                                    <input class="form-control datetimepicker" id="dob" type="text"
                                           placeholder="dd/mm/yyyy"
                                           data-options='{"dateFormat":"d/m/Y"}' name="dob"
                                           value="{{ optional($user->dob)->format('d/m/Y') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input class="custom-control-input" id="email_verification"
                                               type="checkbox" name="email_verification" value="1"
                                               {{ $user->email_verified_at?'checked':'' }} data-toggle="toggle"
                                               data-onstyle="success" data-offstyle="danger">
                                        <label class="custom-control-label"
                                               for="email_verification">@lang('Email Verification')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input class="custom-control-input" id="status" type="checkbox"
                                               name="status" value="1"
                                               {{ $user->is_active == 1?'checked':'' }} data-toggle="toggle"
                                               data-onstyle="success" data-offstyle="danger">
                                        <label class="custom-control-label"
                                               for="status">@lang('Status')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" id="male" type="radio"
                                               name="gender"
                                               value="male" {{  $user->gender == 'male'?'checked':''  }}>
                                        <label class="custom-control-label"
                                               for="male">@lang('Male')</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" id="female" type="radio"
                                                   name="gender"
                                                   value="female" {{  $user->gender == 'female'?'checked':''  }}>
                                            <label class="custom-control-label"
                                                   for="female">@lang('Female')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">@lang('Password')</label>
                                    <input id="password" type="password" class="form-control"
                                           name="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">@lang('Retype Password')</label>
                                    <input id="password_confirmation" type="password" class="form-control"
                                           name="password_confirmation">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">
                                        @lang('Account For')
                                    </label>
                                    <select class="form-control" name="domain" id="domain">
                                        <option @selected($user->account_for == 'scentq.com') value="scentq.com">scentq.com</option>
                                        <option @selected($user->account_for == 'scentq.co.uk') value="scentq.co.uk">scentq.co.uk</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block btn-lg" type="submit">@lang('Update Customer')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/staff/js/bootstrap4-toggle.min.js') }}"></script>
@endsection

@section('js')
    <script>
        (function ($) {
            $(document).on('click', '.btn-select', function (e) {
                e.preventDefault()
                openMediaManager(items => {
                    if (items[0] && items[0].hasOwnProperty('url')) {
                        $('#avatar').val(items[0].url)
                    }
                    if (items[0] && items[0].hasOwnProperty('thumb_url')) {
                        $('#avatar-preview').attr('src', items[0].thumb_url)
                    }
                }, 'image', 'Select Avatar')
            })
        })(jQuery)
    </script>
@endsection
