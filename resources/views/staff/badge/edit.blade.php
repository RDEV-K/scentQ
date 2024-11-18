@extends('staff.layouts.app')

@section('title', __('Edit Badge'))

@section('css_libs')
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3 p-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Badge Details')</h5>
        </div>
        <div class="card-body bg-light p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.badge.update', $badge->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <img class="img-thumbnail w-100"
                                    src="{{ $badge->image??'https://via.placeholder.com/200' }}"
                                    id="logo-preview"
                            >
                            <input type="hidden" name="image" value="{{ $badge->image }}" id="logo-input">
                            <button
                                class="btn btn-outline-info btn-block btn-select" data-input="#logo-input" data-preview="#logo-preview">@lang('Image')
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">@lang('Name')</label>
                            <input
                                id="name"
                                type="text"
                                class="form-control"
                                name="name"
                                value="{{ $badge->name }}"
                                required
                                autofocus
                            >
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <textarea class="tinymce form-control border" name="description" autofocus>
                                {{ $badge->description }}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <button
                                class="btn btn-primary btn-block btn-lg"
                                type="submit"
                            >
                                @lang('Update Badge')
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
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
@endsection

@section('js')
    <script>
        (function ($) {
            $(document).on('click', '.btn-select', function (e) {
                e.preventDefault()
                const input = $($(this).data('input'))
                const preview = $($(this).data('preview'))
                openMediaManager(items => {
                    if (items[0] && items[0].hasOwnProperty('url')) {
                        input.val(items[0].url)
                    }
                    if (items[0] && items[0].hasOwnProperty('thumb_url')) {
                        preview.attr('src', items[0].thumb_url)
                    }
                }, 'image', 'Select Avatar')
            })

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

            $(document).on('input', '#name', function () {
                const title = $(this).val()
                $('#slug').val(string_to_slug(title.toLowerCase()))
            })
        })(jQuery)
    </script>
@endsection
