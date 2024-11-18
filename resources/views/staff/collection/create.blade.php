@extends('staff.layouts.app')

@section('title', __('Create Collection'))

@section('css_libs')
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3 p-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Collection Details')</h5>
        </div>
        <div class="card-body bg-light p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.collection.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <img class="img-thumbnail w-100"
                                    src="{{ old('image')??'https://via.placeholder.com/200' }}"
                                    id="logo-preview"
                            >
                            <input type="hidden" name="image" value="{{ old('image') }}" id="logo-input">
                            <button
                                class="btn btn-outline-info btn-block btn-select" data-input="#logo-input" data-preview="#logo-preview">@lang('Image')
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8">
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
                                    <label for="slug">@lang('slug')</label>
                                    <input
                                        id="slug"
                                        type="text"
                                        class="form-control"
                                        name="slug"
                                        value="{{ old('slug') }}"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">@lang('Type')</label>
                                    <select name="type" id="type" class="custom-select" required>
                                        <option value="curated" {{ old('type') == 'curated'?'selected':'' }}>Curated</option>
                                        <option value="capsule" {{ old('type') == 'capsule'?'selected':'' }}>Capsule</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="for">@lang('For')</label>
                                    <select name="for" id="for" class="custom-select" required>
                                        <option value="women" {{ old('for') == 'women'?'selected':'' }}>Women</option>
                                        <option value="men" {{ old('for') == 'men'?'selected':'' }}>Men</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc">@lang('Description')</label>
                    <textarea class="tinymce form-control border" name="desc">
                                {{ old('desc') }}
                            </textarea>
                </div>
                <div class="form-group">
                    <button
                        class="btn btn-primary btn-block btn-lg"
                        type="submit"
                    >
                        @lang('Save Collection')
                    </button>
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
