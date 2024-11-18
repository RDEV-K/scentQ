@extends('staff.layouts.app')

@section('title', __('Quiz Question Options'))

@section('css_libs')
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
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
        <div class="col-md-4">
            <div class="card h-md-100">
                <div class="card-header">
                    <h5 class="mb-0">@lang('New Option')</h5>
                </div>
                <div class="card-body">
                    <form id="attribute-form" method="post" action="{{ route('staff.quiz-item-option.store') }}">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="quiz_item_id" id="quiz_item_id" value="{{ $quizItem->id }}">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="title">@lang('Title')</label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" id="title"
                                   name="title"
                                   value="{{ old('title') }}" required autofocus/>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subtitle">@lang('Subtitle')</label>
                            <input class="form-control @error('subtitle') is-invalid @enderror" type="text"
                                   id="subtitle"
                                   name="subtitle"
                                   value="{{ old('subtitle') }}"/>
                            @error('subtitle')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="desc">@lang('Desc')</label>
                            <textarea class="form-control @error('desc') is-invalid @enderror" id="desc"
                                      name="desc">{{ old('desc') }}</textarea>
                            @error('desc')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="button_text">@lang('Button Text')</label>
                            <input class="form-control @error('button_text') is-invalid @enderror" type="text"
                                   id="button_text"
                                   name="button_text"
                                   value="{{ old('button_text') }}" required/>
                            @error('button_text')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <img src="{{ old('image')??'https://via.placeholder.com/200?text=click+here' }}"
                                 id="image-preview" class="img-thumbnail border-dashed border border-danger"
                                 style="cursor: pointer;">
                            <input type="hidden" name="image" id="image" value="{{ old('image') }}">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary mt-3" type="submit" name="submit">@lang('Save')</button>
                            <button class="btn btn-outline-danger mt-3" type="reset">@lang('Reset')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-md-100">
                <div class="card-header">
                    <h4 class="mb-0">{{ $quizItem->question }} - ({{ $quizItem->type }})</h4>
                </div>
                <div class="card-body pt-2">
                    <div class="card-body bg-light px-0">
                        @include('layouts.notify', ['form' => true])
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100"
                                       id="data-table">
                                    <thead class="bg-200">
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="del-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Option')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center">
                        @lang('Are you sure to delete?')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('Close')
                        </button>
                        <button type="submit" class="btn btn-danger">@lang('Delete')</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
@endsection

@section('js')
    <script>
        window.DatatableOptions = {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: @json(route('staff.quiz-item-option.index', ['quiz_item_id' => $quizItem->id])),
            columns: [
                {data: 'id', name: 'id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        };

        $(document).on('click', '#image-preview', function () {
            openMediaManager((items) => {
                if (!items.length) return;
                const first = items[0]
                $('#image').val(items[0].url)
                $(this).attr('src', items[0].url)
            }, 'image', '@lang('Select Image')')
        })

        $(document).on('click', '.btn-edit', function (e) {
            e.preventDefault()
            var form = $('#attribute-form')
            form.find('.text-title h4').text('@lang('Edit Option')')
            form.find('[name="_method"]').val('PUT')
            form.find('[type="submit"]').text('@lang('Update')')
            var datas = [];
            [].forEach.call(this.attributes, function (attr) {
                if (/^data-/.test(attr.name)) {
                    var camelCaseName = attr.name.substr(5).replace(/-(.)/g, function ($0, $1) {
                        return $1.toUpperCase();
                    });
                    datas.push({
                        name: camelCaseName,
                        value: attr.value
                    });
                }
            });
            datas.forEach(data => {
                if (data.name == 'id') {
                    var url = '{{ url('staff/quiz-item-option') }}/' + data.value;
                    $('#' + data.name).val(data.value);
                    form.attr('action', url);
                } else if (data.name == 'image') {
                    $('#image').val(data.value);
                    $('#image-preview').attr('src', data.value);
                } else {
                    $('#' + data.name).val(data.value);
                    $('#' + data.name).trigger('change')
                }
            })
        })

        $(document).on('reset', '#attribute-form', function (e) {
            var form = $(this)
            form.find('.text-title h4').text('New Option')
            form.find('[name="_method"]').val('POST')
            form.find('[name="id"]').val(null)
            form.find('[type="submit"]').text('Save')
            form.attr('action', '{{ route('staff.quiz-item-option.store') }}')
        })

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = '{{ url('staff/quiz-item-option') }}/' + id
            $('#del-modal form').prop('action', url);
            $('#del-modal').modal();
        })
    </script>
@endsection
