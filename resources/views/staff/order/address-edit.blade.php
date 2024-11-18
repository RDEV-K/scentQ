@extends('staff.layouts.app')

@section('title', __('Edit Address'))

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('css')
    <style>
        [v-cloak] {
            display: none;
        }

        .taxonomy-checklist {
            max-height: 200px;
            overflow-y: scroll;
        }

        .taxonomy-checklist, .taxonomy-checklist ul {
            list-style: none;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('staff.update.address', $orderAddress->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('layouts.notify')
        <div class="row justify-content-center" id="app" v-cloak>
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">@lang('Edit Address')</h5>
                    </div>
                    <div class="card-body">
                        @include('layouts.notify')
                        <div class="form-group">
                            <label for="city">@lang('City')</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                   value="{{ old('city', $orderAddress->city) }}" name="city" id="city" required>
                            @error('city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="line1">@lang('Address Line 1')</label>
                            <input type="text" class="form-control @error('line1') is-invalid @enderror"
                                   value="{{ old('line1', $orderAddress->line1) }}" name="line1" id="line1" required>
                            @error('line1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="line2">@lang('Address Line 2')</label>
                            <input type="text" class="form-control @error('line2') is-invalid @enderror"
                                   value="{{ old('line2', $orderAddress->line2) }}" name="line2" id="line2">
                            @error('line2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="postal_code">@lang('Postal Code')</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                   value="{{ old('postal_code', $orderAddress->postal_code) }}" name="postal_code" id="postal_code" required>
                            @error('postal_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
            </div>
        </div>
    </form>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
    <script src="{{ asset('assets/js/select2.vue.js') }}"></script>
@endsection

@section('js')
    <script>
        function string_to_slug(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        }

        window.app = new Vue({
            el: '#app',
            data: {
                type: @json($orderAddress->type),
                name: @json($orderAddress->name),
                email: @json($orderAddress->email),
                phone: @json($orderAddress->phone),
                country: @json($orderAddress->country),
                state: @json($orderAddress->state),
                city: @json($orderAddress->city),
                line1: @json($orderAddress->line1),
                line2: @json($orderAddress->line2),
                postal_code: @json($orderAddress->postal_code)
            },
            watch: {
                name(newVal) {
                    this.slug = string_to_slug(newVal.toLowerCase())
                }
            }
        });
    </script>
@endsection
