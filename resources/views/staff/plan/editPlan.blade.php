@extends('staff.layouts.app')

@section('title', __('Edit Plan'))

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <div class="card mb-3 p-5">
        <div class="card-header">
            <h2 class="mb-0">@lang('Plan Details')</h2>
        </div>
        <div class="card-body" id="ooo" v-cloak>
            @include('layouts.notify')
            <form action="{{ route('staff.plan.update', $plan->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">@lang('Name')</label>
                                    <input id="name" type="text" class="form-control"
                                           name="name" required value="{{ $plan->name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="free_product_id">@lang('Free Product')</label>
                                    <select name="free_product_id" id="free_product_id"
                                            class="form-control selectpicker">
                                        <option value="">@lang('No Product')</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $plan->free_product_id == $product->id?'selected':'' }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mb-3" style="visibility: hidden; width: 100%">@lang('Hidden')</label>
                                    <div class="d-flex">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" id="personal" type="radio" name="type"
                                                   v-model="type" value="personal">
                                            <label class="custom-control-label" for="personal">@lang('Personal')</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-7">
                                            <input class="custom-control-input" id="gift" type="radio" name="type"
                                                   v-model="type" value="gift">
                                            <label class="custom-control-label" for="gift">@lang('Gift')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4" :class="(type == 'personal')?'col-md-4':'col-md-6' ">
                                <div class="form-group">
                                    <label class="control-label">@lang('Price')</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" name="price_par_product"
                                               class="form-control" required v-model="price_par_product"
                                               value="{{ $plan->price_par_product }}"
                                        >
                                        <div class="input-group-append">
                                            <span class="input-group-text">USD</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" v-if="type == 'personal' ">
                                <div class="form-group">
                                    <label class="control-label">@lang('Total')</label>
                                    <div class="input-group">
                                        <input type="number" step="0.001"
                                               class="form-control"
                                               name="total_price"
                                               v-model="total_price">
                                        <div class="input-group-append">
                                            <span class="input-group-text">USD</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div :class="(type == 'personal')?'col-md-4':'col-md-6' ">
                                <div class="form-group">
                                    <label for="product_count">@lang('Product Count')</label>
                                    <input type="number" step="1" min="1" name="product_count"
                                           class="form-control" required v-model="product_count"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="type == 'personal'">
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">@lang('First Discount')</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" min="0" name="first_discount"
                                               value="{{ $plan->first_discount }}"
                                               class="form-control">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">@lang('Stripe Coupon')</label>
                                    <input type="text"
                                           name="stripe_coupon"
                                           class="form-control" value="{{ $plan->stripe_coupon }}">
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="First Time Coupon">@lang('First Time Coupon')</label>
                                    <select name="first_time_coupon_id" id="first_time_coupon_id" class="form-control selectpicker">
                                        <option value="">@lang('No Coupon')</option>
                                        @foreach($coupons as $coupon)
                                            <option
                                                value="{{ $coupon->id }}" {{ $plan->first_time_coupon_id == $coupon->id?'selected':'' }}>{{ $coupon->code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="badge_text">@lang('Badge Text')</label>
                                    <input id="badge_text" type="text" class="form-control"
                                           name="badge_text" value="{{ $plan->badge_text }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="interval_count">@lang('Interval Count')</label>
                                    <div class="input-group">
                                        <input id="interval_count" type="number" min="1" step="1" class="form-control"
                                               name="interval_count" value="{{ $plan->interval_count }}" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Month(s)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label">@lang('Tax')</label>--}}
{{--                                    <div class="input-group">--}}
{{--                                        <input type="number" step="0.1" min="0" name="tax"--}}
{{--                                               value="{{ $plan->tax }}"--}}
{{--                                               class="form-control" required>--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <span class="input-group-text">%</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-3" style="visibility: hidden; width: 100%">@lang('Hidden')</label>
                                    <div class="d-flex">
                                        <div class="custom-control custom-switch d-flex ml-4">
                                            <input class="custom-control-input"
                                                   id="free_shipping"
                                                   type="checkbox"
                                                   name="free_shipping"
                                                   value="1"
                                                {{ $plan->free_shipping == 1?'checked':'' }}
                                            >
                                            <label class="custom-control-label"
                                                   for="free_shipping">@lang('Free Shipping')</label>
                                        </div>
                                        <div class="custom-control custom-switch d-flex ml-6" v-if="type == 'personal' ">
                                            <input class="custom-control-input"
                                                   id="is_default"
                                                   type="checkbox"
                                                   name="is_default"
                                                   value="1"
                                                {{ $plan->is_default == 1?'checked':'' }}
                                            >
                                            <label class="custom-control-label"
                                                   for="is_default">@lang('Default')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="gift" v-if="type == 'gift' ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gift_month_count">@lang('Gift Month Count')</label>
                                        <input type="number" step="01" min="1" name="gift_month_count"
                                               value="{{ $plan->gift_month_count }}"
                                               class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gift_total">@lang('Gift Total')</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" min="0.00" name="gift_total"
                                                   value="{{ $plan->gift_total }}"
                                                   class="form-control" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gift_save">@lang('Gift Save')</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" min="0.00" name="gift_save"
                                                   value="{{ $plan->gift_save }}"
                                                   class="form-control" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gift_personal_receive">@lang('Gift Personal Receive')</label>
                                        <input type="number" step="01" min="1" name="gift_personal_receive"
                                               value="{{ $plan->gift_personal_receive }}"
                                               class="form-control" required>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-6" v-for="(feature, ind) in features" :key="ind">
                                    <div class="form-group">
                                        <label :for="'feature-' + ind">@lang("Feature") @{{ ind+1 }}
                                            <button class="btn btn-sm btn-warning" type="button"
                                                    @click.prevent="removeFeature(ind)"><i class="fas fa-trash"></i>
                                            </button>
                                        </label>
                                        <input class="form-control" :id="'feature-' + ind" name="features[]"
                                               v-model="features[ind]">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="visibility: hidden">@lang('Gift Personal Receive')</label>
                                        <button class="btn btn-block btn-primary" type="button"
                                                @click.prevent="addFeature">@lang("Add New Feature")</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="form-group text-right">
                                    <button class="btn btn-primary btn-lg" type="submit">@lang('Update Plan')</button>
                                </div>
                            </div>
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
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
@endsection

@section('js')
    <script>
        window.vueApp = new Vue({
            el: '#ooo',
            data: {
                type: @json($plan->type??'personal'),
                product_count: @json( $plan->product_count ??1),
                price_par_product: @json($plan->price_par_product ??1),
                total_price: @json($plan->total_price),
                features: @json($plan->features ??[])
            },
            beforeMount() {
                if (!this.total_price) {
                    this.total_price = parseInt(this.product_count) * parseFloat(this.price_par_product)
                }
            },
            methods: {
                calculateTotal() {
                    this.total_price = parseInt(this.product_count) * parseFloat(this.price_par_product)
                },
                addFeature() {
                    this.features.push(null)
                },
                removeFeature(ind) {
                    this.features.splice(ind, 1)
                }
            },
            watch: {
                product_count(newVal, oldVal) {
                    this.total_price = parseInt(newVal) * parseFloat(this.price_par_product)
                },
                price_par_product(newVal, oldVal) {
                    this.total_price = parseInt(this.product_count) * parseFloat(newVal)
                },
            }
        });
    </script>
@endsection
