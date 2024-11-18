@extends('staff.layouts.app')

@section('title', __('Edit Page'))

@section('css_libs')
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
<form action="{{  route('staff.page.update', $page->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row"  id="elo" v-cloak>
        <div class="col-md-8">
            <div class="card mb-3 p-5">
                <div class="card-header d-flex justify-content-between align-items-center px-0">
                    <h5 class="mb-0">@lang('Page Details')</h5>
                </div>
            <div class="card-body px-0">
                @include('layouts.notify')
                    <div class="row">
                        <div class="col-md-12">
                            {{-- totle Slug --}}
                            <div class="row">
                                <div class="{{ (!$page->is_builtin)?'col-md-6':'col-md-12' }}">
                                    <div class="form-group">
                                        <label for="title">@lang('Title')</label>
                                        <input id="title"
                                                type="text"
                                                class="form-control"
                                                name="title"
                                                required
                                                value="{{ $page->title }}"
                                                autofocus>
                                    </div>
                                </div>
                                @if (!$page->is_builtin)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="slug">@lang('Slug')</label>
                                            <input  id="slug"
                                                    type="text"
                                                    class="form-control"
                                                    name="slug"
                                                    value="{{ $page->slug }}"
                                                    required
                                                    autofocus>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- content --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content">@lang('Content')</label>
                                        <textarea class="tinymce form-control border" name="content" autofocus>
                                            {{ $page->content }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <button class="btn btn-success"
                            type="submit"
                            name="status"
                            value="published"
                            onclick="return confirm('Are you sure?')">
                                @lang('Publish')
                    </button>
                    @if (!$page->is_builtin)
                        <button class="btn btn-outline-warning"
                                type="submit"
                                name="status"
                                value="drafted"
                                onclick="return confirm('Are you sure?')">
                                    @lang('Draft')
                        </button>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex justify-content-between align-items-center px-0">
                        <h5 class="mb-0">@lang('Page Image')</h5>
                    </div>
                    <div class="form-group text-center">
                        <img class="img-thumbnail w-100"
                                src="{{ old('image')?? $page->image }}"
                                id="avatar-preview">
                        <input type="hidden" name="image" value="{{ $page->image }}" id="image">
                        <button
                            class="btn btn-outline-info btn-block btn-select">@lang(' Page Image')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/staff/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
@endsection

@section('js')
<script>
    window.vueApp = new Vue({
        el: '#elo',
        data: {
            type: @json( $page->type ??'landing'),
            metaTaxonomy: @json($meta->content??'')
        },
    })

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
    });

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

    $(document).on('input', '#title', function () {
        const title = $(this).val()
        $('#slug').val(string_to_slug(title.toLowerCase()))
    })

    $(document).on('click', '.btn-select', function (e) {
        e.preventDefault()
        openMediaManager(items => {
            if (items[0] && items[0].hasOwnProperty('url')) {
                $('#image').val(items[0].url)
            }
            if (items[0] && items[0].hasOwnProperty('thumb_url')) {
                $('#avatar-preview').attr('src', items[0].thumb_url)
            }
        }, 'image', 'Select Avatar')
    })
</script>
@endsection

