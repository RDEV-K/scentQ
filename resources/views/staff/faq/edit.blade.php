@extends('staff.layouts.app')

@section('title', __('Edit Faq'))

@section('css_libs')
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3 p-4" id="app" v-cloak>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Faq Details')</h5>
        </div>
        <div class="card-body bg-light p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.faq.update', $faq->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="group">@lang('Group')</label>
                            <select class="form-control" name="group" id="group">
                                @foreach ($groups as $group)
                                    <option {{ $faq->faq_group_id == $group->id ? 'selected' : '' }}
                                        value="{{ $group->id }}">
                                        {{ $group->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="question">@lang('Name')</label>
                            <input id="question" type="text" class="form-control" name="question"
                                value="{{ $faq->question }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="answer">@lang('Answer')</label>
                            <textarea rows="4" placeholder="{{ __('Answer') }}" class="form-control border tinymce" name="answer">{{ $faq->answer }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block btn-lg" type="submit">
                        @lang('Update Faq')
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
