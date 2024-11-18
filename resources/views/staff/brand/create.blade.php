@extends('staff.layouts.app')

@section('title', __('Create Brand'))

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
    <div class="card mb-3 p-4">

        {{-- card header --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Brand Details')</h5>
        </div>
        {{-- card header --}}

        {{-- card body --}}
        <div class="card-body bg-light p-0">
            @include('layouts.notify')

            {{-- form start --}}
            <form action="{{ route('staff.brand.store') }}" method="post">
                @csrf

                {{-- img row --}}
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
                        <div class="form-group text-center">
                            <img class="img-thumbnail w-100"
                                    src="{{ old('cover_image')??'https://via.placeholder.com/1208x621' }}"
                                    id="cover-preview"
                            >
                            <input type="hidden" name="cover_image" value="{{ old('cover_image') }}" id="cover-input">
                            <button
                                class="btn btn-outline-info btn-block btn-select" data-input="#cover-input" data-preview="#cover-preview">@lang('Cover Image')
                            </button>
                        </div>
                    </div>
                </div>
                {{-- img row --}}

                <div class="row">
                    {{-- name --}}
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
                    {{-- name --}}

                    {{-- slug --}}
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
                                autofocus
                            >
                        </div>
                    </div>
                    {{-- slug --}}
                </div>

                <div class="row">
                    {{-- Establish Date --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="est_text">@lang('Establish Date')</label>
                            <input
                                id="est_text"
                                type="text"
                                class="form-control"
                                name="est_text"
                                value="{{ old('est_text') }}"
                                required
                            >
                        </div>
                    </div>
                    {{-- Establish Date --}}

                    {{-- Add To --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="meta-add_to">@lang('Add To')</label>
                            <select name="meta[add_to][]" id="meta-add_to" class="form-control selectpicker" multiple>
                                @foreach(\App\Models\Product::$types as $type)
                                    <option value="{{ $type }}" {{ is_array(old('meta.add_to')) && in_array($type, old('meta.add_to'))?'selected':'' }}>{{ ucwords(str_replace('_', ' ', $type)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Add To --}}
                </div>

                <div class="row"  id="elo" v-cloak>
                    {{-- BLog --}}
                    <div class="col-md-6 my-3" v-for="(blog, blogIndex) in blogs" :key="blogIndex">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="align-items-center d-flex justify-content-between">@lang("BLog") @{{
                                    blogIndex+1 }}
                                    <button class="btn btn-sm btn-warning"
                                            type="button"
                                            @click="removeBlog(blogIndex)"><i
                                            class="fas fa-trash"></i>
                                    </button>
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group text-center">
                                    <img class="img-thumbnail w-100"
                                            :src="blog.blog_image"
                                            id="blog-image-preview"
                                    >
                                    <input type="hidden" :name="'blogs['+blogIndex+'][blog_image]'" v-model="blog.blog_image" id="blog-image-input">
                                    <button class="btn btn-outline-info btn-block" @click.prevent="blogImage(blogIndex)">@lang('Blog Image')
                                    </button>
                                </div>

                                <div class="form-group">
                                    <label for="title">@lang('Title')</label>
                                    <input
                                        :name="'blogs['+blogIndex+'][title]'"
                                        type="text"
                                        class="form-control"
                                        v-model="blog.title"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="desc">@lang('Description')</label>
                                    <textarea class="form-control" :name="'blogs['+blogIndex+'][desc]'" v-model="blog.desc"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="button text">@lang('Button Text')</label>
                                    <input
                                        :name="'blogs['+blogIndex+'][button_text]'"
                                        type="text"
                                        class="form-control"
                                        v-model="blog.button_text"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="button link">@lang('Button Link')</label>
                                    <input
                                        :name="'blogs['+blogIndex+'][button_link]'"
                                        type="text"
                                        class="form-control"
                                        v-model="blog.button_link"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label style="visibility: hidden">@lang('Add Blog')</label>
                        <button type="button" class="btn btn-primary w-100" @click="addBlog">Add Blog</button>
                    </div>
                    {{-- BLog --}}
                </div>

                <div class="form-group">
                    <label for="description">@lang('Description')</label>
                    <textarea class="tinymce form-control border" name="description" autofocus>
                        {{ old('description') }}
                    </textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary btn-block btn-lg" type="submit">@lang('Save Brand')</button>
                </div>
            </form>
            {{-- form end --}}

        </div>
        {{-- card body --}}

    </div>=
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
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
                blogs: @json(old('blogs')??[])
            },
            methods: {
                addBlog() {
                    this.blogs.push({
                        title: null,
                        desc: null,
                        blog_image: null,
                        button_text: null,
                        button_link: null
                    });
                },
                removeBlog(blogIndex) {
                    this.blogs.splice(blogIndex, 1)
                },
                blogImage(blogIndex) {
                    const currBlog = this.blogs[blogIndex]
                    openMediaManager(items => {
                        // console.log(items);
                        if (items[0] && items[0].hasOwnProperty('url')) {
                            currBlog.blog_image = items[0].url
                        }
                    }, 'image', 'Select Blog Image')
                    // console.log(currIndex)
                }
            },
        });
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
