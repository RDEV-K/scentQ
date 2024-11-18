@extends('staff.layouts.app')

@section('title', __('Settings'))

@section('content')
    <div class="card mb-3 p-4" id="app" v-cloak>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Settings')</h5>
        </div>
        <div class="card-body bg-light p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.settings') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="case_subscription_price">Case Subscription Price (Required Change Into Stripe,
                                change can make this feature crush)</label>
                            <input id="case_subscription_price" type="number" min="1" step="0.001"
                                class="form-control bg-danger" name="metas[case_subscription_price]"
                                value="" required>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="case_subscription_stripe_price">
                                Case Subscription Stripe Product ID (Required Change
                                Into Stripe, change can make this feature crush)
                            </label>
                            <input id="cashier_stripe_fragrance_subscription" type="text" class="form-control bg-danger"
                                   name="cashier_stripe_fragrance_subscription"
                                   value="{{ $cashier_stripe_fragrance_subscription }}"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="azn_rate">
                                1 USD to AZN (Azerbaijani Manat) price
                            </label>
                            <input id="azn_rate" type="number" step="any" class="mt-3 form-control bg-danger"
                                   name="azn_rate" value="{{ $settings?->azn_rate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sar_rate">
                                1 USD to SAR (Saudi Riyal) price
                            </label>
                            <input id="sar_rate" type="number" step="any" class="form-control bg-danger"
                                   name="sar_rate" value="{{ $settings?->sar_rate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kwd_rate">
                                1 USD to KWD (Kuwaiti Dinar) price
                            </label>
                            <input id="kwd_rate" type="number" step="any" class="form-control bg-danger"
                                   name="kwd_rate" value="{{ $settings?->kwd_rate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aed_rate">
                                1 USD to AED (United Arab Emirates Dirham) price
                            </label>
                            <input id="aed_rate" type="number" step="any" class="form-control bg-danger"
                                   name="aed_rate" value="{{ $settings?->aed_rate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bhd_rate">
                                1 USD to BHD (Bahraini Dinar) price
                            </label>
                            <input id="bhd_rate" type="number" step="any" class="form-control bg-danger"
                                   name="bhd_rate" value="{{ $settings?->bhd_rate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="qar_rate">
                                1 USD to QAR (Qatari Riyal) price
                            </label>
                            <input id="qar_rate" type="number" step="any" class="form-control bg-danger"
                                   name="qar_rate" value="{{ $settings?->qar_rate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pound_rate">
                                1 USD to POUND (UK) price
                            </label>
                            <input id="pound_rate" type="number" step="any" class="form-control bg-danger"
                                   name="pound_rate" value="{{ $settings?->pound_rate }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block btn-lg" type="submit"
                            onclick="return confirm('Are you sure?')">
                        @lang('Update')
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3 p-4" id="app" v-cloak>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">@lang('Social Links')</h5>
                </div>
                <div class="card-body p-0 col-md-12 table-responsive">
                    <table class="table w-100 table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Url</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($social_links as $link)
                            <tr style="width: 23px">
                                <th>
                                    {{ $link->name }}
                                </th>
                                <td>
                                    {{ $link->link }}
                                </td>
                                <td>
                                    <img width="40" class="filterit" height="40" src="{{ $link->icon_url }}" alt="">
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('staff.social-link.edit', $link->id) }}"
                                           class="btn btn-warning btn-edit btn-sm ml-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('staff.social-link.destroy', $link->id) }}"
                                              method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" onclick="return confirm('Are you sure ?')"
                                                    class="btn btn-danger btn-delete btn-sm ml-1">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="4" style="text-align: center">
                                    {{ __('No Link Found!') }}
                                </th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card px-4" id="app" v-cloak>
                <div class="card-header">
                    <h5 class="mb-0">@lang('Add New Link')</h5>
                </div>
                <div class="card-body p-0">
                    @if (isset($social_link))
                        <form action="{{ route('staff.social-link.update', $social_link->id) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group pt-0">
                                <label for="name">
                                    @lang('Name')
                                </label>
                                <input id="name" value="{{ $social_link->name }}" type="text" class="form-control"
                                       name="name" placeholder="Name" required autofocus>
                            </div>
                            <div class="form-group pt-0">
                                <label for="url">
                                    @lang('Url')
                                </label>
                                <input id="url" value="{{ $social_link->link }}" type="url" class="form-control"
                                       name="url" placeholder="Url">
                            </div>
                            <div class="form-group pt-0">
                                <label for="icon">@lang('Icon')</label>
                                <input id="icon" type="file" class="" name="icon">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">
                                    @lang('Update')
                                </button>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('staff.social-link.store') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input id="name" type="text" placeholder="Name" class="form-control"
                                       name="name" value="">
                            </div>
                            <div class="form-group">
                                <label for="url">@lang('Url')</label>
                                <input id="url" type="url" placeholder="Url" class="form-control"
                                       name="url" value="">
                            </div>
                            <div class="form-group">
                                <label for="icon">@lang('Icon')</label>
                                <input id="icon" type="file" class="" name="icon" value="">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">
                                    @lang('Add')
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section('css')
    <style>
        .filterit {
            filter: invert(88%) sepia(21%) saturate(935%) hue-rotate(123deg) brightness(85%) contrast(97%);
        }
    </style>
@endsection
