@extends('staff.layouts.app')

@section('title', 'Subscription Discount')

@section('content')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Subscription Discount')</h5>
        </div>
    </div>

    <div class="card mb-3 p-4">
        <div class="card-heade mb-4">
            <h5 class="mb-0">@lang('Update')</h5>
        </div>
        <div class="card-body p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.first.month.discount.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="percentage">@lang('Discount')</label>
                            <input placeholder="50" id="percentage" type="number" step="any" class="form-control"
                                name="percentage" value="{{ $setting?->first_month_subscribe_discount_percentage }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="percentage">@lang('Status')</label>
                            <div class="custom-control custom-switch d-flex mt-md-2">
                                <input class="custom-control-input" id="enable" type="checkbox" name="enable"
                                    value="1" {{ $setting?->first_month_subscribe_discount_status ? 'checked' : '' }}>
                                <label class="custom-control-label" for="enable">
                                    @lang('Enable')
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block btn-lg" type="submit">
                        @lang('Save')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
