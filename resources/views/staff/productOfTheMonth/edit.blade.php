@extends('staff.layouts.app')

@section('title', __('Edit Product Of The Month'))

@section('css_libs')
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3 p-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Product Of The Month Details')</h5>
        </div>
        <div class="card-body bg-light p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.product-of-the-month.update', $productOfTheMonth->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <img class="img-thumbnail w-100"
                                    src="{{ $productOfTheMonth->image??'https://via.placeholder.com/200' }}"
                                    id="logo-preview"
                            >
                            <input type="hidden" name="image" value="{{ $productOfTheMonth->image }}" id="logo-input">
                            <button
                                class="btn btn-outline-info btn-block btn-select" data-input="#logo-input" data-preview="#logo-preview">@lang('Image')
                            </button>
                        </div>
                    </div>
                    {{-- <div class="col-md-8">
                        <div class="form-group text-center">
                            <img class="img-thumbnail w-100"
                                    src="{{ $productOfTheMonth->cover_image??'https://via.placeholder.com/1208x621' }}"
                                    id="cover-preview"
                            >
                            <input type="hidden" name="cover_image" value="{{ $productOfTheMonth->cover_image }}" id="cover-input">
                            <button
                                class="btn btn-outline-info btn-block btn-select" data-input="#cover-input" data-preview="#cover-preview">@lang('Cover Image')
                            </button>
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">@lang('Title')</label>
                            <input
                                id="title"
                                type="text"
                                class="form-control"
                                name="title"
                                value="{{ $productOfTheMonth->title }}"

                                autofocus
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_id">@lang('Product')</label>
                            <select class="custom-select selectpicker" name="product_id" id="product_id">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        @if ($productOfTheMonth->product_id == $product->id)
                                            selected
                                        @endif
                                    >{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="month">@lang('Month')</label>
                            <input
                                id="month"
                                type="number"
                                min="1"
                                step="1"
                                max="12"
                                class="form-control"
                                name="month"
                                value="{{ $productOfTheMonth->month }}"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">@lang('Year')</label>
                            <input
                                id="year"
                                type="number"
                                min="0"
                                class="form-control"
                                name="year"
                                value="{{ $productOfTheMonth->year }}"
                            >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <textarea class="tinymce form-control border" name="description" autofocus>
                                {{ $productOfTheMonth->description }}
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 m-auto">
                        <div class="form-group">
                            <button
                                class="btn btn-primary btn-block btn-lg"
                                type="submit"
                            >
                                @lang('Update Product of the month')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
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
        })(jQuery)
    </script>
@endsection


