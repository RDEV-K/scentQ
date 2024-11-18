@extends('staff.layouts.app')

@section('title', __('Edit Family'))

@section('css_libs')
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3 p-4" id="app" v-cloak>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Family Details')</h5>
        </div>
        <div class="card-body bg-light p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.family.update', $family->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">@lang('Name')</label>
                            <input
                                id="name"
                                type="text"
                                class="form-control"
                                name="name"
                                value="{{ $family->name }}"
                                required
                                autofocus
                            >
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <textarea class="tinymce form-control border" name="description">
                                {{ $family->description }}
                            </textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <img class="img-thumbnail w-100"
                                    src="{{ $family->image??'https://via.placeholder.com/200' }}"
                                    id="logo-preview"
                            >
                            <input type="hidden" name="image" value="{{ $family->image }}" id="logo-input">
                            <button
                                class="btn btn-outline-info btn-block btn-select" data-input="#logo-input" data-preview="#logo-preview">@lang('Image')
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="scent_type">Type</label>
                            <select class="custom-select" name="type" id="type" v-model="type">
                                <option value="feminine">Feminine</option>
                                <option value="masculine">Masculine</option>
                            </select>
                        </div>
                        <template v-for="(quizItem, quizItemIndex) in quizItemsComputed" :key="quizItemIndex">
                            <div class="card mb-4" v-if="!quizItem.show_if_id || (quizOptions[quizItem.show_if_id] === quizItem.show_if_option_id)">
                                <div class="card-header">
                                    <h5 class="mb-0">@{{ quizItem.question }}</h5>
                                </div>
                                <div class="card-body">
                                    <select class="form-control" :name="'quiz_options[' + quizItem.id + ']'" v-model="quizOptions[quizItem.id]">
                                        <option v-for="(quizItemOption, quizItemOptionIndex) in quizItem.options" :value="quizItemOption.id">@{{ quizItemOption.title }}</option>
                                    </select>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="form-group">
                    <button
                        class="btn btn-primary btn-block btn-lg"
                        type="submit"
                    >
                        @lang('Update Family')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/staff/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
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

            window.app = new Vue({
                el: '#app',
                data: {
                    type: @json($family->type??'feminine'),
                    quizItems: @json($quizItems),
                    quizOptions: @json($quizItemOptionsIds??[]),
                },
                computed: {
                    quizItemsComputed() {
                        return this.quizItems.filter(qi => qi.type === this.type)
                    }
                }
            })
        })(jQuery)
    </script>
@endsection
