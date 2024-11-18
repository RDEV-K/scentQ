@extends('staff.layouts.app')

@section('title', __('Webhhok Management'))

@section('content')
    <div class="card mb-3">
        <div class="card-body bg-light px-0">
            @include('layouts.notify')
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead class="bg-200">
                            <tr>
                                <th>#</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Transaction Available')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $call)
                                <tr>
                                    <td>
                                        {{ $call->payload['id'] }}
                                    </td>
                                    <td>
                                        @php
                                            $status = $call->payload['pending_webhooks'] == 2 ? 'delivered' : 'pending';
                                            $class = $status == 'pending' ? 'info' : 'success';
                                        @endphp
                                        <span class="text-capitalize badge badge-{{ $class }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $call->payment ? 'Yes' : 'No' }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            {{-- @if ($status == 'pending') --}}
                                            <form action="{{ route('staff.webhook.update', $call->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-info btn-delete btn-sm ml-1">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                            </form>
                                            {{-- @endif --}}
                                            <button class="btn btn-danger btn-delete btn-sm ml-1">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        No Data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

@section('js_libs')
@endsection
