@extends('staff.layouts.app')

@section('title', __('Edit Faq Group'))

@section('css_libs')
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3 p-4" id="app" v-cloak>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Edit Faq Group')</h5>
        </div>
        <div class="card-body bg-light p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.faq-group.update', $faq_group->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="question">@lang('title')</label>
                            <input id="title" type="text" class="form-control" name="title"
                                value="{{ $faq_group->title }}" required autofocus>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block btn-lg" type="submit">
                        @lang('Update Faq Group')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/staff/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
@endsection
