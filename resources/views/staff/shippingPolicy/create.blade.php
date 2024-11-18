@extends('staff.layouts.app')

@section('title', __('Create Shipping Policy'))

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('css')
<style>
    [v-cloak] {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card mb-3 p-4">
            <div class="card-header p-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@lang('Shipping Policy Details')</h5>
            </div>
            <div class="card-body bg-light p-0 mt-5">
                @include('layouts.notify')
                <form action="{{ route('staff.shipping-policy.store') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input
                                    id="name"
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="charge">@lang('charge')</label>
                                <div class="input-group">
                                    <input
                                        id="charge"
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        class="form-control"
                                        name="charge"
                                        value="{{ old('charge') }}"
                                        autofocus
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ config('misc.currency_code') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- begin Previous minimum amount range  --}}
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Minimum Amount">@lang('Minimum Amount')</label>
                                <div class="input-group">
                                    <input
                                        id="minimum_amount"
                                        type="number"
                                        min="0"
                                        step="0.1"
                                        class="form-control"
                                        name="minimum_amount"
                                        value="{{ old('minimum_amount') }}"
                                        autofocus
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ config('misc.currency_code') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Maximum Amount">@lang('Maximum Amount')</label>
                                <div class="input-group">
                                    <input
                                        id="maximum_amount"
                                        type="number"
                                        min="0"
                                        step="0.1"
                                        class="form-control"
                                        name="maximum_amount"
                                        value="{{ old('maximum_amount') }}"
                                        autofocus
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ config('misc.currency_code') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row" id="olo" v-cloak>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="countries">country</label>
                                <select2 v-model="meta.country"
                                        class="form-control"
                                        name="meta[country][]"
                                        :options="countriesAsSelect2"
                                        multiple
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select2 v-model="meta.state"
                                        class="form-control"
                                        name="meta[state][]"
                                        :options="statesAsSelect2"
                                        multiple
                                />
                            </div>
                        </div>
                    </div> --}}
                     {{-- end Previous minimum amount range  --}}
                    {{-- submit button --}}
                    <div class="row mt-5">
                        <div class="offset-md-7 col-md-5">
                            <div class="form-group">
                                <button
                                    class="btn btn-primary btn-block btn-lg"
                                    type="submit"
                                >
                                    @lang('Save Policy')
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- submit button --}}

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/staff/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
    <script src="{{ asset('assets/js/select2.vue.js') }}"></script>
@endsection

@section('js')
    <script>
        window.app = new Vue({
            el: '#olo',
            components: {
                select2: window.select2Vue
            },
            data: {
                countries: @json($countries),
                states: @json($states),
                meta: {
                    country: @json(old('meta.country', [])),
                    state: @json(old('meta.state', []))
                }
            },
            computed: {
                countriesAsSelect2() {
                    return Object.keys(this.countries).map(code => {
                        return {
                            id: code,
                            text: this.countries[code]
                        }
                    })
                },
                statesAsSelect2() {
                    let states = Object.keys(this.states).reduce((acc, countryCode) => {
                        if (this.meta.country.includes(countryCode)) {
                            return {...acc, ...this.states[countryCode]}
                        }
                        return  acc;
                    }, {})

                    return Object.keys(states).map(code => {
                        return {
                            id: code,
                            text: states[code]
                        }
                    })
                }
            },
        })
    </script>
@endsection
