<template>
    <section style="background: #000;" class="!tw-z-[9999]">
        <div class="container">
            <nav class="top-menu d-none d-md-flex">
                <ul>
                    <li :class="{ active: isRoute('order') }">
                        <Link :href="route('order')">{{ __('Tracking') }}</Link>
                    </li>
                    <li :class="{ active: isRoute('queue') }">
                        <Link :href="route('queue')"> {{ __('My Queue') }} </Link>
                    </li>
                    <li class="profile-menuitem dropdown">
                        <div class="dropdown-toggle !tw-cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $page?.props?.user?.first_name }}
                            <img class="avatar" v-lazy="$page?.props?.user?.avatar" />
                            <img src="../../../images/svg/CaretDown.svg" class="arrow-down" />
                        </div>
                        <div class="dropdown-menu dropdown-menu-end">
                            <ul class="tw-p-0 tw-m-0 tw-list-none tw-flex tw-flex-col">
                                <h5 class="tw-pl-6 tw-pt-2 tw-text-[#94804E] tw-font-medium">
                                    {{ __('YOUR MEMBERSHIP') }}
                                </h5>
                                <li>
                                    <Link :href="route('queue')" :class="{ active: isRoute('queue') }"
                                        class="dropdown-item">
                                    {{ __('My Queue') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('queue.purchase')" :class="{ active: isRoute('queue.purchase') }"
                                        class="dropdown-item">{{ __('Buy Queue') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('order')" :class="{ active: isRoute('order') }"
                                        class="dropdown-item">
                                    {{ __('Tracking') }}
                                    </Link>
                                </li>
                                <li v-if="$page.props.user?.subscriptions?.length">
                                    <Link :href="route('manage.subscription')"
                                        :class="{ active: isRoute('manage.subscription') }" class="dropdown-item">
                                    {{ __('Manage Subscription') }}
                                    </Link>
                                </li>
                                <li v-else>
                                    <Link :href="route('subscribe')" :class="{ active: isRoute('subscribe') }"
                                        class="dropdown-item">
                                    {{ __('Subscribe to ScentQ') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('product.of.month')"
                                        :class="{ active: isRoute('product.of.month') }" class="dropdown-item">
                                    {{ __('Product Of Month') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('order', 'subscription')" :class="{ active: isRoute('order') }"
                                        class="dropdown-item">
                                    {{ __('My Order') }}
                                    </Link>
                                </li>
                                <h5 class="tw-pl-6 tw-pt-3 tw-pt-2 tw-text-[#94804E] tw-font-medium">
                                    {{ __('YOUR ACCOUNT') }}
                                </h5>
                                <li>
                                    <Link :href="route('rating-history')" :class="{ active: isRoute('rating-history') }"
                                        class="dropdown-item">
                                    {{ __('Rating & Reviews') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('quiz')" :class="{ active: isRoute('quiz') }"
                                        class="dropdown-item">
                                    {{ __('Retake Quiz') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('PersonalInfo')" :class="{ active: isRoute('PersonalInfo') }"
                                        class="dropdown-item">{{ __('Personal Info') }}
                                    </Link>
                                </li>
                                <li v-if="$page.props.user?.subscriptions?.length">
                                    <Link :href="route('address')"
                                        :class="{ active: isRoute('address') || isRoute('address', 'billing') || isRoute('address', 'shipping') }"
                                        class="dropdown-item">{{ __('Billing Information') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('address', 'shipping')"
                                        :class="{ active: isRoute('address') || isRoute('address', 'billing') || isRoute('address', 'shipping') }"
                                        class="dropdown-item">{{ __('Shipping Information') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('changePassword')" :class="{ active: isRoute('changePassword') }"
                                        class="dropdown-item">{{ __('Change Password') }}
                                    </Link>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item"
                                        @click.prevent="logoutForm.post(route('logout'))">
                                        {{ __('Log Out') }}
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <Progress type="full" v-if="loading" />

                <div class="tw-fixed tw-right-0 tw-top-0 tw-transition-all tw-duration-500 tw-h-full !tw-w-full !tw-max-w-[464px] tw-bg-white !tw-z-[99999]"
                    :class="cartModal ? 'tw-translate-x-0' : 'md:tw-translate-x-[700px] tw-translate-x-[90%]'">
                    <div to="body" v-if="cartModal">
                        <div class="sidebar_cart_nav"> </div>
                        <div class="offcanvas offcanvas-end show tw-relative" id="productCartOffcanvs">
                            <div class="offcanvas-body tw-relative tw-bg-white !tw-z-[999999]"
                                style="z-index: 99999999 !important;">
                                <div class="tw-flex tw-gap-6 tw-items-center tw-justify-between tw-px-9 tw-pt-10">
                                    <div>
                                        <h4 class="tw-mb-0 tw-text-base sm:tw-text-2xl">
                                            Your cart
                                            <span v-if="cartItemsCount">
                                                total - <span class="tw-font-bold">
                                                    {{ currencyConvert(cartTotal) }}
                                                </span>
                                            </span>
                                        </h4>
                                        <div v-if="!cartItemsCount">
                                            Your cart is empty
                                        </div>
                                    </div>
                                    <button type="button" id="offcanvas-close-link" @click="closeCartModal()">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15 9L9 15M9 9L15 15M22 12C22 17.523 17.523 22 12 22C6.477 22 2 17.523 2 12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12Z"
                                                stroke="black" stroke-opacity="0.5" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                                <p v-if="checkIfUserSubscribed() == 0 && subscriptionInCart() == 1 && $page?.props?.config?.app?.subscribe_discount_status"
                                    class="tw-text-base tw-px-9 tw-mb-5">
                                    You are getting
                                    <span class="tw-font-medium tw-text-[#E57F09]">
                                        {{ currencyConvert(numberFormat($page?.props?.config?.app?.subscribe_discount_amount, 0)) }} DISCOUNT
                                    </span>
                                    on your first order
                                </p>
                                <div
                                    class="offcanvs-product-card tw-h-[80%] tw-overflow-y-auto scrollbar-hide tw-px-9 tw-relative">
                                    <div v-if="cartItemsCount">
                                        <div v-if="cart.subscribe_items > 0"
                                            class="position-relative my-4 cart_item sm:!tw-p-5 !tw-p-2">
                                            <div>
                                                <div>
                                                    <div class="tw-flex tw-mb-4 tw-justify-between tw-items-center">
                                                        <p class="tw-mb-0 !tw-text-xs what-u-r-getting-p">
                                                            You are getting...
                                                        </p>
                                                        <button @click="removeSubscriptionItems()" type="button"
                                                            class="tw-border-0 tw-inline-flex tw-items-center tw-gap-1 tw-text-sm">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12 4L4 12M4 4L12 12" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                            <span class="sm:tw-inline-block tw-hidden">
                                                                Remove
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <p
                                                        class="mb-4 tw-text-black tw-text-opacity-70 tw-text-sm tw-flex tw-items-center tw-justify-between">
                                                        A month-to-month subscription to ScentQ. Billed monthly, renews automatically, and ships from our warehouse mid-month.
                                                        <span class="tw-min-w-[80px] tw-font-bold tw-text-right">
                                                            {{ currencyConvert(total_price) }}
                                                        </span>
                                                    </p>
                                                    <p
                                                        class="tw-font-medium tw-text-black !tw-text-opacity-70 tw-uppercase !tw-text-xs">
                                                        {{ arrivesInMonth() }} Order
                                                    </p>
                                                </div>
                                                <template v-for="(cartItem, cartItemIndex) in cart.items"
                                                    :key="cartItemIndex">
                                                    <!-- Loop 1 -->
                                                    <template v-if="cartItem.purchase_option_type == 'subscription'">
                                                        <div class="tw-flex tw-gap-3 tw-items-center tw-mb-4">
                                                            <div>
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center sm:tw-w-20 tw-w-14 sm:tw-h-20 tw-h-14">
                                                                    <img class="tw-w-full tw-h-full tw-object-contain"
                                                                        :src="cartItem.product.image?.url"
                                                                        :alt="cartItem.product.title">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="tw-w-full tw-flex tw-justify-between tw-items-center">
                                                                <div>
                                                                    <h6
                                                                        class="notranslate sm:tw-text-lg tw-text-sm tw-capitalize tw-text-black tw-mb-0.5">
                                                                        {{ cartItem.product.title }}
                                                                    </h6>
                                                                    <p
                                                                        class="notranslate tw-mb-1.5 tw-capitalize tw-text-sm tw-text-[#808080]">
                                                                        {{ cartItem.product.brand.name }}
                                                                    </p>
                                                                    <p
                                                                        class="tw-mb-0 tw-text-xs tw-font-medium tw-text-[#4D4D4D]">
                                                                        {{ cartItem?.product?.purchase_options[0]?.quantity_text }}
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <button @click="openCanvasModal(cartItem?.id)" type="button" class="tw-border-0 tw-text-black tw-no-underline tw-inline-flex tw-items-center tw-gap-1 tw-text-sm">
                                                                        <span>
                                                                            Edit
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template v-if="plan.product_count - $page?.props?.subscribe_items?.length > 0 && $page?.props?.subscribe_items?.length !== 0">
                                                    <template v-for="left in (plan.product_count ?? 0) - ($page?.props?.subscribe_items?.length ?? 0)">
                                                        <div @click="openCanvasModal(null)"
                                                            class="tw-cursor-pointer tw--mt-[1rem] tw-flex tw-gap-4 tw-justify-start tw-items-center md:tw-py-4 tw-py-2 md:tw-px-6 tw-px-3 tw-bg-secondary">
                                                            <div
                                                                class="tw-w-[64px] tw-min-w-[64px] tw-h-[64px] tw-min-h-[64px] tw-inline-flex tw-justify-center tw-items-center">
                                                                <img src="../../../images/product-Icon.png" class="tw-w-full tw-h-full tw-object-contain"
                                                                    alt="" />
                                                            </div>
                                                            <div>
                                                                <h6 class="tw-text-sm md:tw-text-lg tw-font-bold tw-mb-2 tw-text-black">
                                                                    Pick Your Scent
                                                                </h6>
                                                                <p class="tw-text-base tw-font-normal tw-mb-0 tw-text-black">
                                                                    Should this slot be empty, we will deliver our specially curated Fragrance of the Month to you.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                            </div>
                                            <p class="tw-text-sm tw-text-black/70 tw-mb-4">
                                                This is your first 10ml fragrance. You can see any others and edit them, once you have subscribed.
                                            </p>
                                            <div v-if="plan.free_product" class="tw-flex tw-gap-3 tw-items-center">
                                                <div>
                                                    <div
                                                        class="d-flex justify-content-center align-items-center sm:tw-w-20 tw-w-14 sm:tw-h-20 tw-h-14">
                                                        <img class="tw-w-full tw-h-full tw-object-contain"
                                                            :src="plan.free_product?.image?.url"
                                                            :alt="plan.free_product?.title">
                                                    </div>
                                                </div>
                                                <div class="tw-w-full tw-flex tw-justify-between tw-items-center">
                                                    <div>
                                                        <h6 class="tw-text-lg tw-capitalize tw-text-black">
                                                            {{ plan.free_product?.title }}
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <button type="button"
                                                            class="tw-border-0 tw-inline-flex tw-text-black tw-items-center tw-gap-1 tw-text-sm">
                                                            <span>
                                                                Free
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <ConfirmDialog ref="subscriptionConfirm2" />
                                        </div>
                                        <!-- Loop 2 -->
                                        <template v-for="(cartItem, cartItemIndex) in cart.items" :key="cartItemIndex">
                                            <template v-if="cartItem.purchase_option_type != 'subscription'">
                                                <div class="position-relative my-4 cart_item sm:!tw-p-5 !tw-p-2">
                                                    <div>
                                                        <div
                                                            v-if="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time'">
                                                            <p
                                                                class="tw-font-medium tw-mb-3 tw-text-black !tw-text-opacity-70 tw-uppercase !tw-text-xs">
                                                                ONE-TIME PURCHASE
                                                            </p>
                                                        </div>

                                                        <div class="tw-flex tw-gap-3 tw-items-center tw-mb-4">
                                                            <div>
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center sm:tw-w-20 tw-w-14 sm:tw-h-20 tw-h-14">
                                                                    <img class="tw-w-full tw-h-full tw-object-contain"
                                                                        :src="cartItem.product.image?.url"
                                                                        :alt="cartItem.product.title">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="tw-w-full tw-flex tw-justify-between tw-items-center">
                                                                <div>
                                                                    <h6
                                                                        class="sm:tw-text-lg tw-text-sm tw-capitalize tw-text-black tw-mb-0.5">
                                                                        {{ cartItem.product?.title }}
                                                                    </h6>
                                                                    <p
                                                                        class="tw-mb-1.5 tw-capitalize tw-text-sm tw-text-[#808080]">
                                                                        {{ cartItem.product?.brand?.name }}
                                                                    </p>
                                                                    <p
                                                                        class="tw-mb-0 tw-text-xs tw-font-medium tw-text-[#4D4D4D]">
                                                                        {{
                                                                        cartItem?.product?.purchase_options[0]?.quantity_text
                                                                        }}
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <button type="button"
                                                                        class="tw-border-0 tw-inline-flex tw-items-center tw-gap-1 tw-text-sm"
                                                                        @click.prevent="removeSingleProduct(cartItem.id)">
                                                                        <svg width="16" height="16" viewBox="0 0 16 16"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M12 4L4 12M4 4L12 12"
                                                                                stroke="black" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                        </svg>
                                                                        <span class="sm:tw-inline-block tw-hidden">
                                                                            Remove
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tw-flex tw-justify-between tw-items-center">
                                                            <div class="tw-inline-flex tw-items-center">
                                                                <button
                                                                    class="border-0 tw-inline-flex tw-justify-center tw-items-center tw-w-6 tw-h-6 tw-bg-[#E8D6C7] rounded-pill"
                                                                    @click.prevent="changeCartItem(cartItemIndex, '-')">
                                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M3.33398 8H12.6673" stroke="black"
                                                                            stroke-opacity="0.5" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" />
                                                                    </svg>
                                                                </button>
                                                                <div
                                                                    class="tw-w-10 tw-inline-flex tw-justify-center tw-items-center">
                                                                    {{ cartItem.quantity }}
                                                                </div>
                                                                <button
                                                                    class="border-0 tw-inline-flex tw-justify-center tw-items-center tw-w-6 tw-h-6 tw-bg-[#E8D6C7] rounded-pill"
                                                                    @click.prevent="changeCartItem(cartItemIndex, '+')">
                                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M8.00065 3.33331V12.6666M3.33398 7.99998H12.6673"
                                                                            stroke="black" stroke-opacity="0.5"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div>
                                                                <h6
                                                                    class="tw-text-base tw-font-medium tw-mb-0 tw-text-black">
                                                                    {{ currencyConvert(cartItem.subtotal) }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ConfirmDialog :ref="'removeSingleProduct' + cartItem.id" />
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                    <div v-if="cartItemsCount">
                                        <div class="tw-flex tw-flex-col tw-gap-4 !tw-mr-5 tw-pb-12">
                                            <div class="tw-flex tw-justify-between tw-itmes-center tw-text-base">
                                                <h6 class="mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                    Total
                                                </h6>
                                                <h6 class="mb-0 tw-font-medium">
                                                    {{ currencyConvert(cart?.net_total) }}
                                                </h6>
                                            </div>
                                            <template v-if="checkIfUserSubscribed() == 0 && subscriptionInCart() == 1 && $page?.props?.config?.app?.subscribe_discount_status">
                                                <div class="d-flex justify-content-between tw-items-center">
                                                    <h6 class="!tw-font-normal tw-mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                        Subscription discount
                                                        <small
                                                            style="width: 100%;float: left;font-size: 13px;color: #565656;">
                                                            Offer applied to the first month read-only
                                                        </small>
                                                    </h6>
                                                    <h6 class="tw-mb-0 tw-font-medium">
                                                        -{{
                                                        currencyConvert($page?.props?.config?.app?.subscribe_discount_amount,
                                                        0) }}
                                                    </h6>
                                                </div>
                                            </template>

                                            <template v-if="subscriptionInCart() == 1 && oneTimeInCart() == 1">
                                                <div class="d-flex tw-items-center justify-content-between">
                                                    <h6 class="tw-mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                        Subscription shipping
                                                    </h6>
                                                    <h6 class="tw-mb-0">
                                                        Always Free
                                                    </h6>
                                                </div>
                                                <div v-if="cart?.shipping?.exact"
                                                    class="d-flex justify-content-between tw-items-center">
                                                    <h6 class="tw-mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                        Ecommerce shipping
                                                    </h6>
                                                    <h6 class="tw-mb-0 tw-font-medium">
                                                        {{ currencyConvert(cart?.shipping?.exact?.charge) }}
                                                    </h6>
                                                </div>
                                                <div v-else class="d-flex justify-content-between tw-items-center">
                                                    <h6 class="tw-mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                        Ecommerce shipping
                                                    </h6>
                                                    <h6 class="tw-mb-0 tw-font-medium">
                                                        {{ currencyConvert(config.misc.default_shipping) }}
                                                    </h6>
                                                </div>
                                            </template>

                                            <template v-if="subscriptionInCart() == 1 && oneTimeInCart() == 0">
                                                <div class="d-flex justify-content-between tw-items-center">
                                                    <h6 class="tw-mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                        Shipping
                                                    </h6>
                                                    <h6 class="tw-mb-0 tw-font-medium">
                                                        <template v-if="config.misc.default_shipping > 0">
                                                                {{ currencyConvert(config.misc.default_shipping) }}
                                                            </template>
                                                            <template v-else>
                                                               Free
                                                            </template>
                                                    </h6>
                                                </div>
                                            </template>

                                            <template v-if="subscriptionInCart() == 0 && oneTimeInCart() == 1">
                                                <div class="checkout-meta-data">
                                                    <div v-if="cart?.shipping?.exact"
                                                        class="d-flex justify-content-between">
                                                        <h6 class="tw-mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                            Shipping
                                                        </h6>
                                                        <h6 class="te-mb-0 tw-font-medium">
                                                            {{ currencyConvert(cart?.shipping?.exact?.charge) }}
                                                        </h6>
                                                    </div>
                                                    <div v-else class="d-flex justify-content-between">
                                                        <h6 class="tw-mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                            Shipping
                                                        </h6>
                                                        <h6 class="tw-mb-0 tw-font-medium">
                                                            <template v-if="config.misc.default_shipping > 0">
                                                                {{ currencyConvert(config.misc.default_shipping) }}
                                                            </template>
                                                            <template v-else>
                                                               Free
                                                            </template>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </template>
                                            <div class="d-flex justify-content-between"
                                                v-if="cart?.policy_discount && cart?.policy_discount > 0">
                                                <h6 class="tw-mb-0 !tw-text-[rgba(0,0,0,0.64)]">
                                                    Special Discount
                                                </h6>
                                                <h6 class="tw-mb-0 tw-font-medium">
                                                    - {{ currencyConvert(cart?.policy_discount) }}
                                                </h6>
                                            </div>
                                            <div
                                                class="tw-flex tw-justify-between tw-items-center tw-pt-4 tw-border-t tw-border-[rgba(0,0,0,0.08)]">
                                                <h6 style="font-weight: 600;">
                                                    Net Total
                                                </h6>
                                                <h6 style="font-weight: 600;">
                                                    {{ currencyConvert(cartTotal) }}
                                                </h6>
                                            </div>

                                        </div>
                                        <div class="!tw-mt-12"></div>
                                        <div class="text-center" v-if="cart?.shipping?.exact">
                                            <p>
                                                You now qualify for
                                            </p>
                                            <h6 style="color: #ff5fa0; font-weight: 600;text-transform: uppercase;">
                                                {{ currencyConvert(cart?.shipping?.exact?.charge)
                                                }} shipping
                                            </h6>
                                        </div>
                                        <div class="text-center" v-if="cart?.shipping?.promo">
                                            <p>
                                                Add more {{ currencyConvert(promoDiff) }} to get
                                            </p>
                                            <h6 style="color: #ff5fa0; font-weight: 600;text-transform: uppercase;">
                                                {{ currencyConvert(cart?.shipping?.promo?.charge)
                                                }} shipping
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="" v-if="cartItemsCount">
                                    <Link @click="closeCartModal()" v-if="cart.subscribe_items > 0 && cartItemsCount == plan.product_count"
                                        :href="route('subscribe')" as="button"
                                        class="tw-absolute tw-bottom-12 tw-left-9 tw-right-9 tw-bg-black tw-text-white tw-py-3 -tw-mt-8">
                                    Checkout
                                    </Link>
                                    <Link @click="closeCartModal()" v-if="cart.subscribe_items > 0 && cartItemsCount != plan.product_count"
                                        :href="route('check.plan.cart')" as="button"
                                        class="tw-absolute tw-bottom-12 tw-left-9 tw-right-9 tw-bg-black tw-text-white tw-py-3 -tw-mt-8">
                                    Checkout
                                    </Link>
                                    <Link v-else @click="closeCartModal()" :href="route('checkout')" as="button"
                                        class="tw-absolute tw-bottom-12 tw-left-9 tw-right-9 tw-bg-black tw-text-white tw-py-3 -tw-mt-8">
                                    Checkout
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div @click="closeCartModal()"
                    :class="cartModal ? 'tw-fixed tw-top-0 tw-left-0 tw-w-full tw-h-full tw-bg-[rgba(0,0,0,0.5)] tw-z-[99998]' : 'hidden'">
                </div>
            </nav>
        </div>
    </section>
     <!-- offcanvas -->
     <off-canvas :cartOffcanvas="cartOffcanvas" @status="toggleCanvas" :subscribePlanType="subscribePlanType" :replaceItem="replaceItem" />
</template>

<script>
    import { Link } from "@inertiajs/inertia-vue3";
    import Progress from "@/Libs/Components/ProgressBar.vue";
    import axios from 'axios';
    import ConfirmDialog from "../../Components/Pranta/ConfirmDialog.vue";
    import OffCanvas from '../../Pages/Subscribe/OffCanvas.vue'
    export default {
        components: { Link, Progress, ConfirmDialog, OffCanvas },
        props: ['cartModal', 'cart'],
        data() {
            return {
                cartOffcanvas: false,
                replaceItem: '',
                subscribePlanType: '',
                has_subscribe: 0,
                loading: false,
                logoutForm: this.$inertia.form({}),
                cartUpdateForm: this.$inertia.form({
                    quantity: null
                }),
                first_time_subscribe: false,
                plan: {},
                total_price: '',
                coup: {},
                couponForm: this.$inertia.form({
                    code: "",
                }),
            }
        },
        watch: {
            cartModal: {
                deep: true,
                handler(val, oldVal) {
                    if (val) {
                        document.body.style.setProperty("overflow", "hidden", "important");
                    } else {
                        document.body.style.setProperty("overflow", "unset", "important");
                    }
                },
            },
            '$page.props': {
                deep: true,
                handler(data) {
                    this.getSubscriptionData()
                },
            },
        },
        computed: {
            // cart() {
            //     return this.$page.props?.user?.cart;
            // },
            cartTotal() {

                let c_one_time = 0;
                let c_subscription = 0;
                let c_cart_items = this.$page.props.user.cart.items;

                let t = Number(this.cart.gross_total)

                c_cart_items.forEach(function (item) {
                    if (item.purchase_option_type == 'subscription') {
                        c_subscription = 1;
                    }
                    if (item.purchase_option_type == 'one_time') {
                        c_one_time = 1;
                    }
                });

                if (c_subscription == 1 && c_one_time == 0) {
                    if (this.$page.props.user.cart?.shipping?.exact) {
                        t += Number(this.$page.props.user.cart?.shipping?.exact?.charge)
                    } else if (this.config?.misc?.default_shipping) {
                        t += Number(this.config.misc.default_shipping)
                    }
                }

                if (c_subscription == 0 && c_one_time == 1) {
                    if (this.$page.props.user.cart?.shipping?.exact) {
                        t += Number(this.$page.props.user.cart?.shipping?.exact?.charge)
                    } else if (this.config?.misc?.default_shipping) {
                        t += Number(this.config.misc.default_shipping)
                    }
                }
                if (c_subscription == 1 && c_one_time == 1) {
                    if (this.$page.props.user.cart?.shipping?.exact) {
                        t += Number(this.$page.props.user.cart?.shipping?.exact?.charge)
                    } else if (this.config?.misc?.default_shipping) {
                        t += Number(this.config.misc.default_shipping)
                    }
                }
                return t.toFixed(2);

                // let t = 0;
                // if (this.cart) t += Number(this.cart.gross_total)
                // if (this.cart?.shipping?.exact) t += Number(this.cart?.shipping?.exact?.charge)
                // return t;
            },
            cartItemsCount() {
                return this.cart?.items?.reduce((acc, item) => acc + Number(item.quantity), 0)
            },
            promoDiff() {
                if (this.cart.shipping?.promo) {
                    return parseFloat(Number(this.cart.shipping?.promo?.minimum_amount) - Number(this.cart?.net_total)).toFixed(this.config.misc.round)
                }
                return 0;
            },
            total() {
                let total = Number(this.plan.total_price);

                if (this.coup) {
                    total -= Number(this.couponDiscount(this.coup));
                } else if (this.plan.auto_coupon) {
                    total -= Number(this.couponDiscount(this.plan.auto_coupon));
                }
                // if (this.plan.tax) {
                //     const tax = (total * Number(this.plan.tax)) / 100;
                //     total += tax;
                // }
                if (!isNaN(this.couponDiscount)) {
                    total -= Number(this.couponDiscount);
                }

                return total.toFixed(this.config.misc.round ?? 2);
            },
        },
        methods: {
            openCanvasModal(cartItem){
                this.replaceItem = cartItem;
                this.cartOffcanvas = true;
                // alert(product)
            },
            toggleCanvas(payload){
                const { status, cartItem } = payload;
                this.replaceItem = cartItem;
                this.cartOffcanvas = status;
            },
            removeCoupon() {
                this.couponForm.delete(this.route("subscribe.coupon.destroy"), {
                    onFinish: (visit) => {
                        this.couponForm.reset();
                    },
                });
                this.getSubscriptionData();
            },
            couponDiscount(coupon) {
                if (!coupon) return 0;
                let discountRaw;
                let planPrice = Number(this.plan.total_price);
                if (coupon.discount_type == 2) {
                    discountRaw = Number(coupon.amount);
                } else {
                    discountRaw = (planPrice * Number(coupon.amount)) / 100;
                    if (coupon.upto != -1 && discountRaw > Number(coupon.upto)) {
                        discountRaw = Number(coupon.upto);
                    }
                }

                if (discountRaw > planPrice) {
                    discountRaw = planPrice;
                }

                return discountRaw.toFixed(this.config.misc.round ?? 2);
            },
            subscriptionInCart() {
                let subscription = 0;
                let cart_items = this.$page.props.user.cart.items;
                cart_items.forEach(function (item) {
                    if (item.purchase_option_type == 'subscription') {
                        subscription = 1;
                    }
                });
                return subscription;
            },
            oneTimeInCart() {
                let one_time = 0;
                let cart_items = this.$page.props.user.cart.items;
                cart_items.forEach(function (item) {
                    if (item.purchase_option_type == 'one_time') {
                        one_time = 1;
                    }
                });
                return one_time;
            },
            checkIfUserSubscribed() {
                let is_subscribed = 0;
                if (typeof this.$page.props.user.subscriptions[0] !== 'undefined') {
                    is_subscribed = 1;
                }
                return is_subscribed;
            },
            isRoute(name, params) {
                return this.$page.props.ziggy.url === this.route(name, params)
            },
            attrStr(attrs) {
                if (typeof attrs != 'object') return;
                return Object.keys(attrs).reduce((acc, currentKey) => {
                    const html = '<b>' + currentKey.toUpperCase() + '</b>: ' + attrs[currentKey]
                    return acc + html + ', '
                }, '')
            },

            async removeSingleProduct(id) {

                let ref = 'removeSingleProduct' + id;
                const ok = await this.$refs[ref][0].show({
                    message: 'Would you like to remove this item from cart?',
                });

                if (!ok) {
                    this.loading = false
                    return;
                }

                this.cartUpdateForm.delete(this.route('cart-item.destroy', id), {
                    onFinish: (visit) => {
                        this.loading = false
                    }
                })
            },

            async changeCartItem(cartItemIndex, type) {
                const cartItem = this.cart.items[cartItemIndex]
                this.loading = true

                this.cartUpdateForm.quantity = type === '-' ? cartItem.quantity - 1 : cartItem.quantity + 1
                this.cartUpdateForm.put(this.route('cart-item.update', cartItem.id), {
                    onFinish: (visit) => {
                        this.loading = false
                    }
                })
            },
            arrivesInMonth() {
                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var d = new Date();
                return monthNames[d.getMonth()];
            },
            handleCheckoutClick(e) {
                e.preventDefault();
                this.$emit('setCartModalStatus', false);
                setTimeout(() => {
                    this.$inertia.get(this.route('checkout'));
                }, 500);
                document.body.style.paddingRight = '0px !important';
            },
            closeCartModal() {
                  this.$emit('setCartModalStatus', false);
            },

            getSubscriptionData() {

                // Get the current URL
                var currentUrl = window.location.href;

                // Split the URL by "/"
                var urlParts = currentUrl.split("/");

                // Find the position of "subscribe" in the URL
                var subscribeIndex = urlParts.indexOf("subscribe");

                // If "subscribe" is found, get the value that follows it
                if (subscribeIndex !== -1 && subscribeIndex < urlParts.length - 1) {
                    var valueAfterSubscribe = urlParts[subscribeIndex + 1];

                    this.subscribePlanType = valueAfterSubscribe;
                }

                axios.post(this.route('api.get.subscription.data', {plan: valueAfterSubscribe}))
                    .then((res) => {
                        this.plan = res.data.plan;
                        this.first_time_subscribe = res.data.first_time_subscribe;
                        this.total_price = res.data.total_price;
                        this.coup = res.data.coup;
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            },
            async removeSubscriptionItems() {
                this.loading = true;

                const ok = await this.$refs.subscriptionConfirm2.show({
                    message: 'Would you like to remove this item from cart?',
                });

                if (!ok) {
                    this.loading = false
                    return;
                }

                this.$inertia.post(this.route('remove.subscription.items'), {}, {
                    preserveScroll: true,
                    onFinish: (visit) => {
                        this.loading = false;
                    }
                })
            }
        },
        mounted() {
            this.getSubscriptionData();
            document.onclick = function (e) {
                if (document.querySelector(".menu-utilities .search_box")) {
                    if (e.target.classList.contains('productSearchImg')) {
                        document.querySelector(".menu-utilities .search_box .search_close").click();
                    }
                    let search_box = document.querySelector(".menu-utilities .search_box");
                    let search_btn = document.querySelector(".search_btn img");
                    if (e.target.classList.contains !== 'search_box' && e.target != search_btn) {
                        if (!search_box.contains(e.target)) {
                            document.querySelector(".menu-utilities .search_box .search_close").click();
                        }
                    }
                }
            };
        },
    }
</script>

<style>
    .top-menu ul * {
        font-size: 16px !important;
    }

    .top-menu ul h5 {
        font-weight: 600 !important;
        padding-right: 1rem;
    }

    .top-menu a {
        font-size: 16px !important;
        line-height: 1.5 !important;
        /* make font smooth */
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .offcanvas {
        transition: all 0.5s;
    }

    .offcanvas {
        top: 0;
        width: 648px;
        z-index: 999;
        right: 0;
    }

    .offcanvas.offcanvas-end.show {
        visibility: visible;
    }

    .cart_item {
        background: var(--secondary);
        padding: 20px 15px;
        border-radius: 5px;
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

    .sidebar_cart_nav {
        display: none;
        width: 100%;
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        z-index: 1;
        background: rgba(0, 0, 0, 0.65);
    }

    .what-u-r-getting-p {
        font-weight: bold;
        font-size: 13px;
        font-family: 'TT Norms Pro', sans-serif;
    }

    .cart-minus-btn {
        position: relative;
        top: -3px !important;
        font-size: 21px;
    }

    @media(max-width: 767px) {
        .offcanvas-body {
            padding: 0px;
        }
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: scroll;
    }

    .scrollbar-hide ::-webkit-scrollbar {
        display: none;
    }
</style>
