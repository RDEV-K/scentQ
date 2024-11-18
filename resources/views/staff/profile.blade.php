@extends('staff.layouts.app')

@section('title', __('Profile'))

@section('content')
    <div class="card mb-3">
        <div class="card-body bg-light px-0">
            <form action="{{ route('staff.profile.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="container-fluid ">
                    @include('layouts.notify')
                    <div class="row m-5">
                        <div class="col-md-4">
                            <div class="form-group text-center">

                                <img class="img-thumbnail" style="width: 200px; height: 200px;"
                                     src="{{ $user->avatar }}" id="avatar-preview">
                                <input type="hidden" name="avatar" value="{{ $user->avatar }}" id="avatar">
                                <button class="btn btn-outline-info btn-select d-block" style="width: 100%;">Change Avatar</button>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="">
                                <div class="d-flex justify-content-between align-content-center">
                                    <div class="">
                                        <h3>{{ $user->name }}</h3>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input id="name" type="text" class="form-control" name="name"
                                               value="{{ $user->name }}" required>
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
                                                <label for="phone">UserName</label>
                                                <input id="phone" type="text" class="form-control" name="username"
                                                       value="{{ $user->username }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password (Optional)</label>
                                                <input id="password" type="password" class="form-control"
                                                       name="password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Retype Password (Optional)</label>
                                                <input id="password_confirmation" type="text" class="form-control"
                                                       name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block btn-lg" type="submit">Update Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
@section('js_libs')
    <script src="{{ asset('assets/lib/echarts/echarts.min.js') }}"></script>
@endsection
