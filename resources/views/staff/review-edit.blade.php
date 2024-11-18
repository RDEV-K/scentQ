@extends('staff.layouts.app')

@section('title', __('Edit Review'))

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('css')
@endsection

@section('content')
    <div class="row" id="app">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Edit Review</h5>
                </div>
                <div class="card-body">
                    @include('layouts.notify')
                    <form action="{{ route('staff.review.update', $review->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Select Product')</label>
                                        <select name="product_id" id="new-product-id" class="form-control selectpicker">
                                            @foreach ($products as $pr)
                                                <option value="{{ $pr->id }}"
                                                    {{ $review->product_id == $pr->id ? 'selected' : '' }}>
                                                    {{ $pr->id }}.
                                                    {{ $pr->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Rate between 1-5')</label>
                                        <input type="number" min="1" max="5" name="rate" id="new-rate"
                                            class="form-control" value="{{ $review->rate ?? 5 }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5>{{ __('Add a few helpful tags!') }}</h5>
                                @foreach ($taxonomies as $taxonomy)
                                    <div class="mt-3">
                                        @if ($taxonomy->terms->count())
                                            <p class="mt-0 mb-2 text-uppercase">
                                                👍 {{ $taxonomy->name }}
                                            </p>
                                            <div class="d-flex align-items-center">
                                                @foreach ($taxonomy->terms as $term)
                                                    <div class="review-term-input mr-3">
                                                        <input type="checkbox" name="terms[]" id="term-{{ $term->id }}"
                                                            value="{{ $term->id }}"
                                                            {{ in_array($term->id, $terms ?? []) ? 'checked' : '' }} />
                                                        <label for="term-{{ $term->id }}">{{ $term->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <h5>Reviewer Details</h5>
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <div class="form-group text-center">
                                            <img class="img-thumbnail w-100"
                                                src="{{ $review->reviewer_avatar ?? 'https://via.placeholder.com/200' }}"
                                                id="avatar-preview">
                                            <input type="hidden" name="reviewer_avatar"
                                                value="{{ $review->reviewer_avatar }}" id="avatar">
                                            <button @click.prevent="selectImage()" type="button"
                                                class="btn btn-outline-info btn-block btn-select">
                                                @lang('Change Reviewer Avatar')
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reviewer_name">Reviewer Name</label>
                                            <input type="text" class="form-control" placeholder="John Doe" required
                                                name="reviewer_name" value="{{ $review->reviewer_name }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="created_at">Review Date</label>

                                            <input id="created_at" type="date" class="form-control" required
                                                name="created_at"
                                                value="{{ date('Y-m-d', strtotime($review->created_at)) }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5>Tell us some specific details</h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Title" required name="title"
                                        value="{{ $review->title }}" />
                                </div>

                                <div>
                                    <textarea name="content" class="form-control"
                                        placeholder="Example: The notes in the scent were exactly what I had imagined. It smelled just as spicy as I thought it would, I really love it and gets tons of compliments!">{{ $review->content }}</textarea>
                                </div>

                                <button type="submit" class="mt-4 btn btn-primary btn-xl">
                                    {{ __('Update Review') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
    <script src="{{ asset('assets/js/select2.vue.js') }}"></script>
@endsection

@section('js')
    <script>
        window.app = new Vue({
            el: '#app',
            components: {
                select2: window.select2Vue
            },
            methods: {
                selectImage() {
                    openMediaManager((items) => {
                        document.getElementById('avatar-preview').src = items[0]?.url;
                        document.getElementById('avatar').value = items[0]?.url;
                    }, 'image', @json(__('Select Image')))
                },
            },
        })
    </script>
@endsection
