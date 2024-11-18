@extends('staff.layouts.app')

@section('title', __('All Testimonials'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row row-cols-1 row-cols-md-2 justify-content-between">
                            <div class="col-12 col-md-6">
                                <h3 class="card-title" style="line-height: 36px;">
                                    @lang('All Testimonial')
                                </h3>
                            </div>
                            <div class="col-12 col-md-6 text-md-right">
                                <a href="{{ route('staff.testimonial.create') }}" class="mb-1 mb-md-0 btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    <span class="ml-1">
                                        @lang('Add New Testimonial')
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover text-nowrap table-bordered table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th width="1%"></th>
                                    <th class="text-left">{{ __('Embed Code') }}</th>
                                    <th width="10%">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @forelse ($testimonials as $testimonial)
                                    <tr data-id="{{ $testimonial->id }}">
                                        <td>
                                            <div class="handle btn mt-0 text-left cursor-move" style="cursor: move">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="black" class=""
                                                    height="24" viewBox="0 -960 960 960" width="24">
                                                    <path
                                                        d="M360-160q-33 0-56.5-23.5T280-240q0-33 23.5-56.5T360-320q33 0 56.5 23.5T440-240q0 33-23.5 56.5T360-160Zm240 0q-33 0-56.5-23.5T520-240q0-33 23.5-56.5T600-320q33 0 56.5 23.5T680-240q0 33-23.5 56.5T600-160ZM360-400q-33 0-56.5-23.5T280-480q0-33 23.5-56.5T360-560q33 0 56.5 23.5T440-480q0 33-23.5 56.5T360-400Zm240 0q-33 0-56.5-23.5T520-480q0-33 23.5-56.5T600-560q33 0 56.5 23.5T680-480q0 33-23.5 56.5T600-400ZM360-640q-33 0-56.5-23.5T280-720q0-33 23.5-56.5T360-800q33 0 56.5 23.5T440-720q0 33-23.5 56.5T360-640Zm240 0q-33 0-56.5-23.5T520-720q0-33 23.5-56.5T600-800q33 0 56.5 23.5T680-720q0 33-23.5 56.5T600-640Z" />
                                                </svg>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <a href="{{ $testimonial->video_url }}" target="__blank">
                                                {{ Str::limit($testimonial->video_url, 20, '...') }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('staff.testimonial.edit', $testimonial->id) }}"
                                                    class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('staff.testimonial.destroy', $testimonial->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure')" type="submit"
                                                        class="btn btn-sm btn-danger mr-2"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No data!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#sortable").sortable({
                items: 'tr',
                cursor: 'move',
                opacity: 0.4,
                scroll: false,
                dropOnEmpty: false,
                update: function() {
                    sendTaskOrderToServer('#sortable tr');
                },
                classes: {
                    "ui-sortable": "highlight"
                },
            });
            $("#sortable").disableSelection();

            function sendTaskOrderToServer(selector) {
                var order = [];
                $(selector).each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('staff.testimonial.sorting') }}",
                    data: {
                        order: order,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.success(response.message, 'Success');
                    }
                });
            }
        });
    </script>
@endsection
