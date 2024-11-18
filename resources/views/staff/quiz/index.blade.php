@extends('staff.layouts.app')

@section('title', __('Quiz Questions'))

@section('css_libs')
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card" id="app">
                <div class="card-header">
                    <h5 class="mb-0">@lang('New Quiz Item')</h5>
                </div>
                <div class="card-body">
                    <form id="attribute-form" method="post" action="{{ route('staff.quiz-item.store') }}">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="question">@lang('Question')</label>
                            <input class="form-control @error('question') is-invalid @enderror" type="text" id="question"
                                   name="question" value="{{ old('question') }}" required autofocus/>
                            @error('question')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="serial">@lang('Serial')</label>
                            <input class="form-control @error('serial') is-invalid @enderror" id="serial" type="number" step="1" min="1"
                                   name="serial" value="{{ old('serial') }}" required/>
                            @error('serial')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">@lang('Type')</label>
                            <select class="custom-select @error('type') is-invalid @enderror" id="type" name="type" v-model="type" required>
                                <option value="masculine">Masculine</option>
                                <option value="feminine">Feminine</option>
                            </select>
                            @error('type')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="show_if_id">@lang('Show If')</label>
                            <select name="show_if_id" id="show_if_id" class="form-control" v-model="show_if_id">
                                <option value="">@lang('No Restriction')</option>
                                <option v-for="(d, dInd) in show_if_data_calculated" :key="dInd" :value="d.id">@{{ d.question }}</option>
                            </select>
                            @error('show_if_id')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group" v-if="show_if_id">
                            <label for="show_if_option_id">@lang('Show If Option')</label>
                            <select name="show_if_option_id" id="show_if_option_id" class="form-control" v-model="show_if_option_id" required>
                                <option v-for="(op, opInd) in show_if_values" :key="opInd" :value="op.id">@{{ op.title }}</option>
                            </select>
                            @error('show_if_option_id')
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
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mb-0">{{ request()->type??'Feminine' }} Quiz Items</h4>
                    <select id="select-type" class="custom-select w-25">
                        <option value="feminine" {{ request()->type == 'feminine'?'selected':'' }}>Feminine</option>
                        <option value="masculine" {{ request()->type == 'masculine'?'selected':'' }}>Masculine</option>
                    </select>
                </div>
                <div class="card-body bg-light">
                    @include('layouts.notify')
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100"
                                   id="data-table">
                                <thead class="bg-200">
                                <tr>
                                    <th>@lang('Serial')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Question')</th>
                                    <th>@lang('Based On')</th>
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

    <div class="modal fade" id="del-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Quiz Item')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center">
                        @lang('Are you sure to delete this?')
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
            ajax: @json(route('staff.quiz-item.index', ['type' => request()->type??'feminine'])),
            columns: [
                {data: 'serial', name: 'serial'},
                {data: 'type', name: 'type'},
                {data: 'question', name: 'question'},
                {data: 'basedOn', name: 'basedOn', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[0, 'asc']]
        };

        $(document).on('input change', '#select-type', function () {
            window.location.href = '{{ route('staff.quiz-item.index') }}' + '?type=' + $(this).val();
        })

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
            form.find('.text-title h4').text('@lang('Edit Quiz Item')')
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
                    var url = '{{ url('staff/quiz-item') }}/' + data.value;
                    form.attr('action', url);
                } else if (data.name == 'image') {
                    $('#image').val(data.value);
                    $('#image-preview').attr('src', data.value);
                } else if (data.name === 'type') {
                    window.app.type = data.value
                }  else if (data.name === 'show_if_id') {
                    window.app.show_if_id = data.value
                }  else if (data.name === 'show_if_option_id') {
                    window.app.show_if_option_id = data.value
                } else {
                    $('#' + data.name).val(data.value);
                }
            })
        })


        $(document).on('reset', '#attribute-form', function (e) {
            var form = $(this)
            form.find('.text-title h4').text('New Quiz Item')
            form.find('[name="_method"]').val('POST')
            form.find('[type="submit"]').text('Save')
            form.attr('action', '{{ route('staff.quiz-item.store') }}')
        })

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = '{{ url('staff/quiz-item') }}/' + id
            $('#del-modal form').prop('action', url);
            $('#del-modal').modal();
        })

    </script>

    <script>
        window.app = new Vue({
            el: '#app',
            data: {
                show_if_data: @json($show_if),
                show_if_id: @json(old('show_if_id')),
                show_if_option_id: @json(old('show_if_option_id')),
                type: @json(old('type', 'feminine')),
            },
            computed: {
                show_if_values() {
                    let show_if_item = this.show_if_data.filter(quizItem => {
                        return parseInt(quizItem.id) === parseInt(this.show_if_id)
                    })
                    if (!show_if_item.length) return []
                    show_if_item = show_if_item[0]
                    return show_if_item.options;
                },
                show_if_data_calculated() {
                    return this.show_if_data.filter(qi => qi.type === this.type)
                }
            }
        })
    </script>
@endsection
