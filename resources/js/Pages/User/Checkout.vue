<template>
    <section class="profile profile-content">
        <div class="container">
            <form class="row tw-justify-center" @submit.prevent="submitForm">
                <div class="col-md-7 col-lg-6 ms-lg-5">
                    <div class="billing-box checkout-credit-card-box">
                        <h3 class="!tw-mt-0">{{__('Shipment Details')}}</h3>
                        <template v-for="(shipping, index) in shipping_addresses" :key="index">
                            <div class="md:tw-flex tw-justify-between tw-items-center !tw-bg-secondary tw-shadow-sm tw-p-6 tw-rounded-md tw-mb-2 border-1 border-black tw-cursor-pointer"
                                :class="addressSelected == shipping?.id ? ' tw-border-2 tw-border-black' : ''"
                                @click.self="selectAddress(shipping)">
                                <div @click="selectAddress(shipping)">
                                    <div class="tw-font-bold tw-text-lg">
                                        {{ shipping?.name }}
                                    </div>
                                    <div class="tw-text-sm">
                                        {{ shipping?.line1 }}{{ shipping?.line1 ? "," : "" }}
                                        {{ shipping?.line2 }}{{ shipping?.line2 ? "," : "" }}
                                        {{ shipping?.city }}{{ shipping?.city ? "," : "" }}
                                        {{ shipping?.state }}{{ shipping?.state ? "," : "" }}
                                        {{ shipping?.postal_code }}{{ shipping?.postal_code ? "," : "" }}
                                        {{ shipping?.country }}
                                    </div>
                                </div>
                                <div class="tw-flex tw-items-center tw-gap-2">
                                    <div @click="edit(shipping)" class="tw-cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="tw-w-7 tw-h-7">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-if="shipping_addresses.length != 0">
                            <div @click="addNew()"
                                class="tw-mt-2 md:tw-flex tw-justify-between tw-items-center !tw-bg-secondary tw-shadow-sm tw-p-6 tw-rounded-md tw-cursor-pointer border">
                                <div class="tw-flex tw-items-center">
                                    <div class="tw-mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </div>
                                    <div>
                                        {{__('Add a new shipping address')}}
                                    </div>
                                </div>
                            </div>
                            <br>
                        </template>
                        <div>
                            <template v-if="addNewAddress">
                                <div class="form-group select2-box">
                                    <label>{{ __("Country") }}</label>
                                    <v-select v-model="form.country" :reduce="(option) => option.id"
                                        placeholder="Select Country" :options="countriesAsSelect2" />
                                    <div class="invalid-feedback" v-if="errors.country">
                                        {{ errors.country }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Name" :class="{
                                                    'is-invalid': errors.name,
                                                }" v-model="form.name" id="name" />
                                            <label for="name" class="form-label">{{
                                                __("Full Name")
                                                }}</label>
                                            <div class="invalid-feedback" v-if="errors.name">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="email"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Email Address" :class="{
                                                    'is-invalid': errors.email,
                                                }" v-model="form.email" id="email" />
                                            <label for="email" class="form-label">{{
                                                __('Email Address')
                                                }}</label>
                                            <div class="invalid-feedback" v-if="errors.email">
                                                {{ errors.email }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Street address" id="line1" v-model="form.line1" :class="{
                                                    'is-invalid': errors.line1,
                                                }" />
                                            <div class="invalid-feedback" v-if="errors.line1">
                                                {{ errors.line1 }}
                                            </div>
                                            <label for="line1" class="form-label">{{
                                                __("Street Address")
                                                }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="apt"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Apt (opt)" id="line2" v-model="form.line2" :class="{
                                                    'is-invalid': errors.line2,
                                                }" />
                                            <div class="invalid-feedback" v-if="errors.line2">
                                                {{ errors.line2 }}
                                            </div>
                                            <label for="line2" class="form-label">{{
                                                __("Apt (Opt)")
                                                }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group select2-box select2-small-box" v-if="statesAsSelect2.length">
                                    <label>{{ __("State/Province/Region") }}</label>
                                    <v-select v-model="form.state" :reduce="(option) => option.id"
                                        placeholder="Select State" :options="statesAsSelect2" />
                                    <div class="invalid-feedback" v-if="errors.country">
                                        {{ errors.country }}
                                    </div>
                                </div>
                                <div class="form-group form-floating" v-else>
                                    <input type="text" name="city"
                                        class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                        placeholder="state" id="state" v-model="form.state"
                                        :class="{ 'is-invalid': errors.state }" />
                                    <div class="invalid-feedback" v-if="errors.state">
                                        {{ errors.state }}
                                    </div>
                                    <label for="state" class="form-label">
                                        {{ __("State/Province/Region") }}
                                    </label>
                                </div>
                                <div class="form-group form-floating">
                                    <input type="text" name="city"
                                        class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                        placeholder="city" id="city" v-model="form.city"
                                        :class="{ 'is-invalid': errors.city }" />
                                    <div class="invalid-feedback" v-if="errors.city">
                                        {{ errors.city }}
                                    </div>
                                    <label for="city" class="form-label">City</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="post code" id="postal_code" v-model="form.postal_code"
                                                :class="{'is-invalid': errors.postal_code}" />
                                            <div class="invalid-feedback" v-if="errors.postal_code">
                                                {{ errors.postal_code }}
                                            </div>
                                            <label for="postal_code" class="form-label">{{ __("Postal Code") }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="phone" @input="(e) => { onKeydown(e.target, 15) }"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="phone" id="phone" v-model="form.phone" :class="{
                                                    'is-invalid': errors.phone,
                                                }" />
                                            <div class="invalid-feedback" v-if="errors.phone">
                                                {{ errors.phone }}
                                            </div>
                                            <label for="phone" class="form-label">
                                                {{ __("Phone Number") }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- <h6>Select Payment Method</h6>
                                <div class="mb-3 row g-3 justify-content-between align-items-center">
                                    <div class="col-md-6 cursor-pointer" v-for="(gateway, gatewayIndex) in gateways" :key="gatewayIndex">
                                        <label :for="'gateway_id-' + gateway.id" class="d-flex align-items-center p-3 border" :class="{'border-danger': gateway.id == form.gateway_id}">
                                            <img :src="gateway.image" style="height: 100px;margin-left: 20px;" :alt="gateway.name">
                                            <span>{{ gateway.name }}</span>
                                        </label>
                                        <input class="d-none" type="radio" :id="'gateway_id-' + gateway.id" name="gateway_id" :value="gateway.id" v-model="form.gateway_id">
                                    </div>
                                </div> -->
                            </template>
                            <div class="tw-block md:tw-hidden col-md-5 col-xl-4 md:!tw-mt-[69px]">
                                <div class="checkout-info">
                                    <div class="queue-list !tw-bg-secondary tw-p-3 tw-rounded">
                                        <template v-if="user.cart.subscribe_items > 0">
                                            <div>
                                                <p class="mb-2 what-u-r-getting-p">
                                                    {{__('You are getting...')}}
                                                </p>
                                                <p class="mb-4 d-flex" style="font-size:14px;line-height: 1.5;">
                                                    {{__('A month-to-month subscription to ScentQ. Billed monthly, renews automatically, and ships from our warehouse mid-month.')}}
                                                    <span
                                                        style="    padding-top: 27px; font-weight: 600; font-size: 18px;">
                                                        {{ currencyConvert(footerData?.plan?.total_price) }}
                                                    </span>
                                                </p>
                                                <p class="what-u-r-getting-p mb-2" style="text-transform:uppercase;">
                                                    {{ arrivesInMonth() }} {{ __('Order') }}
                                                </p>
                                            </div>
                                            <div class=" checkout-meta-data cart_item">
                                                <div v-for="(cartItem, cartItemIndex) in user.cart.items"
                                                    :key="cartItemIndex" style="border:none;position: relative;">
                                                    <template
                                                        v-if="user.cart.subscribe_items > 0 && cartItem.purchase_option_type == 'subscription'">
                                                        <div class="d-flex justify-content-left align-items-left">
                                                            <div class="d-flex justify-content-left align-items-left">
                                                                <img :src="cartItem?.product?.image?.url"
                                                                    class="img-fluid" :alt="cartItem.product.title"
                                                                    style="width: 62px; height: 62px; object-fit: contain;" />
                                                            </div>
                                                            <div>
                                                                <h6 style="font-weight: normal;font-size: 1rem;font-family: 'TT Norms Pro', sans-serif;"
                                                                    class="w-100 text-uppercase !text-black">
                                                                    <span class="notranslate">{{ cartItem.product.title }}</span>
                                                                    <span v-if="cartItem.attrs"
                                                                        v-html="attrStr(cartItem.attrs)"></span>
                                                                </h6>
                                                                <p class="notranslate !tw-text-[#4D4D4D]">
                                                                    {{ cartItem.product.brand.name }}
                                                                </p>
                                                                <p style="font-size: 13px;line-height: 1.5;"
                                                                    v-if="cartItem.product.sub_type">
                                                                    {{ cartItem.product.sub_type.name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>


                                        <!-- One time  -->
                                        <div v-for="(cartItem, cartItemIndex) in user.cart.items" :key="cartItemIndex"
                                            :class="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time' ? 'checkout-meta-data align-items-center cart_item d-flex' : ''"
                                            style="margin-bottom: 0.5rem; border:none;position: relative;">
                                            <div
                                                v-if="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time'">
                                                <p class="mb-2 what-u-r-getting-p">
                                                    {{__('ONE-TIME PURCHASE')}}
                                                </p>
                                            </div>
                                            <template
                                                v-if="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time'">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="tw-flex tw-gap-3 tw-justify-center tw-items-center">
                                                        <div
                                                            class="tw-inline-flex tw-justify-center tw-items-center tw-w-16 tw-h-16 tw-max-w-[64px] tw-max-h-[64px]">
                                                            <img class="tw-w-full tw-h-full tw-object-contain"
                                                                :src="cartItem?.product?.image?.url"
                                                                :alt="cartItem.product.title" />
                                                        </div>
                                                        <div>
                                                            <h6 class="tw-text-lg tw-font-bold tw-mb-2 tw-text-black">
                                                                <span class="notranslate">{{ cartItem.product.title }}</span>
                                                                <span v-if="cartItem.attrs"
                                                                    v-html="attrStr(cartItem.attrs)"></span>
                                                            </h6>
                                                            <p
                                                                class="notranslate tw-text-base tw-font-normal tw-mb-0 tw-text-black">
                                                                {{ cartItem.product.brand.name }}
                                                            </p>
                                                            <p style="font-size: 13px;line-height: 1.5;"
                                                                v-if="cartItem.product.sub_type">
                                                                {{ cartItem.product.sub_type.name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <!-- one time end  -->
                                    </div>
                                    <div class="checkout-meta-data">
                                        <h6>
                                            {{ __('Total') }}
                                            <span class="simple-price text-uppercase tw-font-bold">{{
                                                currencyConvert(user?.cart?.net_total) }}</span>
                                        </h6>
                                    </div>

                                    <div class="checkout-meta-data"
                                        v-if="sub_discount == 1 && checkSubscriptionInCart() == 1 && $page?.props?.config?.app?.subscribe_discount_status"
                                        style="position: relative;">
                                        <h6 style="margin-bottom: 6px;margin-top: -9px;">
                                            {{ __('Subscription discount') }}
                                            <small
                                                style="width: 100%;float: left;margin-top: -9px;font-size: 13px;color: #565656;">Offer
                                                applied to the first month only</small>
                                            <span class="simple-price text-uppercase"
                                                style="position: absolute;right: 0px;margin-top: 6px;">
                                                - {{ numberFormat($page?.props?.config?.app?.subscribe_discount_amount,
                                                0) }}%
                                            </span>
                                        </h6>
                                    </div>

                                    <template v-if="checkSubscriptionInCart() == 1 && checkOneTimeInCart() == 1">
                                        <div class="checkout-meta-data">
                                            <h6>
                                                {{ __('Subscription shipping') }}
                                                <span class="simple-price" style="text-transform: none;">Always
                                                    Free</span>
                                            </h6>
                                        </div>
                                        <div class="checkout-meta-data">
                                            <h6>
                                                {{ __('Ecommerce shipping') }}
                                                <span v-if="user?.cart?.shipping?.exact"
                                                    class="simple-price text-uppercase">{{
                                                    currencyConvert(user?.cart?.shipping?.exact?.charge) }}</span>
                                                <span v-else class="simple-price text-uppercase">{{
                                                    currencyConvert(config.misc.default_shipping) }}</span>
                                            </h6>
                                        </div>
                                    </template>

                                    <template v-if="checkSubscriptionInCart() == 1 && checkOneTimeInCart() == 0">
                                        <div class="checkout-meta-data">
                                            <h6>
                                                {{ __('Shipping') }}
                                                <span class="simple-price" style="text-transform: none;">Free</span>
                                            </h6>
                                        </div>
                                    </template>

                                    <template v-if="checkSubscriptionInCart() == 0 && checkOneTimeInCart() == 1">
                                        <div class="checkout-meta-data">
                                            <h6>
                                                {{ __('Shipping') }}
                                                <span v-if="user?.cart?.shipping?.exact"
                                                    class="simple-price text-uppercase">{{
                                                    currencyConvert(user?.cart?.shipping?.exact?.charge) }}</span>
                                                <span v-else class="simple-price text-uppercase">
                                                    <template v-if="config.misc.default_shipping > 0">
                                                        {{ currencyConvert(config.misc.default_shipping)
                                                        }}
                                                    </template>
                                                    <template v-else>
                                                        {{ __('Free') }}
                                                    </template>
                                                </span>
                                            </h6>
                                        </div>
                                    </template>

                                    <div class="checkout-meta-data"
                                        v-if="user?.cart?.policy_discount && user?.cart?.policy_discount > 0">
                                        <h6>
                                            {{ __('Special Discount') }}
                                            <span class="simple-price text-uppercase">
                                                - {{ currencyConvert(user?.cart?.policy_discount) }}
                                            </span>
                                        </h6>
                                    </div>
                                    <div class="checkout-meta-data d-flex align-items-center"
                                        v-if="user?.cart?.coupon_code">
                                        <div>
                                            <h6>
                                                {{
                                                __("Coupon Discount")
                                                }}<span class="discount-price ms-3">{{
                                                    currencyConvert(user?.cart?.discount)
                                                    }}</span>
                                            </h6>
                                            <p>{{ __("Coupon Code: %s", user?.cart?.coupon_code) }}</p>
                                        </div>
                                        <span @click.prevent="removeCoupon" class="cursor-pointer ms-auto remove-queue">
                                            <img src="../../../images/svg/Ico_Cancel.svg" />
                                        </span>
                                    </div>
                                    <div class="checkout-meta-data">
                                        <h6>
                                            {{ __('Net Total') }}
                                            <span class="simple-price text-uppercase tw-font-bold">{{
                                                currencyConvert(total)
                                                }}</span>
                                        </h6>
                                    </div>
                                    <template v-if="!user?.cart?.coupon_code">
                                        <span class="checkout-meta-anchor cursor-pointer"
                                            @click.prevent="couponToggle = !couponToggle">{{ __("Have a coupon code?") }}</span>
                                        <div class="form-group mt-2 coupon-form" v-if="couponToggle">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                    :class="{ 'is-invalid': errors.code }" placeholder="Coupon Code"
                                                    v-model="couponForm.code" />
                                                <button class="btn btn-sm btn-black" @click.prevent="addCoupon"
                                                    :disabled="couponForm.processing">
                                                    <svg v-if="couponForm.processing" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 256 256">
                                                        <path
                                                            d="M230,128a102,102,0,0,1-204,0c0-40.18,23.35-76.86,59.5-93.45a6,6,0,0,1,5,10.9C58.61,60.09,38,92.49,38,128a90,90,0,0,0,180,0c0-35.51-20.61-67.91-52.5-82.55a6,6,0,0,1,5-10.9C206.65,51.14,230,87.82,230,128Z">
                                                        </path>
                                                    </svg>
                                                    <small v-else>{{ __("Apply") }}</small>
                                                </button>
                                            </div>
                                            <div class="text-danger" v-if="errors.code">
                                                {{ errors.code }}
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="checkout-info mt-3 !tw-bg-white tw-hidden md:tw-block">
                                    <div class="d-flex">
                                        <div class="bottom-checkout-box-img">
                                            <img src="../../../images/svg/Setup_Queue.svg" alt="QUEUE" />
                                        </div>
                                        <div class="bottom-checkout-box-content !tw-text-white">
                                            <h6>{{__('Guaranteed Safe Checkout')}}</h6>
                                            <p class="!tw-text-xs md:!tw-text-base">All data is encrypted. Your card number is never stored on {{
                                                config.app.name }}
                                                servers.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div :style="{ display: form.gateway_id == 1 ? 'block' : 'none' }">
                                    <!-- Credit Card Details -->
                                    <h3 class="!tw-text-base tw-text-center md:tw-text-xl">{{ __("Enter Your Credit Card Details") }}</h3>
                                    <div class="d-flex align-items-start">
                                        <img src="../../../images/svg/Ico_Lock.svg" alt="lock" class="text-img me-2" />
                                        <p class="!tw-text-xs md:!tw-text-base tw-text-center">
                                            {{ __("All data is encrypted. Your card number is never stored on %s servers.", config.app.name) }}
                                        </p>
                                    </div>
                                    <div class="alert alert-danger" v-if="cardInfo.activeError">
                                        {{ cardInfo.errorText }}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group stripe-input">
                                                <span id="card-number"
                                                    class="!tw-h-[3rem] form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"></span>
                                                <label class="form-label visually-hidden">
                                                    {{ __("Card Number") }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group stripe-input">
                                                <span id="card-exp"
                                                    class="!tw-h-[3rem] form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"></span>
                                                <label class="form-label visually-hidden">
                                                    {{ __("Card Exp") }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group stripe-input">
                                                <span id="card-cvc"
                                                    class="!tw-h-[3rem] form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"></span>
                                                <label class="form-label visually-hidden">
                                                    {{ __("Card CVC") }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-floating">
                                                <input type="text" name="full_name"
                                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                    placeholder="Card Holder" id="card_name"
                                                    v-model="cardInfo.ccName" />
                                                <label for="card_name" class="form-label">
                                                    {{ __("Card Holder Name") }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group !tw-w-full tw-flex tw-justify-center tw-items-center">
                                            <button v-if="form.processing || cardInfo.processing" type="button"
                                                class="!tw-w-full !tw-flex !tw-justify-center !tw-py-3 !tw-items-center btn btn-black btn-lg texts-center text-uppercase"
                                                disabled>
                                                <svg class="tw-animate-spin " xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" fill="currentColor" viewBox="0 0 256 256">
                                                    <path
                                                        d="M230,128a102,102,0,0,1-204,0c0-40.18,23.35-76.86,59.5-93.45a6,6,0,0,1,5,10.9C58.61,60.09,38,92.49,38,128a90,90,0,0,0,180,0c0-35.51-20.61-67.91-52.5-82.55a6,6,0,0,1,5-10.9C206.65,51.14,230,87.82,230,128Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button v-else type="submit"
                                                class="!tw-w-full btn btn-black btn-lg !tw-py-3 text-center text-uppercase !tw-px-20">
                                                {{ __("Pay :total", {total: currencyConvert(total)}) }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Credit Card Details -->
                        </div>
                    </div>
                </div>
                <div class="tw-hidden md:tw-block col-md-5 col-xl-4 md:!tw-mt-[69px]">
                    <div class="checkout-info">
                        <div class="queue-list !tw-bg-secondary tw-p-3 tw-rounded">
                            <template v-if="user.cart.subscribe_items > 0">
                                <div>
                                    <p class="mb-2 what-u-r-getting-p">
                                        {{__('You are getting...')}}
                                    </p>
                                    <p class="mb-4 d-flex" style="font-size:14px;line-height: 1.5;">
                                        {{__('A month-to-month subscription to ScentQ. Billed monthly, renews automatically, and ships from our warehouse mid-month.')}}
                                        <span style="    padding-top: 27px; font-weight: 600; font-size: 18px;">
                                            {{ currencyConvert(footerData?.plan?.total_price) }}
                                        </span>
                                    </p>
                                    <p class="what-u-r-getting-p mb-2" style="text-transform:uppercase;">
                                        {{ arrivesInMonth() }} {{ __('Order') }}
                                    </p>
                                </div>
                                <div class=" checkout-meta-data cart_item">
                                    <div v-for="(cartItem, cartItemIndex) in user.cart.items" :key="cartItemIndex"
                                        style="border:none;position: relative;">
                                        <template
                                            v-if="user.cart.subscribe_items > 0 && cartItem.purchase_option_type == 'subscription'">
                                            <div class="d-flex justify-content-left align-items-left">
                                                <div class="d-flex justify-content-left align-items-left">
                                                    <img :src="cartItem?.product?.image?.url" class="img-fluid"
                                                        :alt="cartItem.product.title"
                                                        style="width: 62px; height: 62px; object-fit: contain;" />
                                                </div>
                                                <div>
                                                    <h6 style="font-weight: normal;font-size: 1rem;font-family: 'TT Norms Pro', sans-serif;"
                                                        class="w-100 text-uppercase !text-black">
                                                        <span class="notranslate">{{ cartItem.product.title }}</span>
                                                        <span v-if="cartItem.attrs"
                                                            v-html="attrStr(cartItem.attrs)"></span>
                                                    </h6>
                                                    <p class="notranslate !tw-text-[#4D4D4D]">
                                                        {{ cartItem.product.brand.name }}
                                                    </p>
                                                    <p style="font-size: 13px;line-height: 1.5;"
                                                        v-if="cartItem.product.sub_type">
                                                        {{ cartItem.product.sub_type.name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>


                            <!-- One time  -->
                            <div v-for="(cartItem, cartItemIndex) in user.cart.items" :key="cartItemIndex"
                                :class="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time' ? 'checkout-meta-data align-items-center cart_item d-flex' : ''"
                                style="margin-bottom: 0.5rem; border:none;position: relative;">
                                <div
                                    v-if="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time'">
                                    <p class="mb-2 what-u-r-getting-p">
                                        {{__('ONE-TIME PURCHASE')}}
                                    </p>
                                </div>
                                <template
                                    v-if="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time'">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="tw-flex tw-gap-3 tw-justify-center tw-items-center">
                                            <div
                                                class="tw-inline-flex tw-justify-center tw-items-center tw-w-16 tw-h-16 tw-max-w-[64px] tw-max-h-[64px]">
                                                <img class="tw-w-full tw-h-full tw-object-contain"
                                                    :src="cartItem?.product?.image?.url"
                                                    :alt="cartItem.product.title" />
                                            </div>
                                            <div>
                                                <h6 class="tw-text-lg tw-font-bold tw-mb-2 tw-text-black">
                                                    <span class="notranslate">{{ cartItem.product.title }}</span>
                                                    <span v-if="cartItem.attrs" v-html="attrStr(cartItem.attrs)"></span>
                                                </h6>
                                                <p class="notranslate tw-text-base tw-font-normal tw-mb-0 tw-text-black">
                                                    {{ cartItem.product.brand.name }}
                                                </p>
                                                <p style="font-size: 13px;line-height: 1.5;"
                                                    v-if="cartItem.product.sub_type">
                                                    {{ cartItem.product.sub_type.name }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <!-- one time end  -->
                        </div>
                        <div class="checkout-meta-data">
                            <h6>
                                {{ __('Total') }}
                                <span class="simple-price text-uppercase tw-font-bold">{{
                                    currencyConvert(user?.cart?.net_total) }}</span>
                            </h6>
                        </div>

                        <div class="checkout-meta-data" v-if="sub_discount == 1 && checkSubscriptionInCart() == 1"
                            style="position: relative;">
                            <h6 style="margin-bottom: 6px;margin-top: -9px;">
                                {{ __('Subscription discount') }}
                                <small
                                    style="width: 100%;float: left;margin-top: -9px;font-size: 13px;color: #565656;">Offer
                                    applied to the first month only</small>
                                <span class="simple-price text-uppercase"
                                    style="position: absolute;right: 0px;margin-top: 6px;">
                                    - {{ currencyConvert(numberFormat($page?.props?.config?.app?.subscribe_discount_amount, 0)) }}
                                </span>
                            </h6>
                        </div>

                        <template v-if="checkSubscriptionInCart() == 1 && checkOneTimeInCart() == 1">
                            <div class="checkout-meta-data">
                                <h6>
                                    {{ __('Subscription shipping') }}
                                    <span class="simple-price" style="text-transform: none;">Always Free</span>
                                </h6>
                            </div>
                            <div class="checkout-meta-data">
                                <h6>
                                    {{ __('Ecommerce shipping') }}
                                    <span v-if="user?.cart?.shipping?.exact" class="simple-price text-uppercase">{{
                                        currencyConvert(user?.cart?.shipping?.exact?.charge) }}</span>
                                    <span v-else class="simple-price text-uppercase">{{
                                        currencyConvert(config.misc.default_shipping) }}</span>
                                </h6>
                            </div>
                        </template>

                        <template v-if="checkSubscriptionInCart() == 1 && checkOneTimeInCart() == 0">
                            <div class="checkout-meta-data">
                                <h6>
                                    {{ __('Shipping') }}
                                    <span v-if="user?.cart?.shipping?.exact" class="simple-price text-uppercase">{{
                                        currencyConvert(user?.cart?.shipping?.exact?.charge) }}</span>
                                    <span v-else class="simple-price text-uppercase">
                                        <template v-if="config.misc.default_shipping > 0">
                                            {{ currencyConvert(config.misc.default_shipping)
                                            }}
                                        </template>
                                        <template v-else>
                                            {{ __('Free') }}
                                        </template>
                                    </span>
                                </h6>
                            </div>
                        </template>

                        <template v-if="checkSubscriptionInCart() == 0 && checkOneTimeInCart() == 1">
                            <div class="checkout-meta-data">
                                <h6>
                                    {{ __('Shipping') }}
                                    <span v-if="user?.cart?.shipping?.exact" class="simple-price text-uppercase">{{
                                        currencyConvert(user?.cart?.shipping?.exact?.charge) }}</span>
                                    <span v-else class="simple-price text-uppercase">
                                        <template v-if="config.misc.default_shipping > 0">
                                            {{ currencyConvert(config.misc.default_shipping)
                                            }}
                                        </template>
                                        <template v-else>
                                            {{ __('Free') }}
                                        </template>
                                    </span>
                                </h6>
                            </div>
                        </template>

                        <div class="checkout-meta-data"
                            v-if="user?.cart?.policy_discount && user?.cart?.policy_discount > 0">
                            <h6>
                                {{ __('Special Discount') }}
                                <span class="simple-price text-uppercase">
                                    - {{ currencyConvert(user?.cart?.policy_discount) }}
                                </span>
                            </h6>
                        </div>
                        <div class="checkout-meta-data d-flex align-items-center" v-if="user?.cart?.coupon_code">
                            <div>
                                <h6>
                                    {{
                                    __("Coupon Discount")
                                    }}<span class="discount-price ms-3">{{ currencyConvert(user?.cart?.discount)
                                        }}</span>
                                </h6>
                                <p>{{ __("Coupon Code: %s", user?.cart?.coupon_code) }}</p>
                            </div>
                            <span @click.prevent="removeCoupon" class="cursor-pointer ms-auto remove-queue">
                                <img src="../../../images/svg/Ico_Cancel.svg" />
                            </span>
                        </div>
                        <div class="checkout-meta-data">
                            <h6>
                                {{ __('Net Total') }}
                                <span class="simple-price text-uppercase tw-font-bold">{{ currencyConvert(total)
                                    }}</span>
                            </h6>
                        </div>
                        <template v-if="!user?.cart?.coupon_code">
                            <span class="checkout-meta-anchor cursor-pointer"
                                @click.prevent="couponToggle = !couponToggle">{{ __("Have a coupon code?") }}</span>
                            <div class="form-group mt-2 coupon-form" v-if="couponToggle">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                        :class="{ 'is-invalid': errors.code }" placeholder="Coupon Code"
                                        v-model="couponForm.code" />
                                    <button class="btn btn-sm btn-black" @click.prevent="addCoupon"
                                        :disabled="couponForm.processing">
                                        <svg v-if="couponForm.processing" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 256 256">
                                            <path
                                                d="M230,128a102,102,0,0,1-204,0c0-40.18,23.35-76.86,59.5-93.45a6,6,0,0,1,5,10.9C58.61,60.09,38,92.49,38,128a90,90,0,0,0,180,0c0-35.51-20.61-67.91-52.5-82.55a6,6,0,0,1,5-10.9C206.65,51.14,230,87.82,230,128Z">
                                            </path>
                                        </svg>
                                        <small v-else>{{ __("Apply") }}</small>
                                    </button>
                                </div>
                                <div class="text-danger" v-if="errors.code">
                                    {{ errors.code }}
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="checkout-info mt-3 !tw-bg-white !tw-hidden md:!tw-block">
                        <div class="d-flex">
                            <div class="bottom-checkout-box-img">
                                <img src="../../../images/svg/Setup_Queue.svg" alt="QUEUE" />
                            </div>
                            <div class="bottom-checkout-box-content !tw-text-white">
                                <h6>{{__('Guaranteed Safe Checkout')}}</h6>
                                <p class="!tw-text-xs md:!tw-text-base">All data is encrypted. Your card number is never stored on {{ config.app.name }}
                                    servers.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:tw-hidden tw-block">
                    <div class="checkout-info mt-3 !tw-bg-white">
                        <div class="d-flex">
                            <div class="bottom-checkout-box-img">
                                <img src="../../../images/svg/Setup_Queue.svg" alt="QUEUE" />
                            </div>
                            <div class="bottom-checkout-box-content !tw-text-white">
                                <h6>{{__('Guaranteed Safe Checkout')}}</h6>
                                <p class="!tw-text-xs md:!tw-text-base">All data is encrypted. Your card number is never stored on {{
                                    config.app.name }}
                                    servers.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <Progress type="full" v-if="loading || form.processing || cardInfo.processing" />
    </section>
</template>

<script>
    import { useToast } from "vue-toastification";
    import vSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css';
    import { loadStripe } from "@stripe/stripe-js";
    import Progress from "@/Libs/Components/ProgressBar.vue";
    import UserPage from "@/Layouts/UserPage.vue";
    import axios from "axios";

    export default {
        layout: UserPage,
        components: { vSelect, Progress },
        props: {
            user: Object,
            flash: Object,
            errors: Object,
            countries: Object,
            states: Object,
            gateways: Object,
            stripePublicKey: String,
            intent_client_secret: String,
            shipping_addresses: Object,
            sub_discount: Number,
            plan: Object,
        },
        setup() {
            const toast = useToast()
            return { toast }
        },
        data() {
            return {
                addNewAddress: false,
                addressSelected: '',
                footerData: null,
                loading: false,
                cartUpdateForm: this.$inertia.form({
                    quantity: null
                }),
                couponToggle: false,
                couponForm: this.$inertia.form({
                    code: ''
                }),
                cardInfo: {
                    activeError: false,
                    errorText: '',
                    ccName: '',
                    stripe: null,
                    card: null,
                    cvc: null,
                    exp: null,
                    processing: false,
                },
                form: this.$inertia.form({
                    name: this.$page?.props?.user?.first_name !== 'Anonymous' ? this.$page?.props?.user?.first_name : '',
                    email: this.$page?.props?.user?.email,
                    line1: '',
                    line2: '',
                    country: this.getCountryCode(),
                    state: null,
                    city: '',
                    postal_code: '',
                    phone: '',
                    gateway_id: 1,
                    payment_method: null,
                    address_status: '',
                    address_id: '',
                    plan: null,
                })
            }
        },
        beforeMount() {
            axios.get(this.route('section.data', 'footer'))
                .then(({ data }) => {
                    this.footerData = data
                })
            // if (this.address) {
            //     // this.form.name = this.address.name ?? ''
            //     // this.form.email = this.address.email ?? ''
            //     // this.form.line1 = this.address.line1 ?? ''
            //     // this.form.line2 = this.address.line2 ?? ''
            //     // this.form.country = this.address.country ?? 'US'
            //     // this.form.state = this.address.state ?? 'AL'
            //     // this.form.city = this.address.city ?? ''
            //     // this.form.postal_code = this.address.postal_code ?? ''
            //     // this.form.phone = this.address.phone ?? ''
            //     // this.cardInfo.ccName = this.address.name ?? ''
            // }
            if (this.plan) {
                this.form.plan = this.plan.stripe_id;
                console.log('test',this.form.plan)
            }
        },
        methods: {
            edit(shipping) {
                this.form.name = shipping.name ?? this.$page?.props?.user?.first_name
                this.form.email = shipping.email ?? this.$page?.props?.user?.email
                this.form.line1 = shipping.line1 ?? ''
                this.form.line2 = shipping.line2 ?? ''
                this.form.country = shipping.country ?? this.getCountryCode();
                this.form.state = shipping.state ?? null
                this.form.city = shipping.city ?? ''
                this.form.postal_code = shipping.postal_code ?? ''
                this.form.phone = shipping.phone ?? ''
                this.cardInfo.ccName = shipping.name ?? ''
                this.addressSelected = shipping.id;

                this.form.address_status = 'edit';
                this.form.address_id = shipping.id;
                this.addNewAddress = true;
            },
            getCountryCode() {
                let code = this.$page?.props?.config?.misc?.currency_code;
                if (code == 'GBP') {
                    return "GB";
                } else if (code == 'AZN') {
                    return "AZ";
                } else if (code == 'SAR') {
                    return "SA";
                } else {
                    return "US";
                }
            },
            addNew() {
                this.addNewAddress = true;
                if (this.addNewAddress === true) {
                    this.addressSelected = '';
                }
                this.form.reset(
                    'name',
                    'email',
                    'line1',
                    'line2',
                    'country',
                    'state',
                    'city',
                    'postal_code',
                    'phone'
                );
                this.form.address_status = 'add_new';
            },
            selectAddress(shipping) {
                this.form.name = shipping.name ?? this.$page?.props?.user?.first_name
                this.form.email = shipping.email ?? this.$page?.props?.user?.email
                this.form.line1 = shipping.line1 ?? ''
                this.form.line2 = shipping.line2 ?? ''
                this.form.country = shipping.country ?? this.getCountryCode();
                this.form.state = shipping.state ?? null
                this.form.city = shipping.city ?? ''
                this.form.postal_code = shipping.postal_code ?? ''
                this.form.phone = shipping.phone ?? ''
                this.cardInfo.ccName = shipping.name ?? ''
                this.addressSelected = shipping.id;
                this.addNewAddress = false;
            },
            codeInvalidError() {
                this.toast.error(this.errors.code, {
                    position: "top-right",
                    timeout: 5000,
                    closeOnClick: true,
                    pauseOnFocusLoss: true,
                    pauseOnHover: true,
                    draggable: true,
                    draggablePercent: 0.6,
                    showCloseButtonOnHover: false,
                    hideProgressBar: true,
                    closeButton: "button",
                    icon: true,
                    rtl: false
                });
                return false;
            },
            checkSubscriptionInCart() {

                let subscription = 0;
                let cart_items = this.$page.props.user.cart.items;

                cart_items.forEach(function (item) {
                    if (item.purchase_option_type == 'subscription') {
                        subscription = 1;
                    }
                });
                return subscription;
            },
            checkOneTimeInCart() {

                let one_time = 0;
                let cart_items = this.$page.props.user.cart.items;

                cart_items.forEach(function (item) {
                    if (item.purchase_option_type == 'one_time') {
                        one_time = 1;
                    }
                });

                return one_time;
            },
            attrStr(attrs) {
                if (typeof attrs != 'object') return;
                return Object.keys(attrs).reduce((acc, currentKey) => {
                    const html = '<b>' + currentKey.toUpperCase() + '</b>: ' + attrs[currentKey]
                    return acc + html + ', '
                }, '')
            },
            changeCartItem(cartItemIndex, type) {
                const cartItem = this.$page.props.user.cart.items[cartItemIndex]
                this.loading = true
                if (type === 'x') {
                    this.cartUpdateForm.delete(this.route('cart-item.destroy', cartItem.id), {
                        onFinish: (visit) => {
                            this.loading = false
                        }
                    })
                } else {
                    this.cartUpdateForm.quantity = type === '-' ? cartItem.quantity - 1 : cartItem.quantity + 1
                    this.cartUpdateForm.put(this.route('cart-item.update', cartItem.id), {
                        onFinish: (visit) => {
                            this.loading = false
                        }
                    })
                }
            },
            arrivesInMonth() {
                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var d = new Date();
                return monthNames[d.getMonth()];
            },
            addCoupon() {
                // this.couponForm.post(this.route('coupon.attach'))

                this.couponForm.post(this.route('coupon.attach'), {
                    onFinish: (visit) => {
                        this.codeInvalidError()
                    }
                })
            },
            removeCoupon() {
                this.couponForm.delete(this.route('coupon.detach'), {
                    onFinish: (visit) => {
                        this.couponForm.reset()
                    }
                })
            },
            async submitForm() {
                if (this.form.gateway_id == 1) {
                    this.cardInfo.processing = true
                    // const { paymentMethod, error } = await this.cardInfo.stripe.createPaymentMethod(
                    //     'card', this.cardInfo.card, {
                    //         billing_details: { name: this.cardInfo.ccName }
                    //     }
                    // );
                    const { setupIntent, error } = await this.cardInfo.stripe.confirmCardSetup(
                        this.intent_client_secret, {
                        payment_method: {
                            card: this.cardInfo.card,
                            billing_details: { name: this.cardInfo.ccName }
                        }
                    },
                        // Disable the default next action / 3D secure layer  handling.
                        //  {handleActions: false}
                    );

                    // Trigger Facebook Pixel 'AddPaymentInfo' event
                    fbq('track', 'AddPaymentInfo');

                    if (error) {
                        // Display "error.message" to the user...
                        this.cardInfo.activeError = true
                        this.cardInfo.errorText = error.message
                        this.cardInfo.processing = false
                        if (error.code == "card_declined") {
                            this.$inertia.post(this.route('card.declined.mail'), {}, {
                                preserveScroll: true
                            });
                        }
                    } else {
                        // The card has been verified successfully...
                        this.form.payment_method = setupIntent.payment_method
                        // this.form.payment_method = paymentMethod.id
                        this.cardInfo.activeError = false
                        this.cardInfo.processing = false

                        if(this.checkSubscriptionInCart()){
                            this.form.post(this.route('subscribe.store'))
                        fbq('track', 'Subscribe', { value: '19.99', currency: this.$page?.props?.config?.misc?.currency_code, predicted_ltv: '0.00' });
                        }else{
                            this.form.post(this.route('checkout.store'))
                            fbq('track', 'Purchase', { value: '24.99', currency: this.$page?.props?.config?.misc?.currency_code });
                        }

                        // this.form.post(this.route('checkout.store'))
                        // Trigger Facebook Pixel 'Purchase' event

                    }
                } else {

                    this.form.post(this.route('checkout.store'))

                    // Trigger Facebook Pixel 'Purchase' event
                    fbq('track', 'Purchase', { value: '24.99', currency: this.$page?.props?.config?.misc?.currency_code });
                }
            },
            onKeydown(target, length) {
                target.value = target.value.substr(0, length)
            }
        },
        async mounted() {
            if (this.shipping_addresses.length < 1) {
                this.addNewAddress = true;
                this.form.address_status = 'add_new';
            }
            // make address push
            if (this.shipping_addresses.length > 0) {
                let shipping = this.shipping_addresses[0];
                this.selectAddress(shipping);
            }

            // Create a Stripe client
            this.cardInfo.stripe = await loadStripe(this.stripePublicKey);

            // Create an instance of Elements
            const elements = this.cardInfo.stripe.elements();

            /**
             * Try to match bootstrap 4 styling.
             * --------------------------------
             * fontSize was in rem units, but Stripe says that it should be in pixels.
             */
            const style = {
                base: {
                    'fontSize': '16px',
                    'color': '#495057',
                    'fontFamily': 'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
                }
            };

            // Card number
            this.cardInfo.card = elements.create('cardNumber', {
                'placeholder': 'Card Number',
                'style': style
            });
            this.cardInfo.card.mount('#card-number');

            // CVC
            this.cardInfo.cvc = elements.create('cardCvc', {
                'placeholder': 'CVC',
                'style': style
            });
            this.cardInfo.cvc.mount('#card-cvc');

            // Card expiry
            this.cardInfo.exp = elements.create('cardExpiry', {
                'placeholder': 'Expiry',
                'style': style
            });
            this.cardInfo.exp.mount('#card-exp');
        },
        computed: {
            total() {

                let one_time = 0;
                let subscription = 0;
                let cart_items = this.$page.props.user.cart.items;

                cart_items.forEach(function (item) {
                    if (item.purchase_option_type == 'subscription') {
                        subscription = 1;
                    }
                    if (item.purchase_option_type == 'one_time') {
                        one_time = 1;
                    }
                });

                let t = Number(this.$page.props.user.cart.gross_total)

                if (subscription == 1 && one_time == 0) {
                    if (this.$page.props.user.cart?.shipping?.exact) {
                        t += Number(this.$page.props.user.cart?.shipping?.exact?.charge)
                    } else if (this.config?.misc?.default_shipping) {
                        t += Number(this.config.misc.default_shipping)
                    }
                }
                if (subscription == 0 && one_time == 1) {
                    if (this.$page.props.user.cart?.shipping?.exact) {
                        t += Number(this.$page.props.user.cart?.shipping?.exact?.charge)
                    } else if (this.config?.misc?.default_shipping) {
                        t += Number(this.config.misc.default_shipping)
                    }
                }
                if (subscription == 1 && one_time == 1) {
                    if (this.$page.props.user.cart?.shipping?.exact) {
                        t += Number(this.$page.props.user.cart?.shipping?.exact?.charge)
                    } else if (this.config?.misc?.default_shipping) {
                        t += Number(this.config.misc.default_shipping)
                    }
                }
                return t.toFixed(2);
            },
            countriesAsSelect2() {
                return Object.keys(this.countries).map((code) => {
                    return {
                        id: code,
                        label: this.countries[code],
                    };
                });
            },
            statesAsSelect2() {
                if (this.states[this.form.country]) {
                    const states = Object.keys(this.states[this.form.country]).map(
                        (code) => {
                            return {
                                id: code,
                                label: this.states[this.form.country][code],
                            };
                        }
                    );
                    if (!states.filter(state => state.id === this.form.state).length) {
                        this.form.state = null;
                    }
                    return states;
                } else {
                    this.form.state = null;
                    return [];
                }
            },
        },
    }
</script>

<style lang="scss" scoped>
    @import "../../../scss/checkout.scss";

    // @import 'vue-select/dist/vue-select.css';
    .checkout-meta-data img {
        width: 70px;
        margin-inline-end: 10px;
    }

    .vs__dropdown-toggle {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        display: flex;
        padding: 0 0 4px;
        background: none;
        border: 0px !important;
        white-space: normal;
    }

    .form-floating label {
        margin-bottom: 22px !important;
    }

    .checkout-meta-data p img {
        width: 20px;
        margin-inline-end: 5px;
    }

    .remove-queue img {
        width: 30px !important;
    }

    .cart_item {
        background: var(--secondary);
        padding: 16px 24px;
        border-radius: 0px;
    }
    @media (max-width: 525px) {
        .cart_item {
            padding: 8px 12px;
        }
    }

    .cart_btn {
        background: #000 !important;
        color: #fff;
    }

    .product-close-btn {
        background-color: transparent;
        margin-inline-end: 10px;
    }

    .cart-count {
        line-height: 1.5;
        top: -5px !important;
    }

    .what-u-r-getting-p {
        font-weight: bold;
        font-size: 13px !important;
        font-family: 'TT Norms Pro', sans-serif;
    }

    .subs_type__radio:has(input:checked) div::after {
        border: 5px solid #000;
        background: var(--primary);
    }

    .select2-box {
        border: 1px solid black !important;
        border-radius: 5px !important;
    }

    .subs_type__radio:has(input:checked) {
        background: var(--secondary);
    }

    body:has(.offcanvas-active) {
        overflow: hidden !important;
    }
</style>
