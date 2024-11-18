@extends('staff.layouts.app')

@section('title', __('Create Label'))

@section('content')
    <div class="card mb-3 p-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Label Details')</h5>
        </div>
        <div class="card-body bg-light p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.label.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="label">@lang('Label')</label>
                            <input
                                id="label"
                                type="text"
                                class="form-control"
                                name="label"
                                value="{{ old('label') }}"
                                required
                                autofocus
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="color">@lang('Color')</label>
                            <input
                                id="color"
                                type="color"
                                class="form-control"
                                name="color"
                                value="{{ old('color') }}"
                                required
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button
                        class="btn btn-primary btn-block btn-lg"
                        type="submit"
                    >
                        @lang('Save Label')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
