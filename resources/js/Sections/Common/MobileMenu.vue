<template>
    <sticky-menu class="mobile-header ssssticky-top d-lg-none !tw-z-[9999]">
        <div class="mobile-menu-wrap tw-flex tw-justify-between tw-items-center">
            <div class="tw-inline-flex tw-items-center tw-gap-2.5">
                <button v-if="!user" @click="menuList = !menuList" class="menu-toggle">
                    <template v-if="menuList">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.3638 18.364C17.9733 18.7545 17.3402 18.7545 16.9496 18.364L5.63592 7.05026C5.2454 6.65974 5.2454 6.02657 5.63592 5.63605V5.63605C6.02645 5.24552 6.65961 5.24552 7.05014 5.63605L18.3638 16.9498C18.7544 17.3403 18.7544 17.9734 18.3638 18.364V18.364Z"
                                fill="white" />
                            <path
                                d="M5.63606 18.364C5.24554 17.9734 5.24554 17.3403 5.63606 16.9498L16.9498 5.63605C17.3403 5.24552 17.9735 5.24552 18.364 5.63605V5.63605C18.7545 6.02657 18.7545 6.65973 18.364 7.05026L7.05028 18.364C6.65975 18.7545 6.02659 18.7545 5.63606 18.364V18.364Z"
                                fill="white" />
                        </svg>
                    </template>
                    <template v-else>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3 5C3 4.44772 3.44772 4 4 4H20C20.5523 4 21 4.44772 21 5C21 5.55228 20.5523 6 20 6H4C3.44772 6 3 5.55228 3 5ZM3 12C3 11.4477 3.44772 11 4 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H4C3.44772 13 3 12.5523 3 12ZM3 19C3 18.4477 3.44772 18 4 18H20C20.5523 18 21 18.4477 21 19C21 19.5523 20.5523 20 20 20H4C3.44772 20 3 19.5523 3 19Z"
                                fill="white" />
                        </svg>
                    </template>
                </button>
                <button class="search_btn tw-inline-flex search_btn_mobile text-decoration-none" v-on:click="isClick"
                    aria-label="Search">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21 21L16.65 16.65M19 11C19 13.1217 18.1571 15.1566 16.6569 16.6569C15.1566 18.1571 13.1217 19 11 19C8.87827 19 6.84344 18.1571 5.34315 16.6569C3.84285 15.1566 3 13.1217 3 11C3 8.87827 3.84285 6.84344 5.34315 5.34315C6.84344 3.84285 8.87827 3 11 3C13.1217 3 15.1566 3.84285 16.6569 5.34315C18.1571 6.84344 19 8.87827 19 11Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div class="mbl_search_box" v-if="isSearch">
                    <div class="tw-bg-[#000] tw-flex tw-justify-between tw-items-center tw-py-4 tw-px-6">
                        <Link :href="route('index')" class="search-left-logo">
                        <img src="../../../images/svg/logo-light.svg" style="width: 116px;" :alt="config.app.name" />
                        </Link>
                        <button type="button" class="btn-close tw-text-white text-reset search_close"
                            v-on:click="isSearch = false" aria-label="Close"></button>
                    </div>
                    <div class="container">
                        <div class="search_form">
                            <instant-search
                                :input-attrs="{ placeholder: __('Search'), class: 'form-control form-control-sm custom_search_box' }" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-logo">
                <Link :href="route('index')">
                <img src="../../../images/svg/logo-light.svg" class="img-fluid" style="width: 100px;"
                    :alt="$page?.props?.config?.app?.name" />
                </Link>
            </div>
            <div class="menu-utilities tw-inline-flex tw-items-center tw-gap-2.5">

                <div v-if="$page?.props?.user" class="profile-menuitem dropdown ll-dropdown !tw-cursor-pointer"
                    @click="menuList = !menuList">
                    <div class="dropdown-toggle">
                        <img v-if="!menuList" class="tw-w-6 tw-h-6 tw-rounded-full tw-ml-0"
                            :src="$page?.props?.user?.avatar" />
                        <template v-else>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.3638 18.364C17.9733 18.7545 17.3402 18.7545 16.9496 18.364L5.63592 7.05026C5.2454 6.65974 5.2454 6.02657 5.63592 5.63605V5.63605C6.02645 5.24552 6.65961 5.24552 7.05014 5.63605L18.3638 16.9498C18.7544 17.3403 18.7544 17.9734 18.3638 18.364V18.364Z"
                                    fill="white" />
                                <path
                                    d="M5.63606 18.364C5.24554 17.9734 5.24554 17.3403 5.63606 16.9498L16.9498 5.63605C17.3403 5.24552 17.9735 5.24552 18.364 5.63605V5.63605C18.7545 6.02657 18.7545 6.65973 18.364 7.05026L7.05028 18.364C6.65975 18.7545 6.02659 18.7545 5.63606 18.364V18.364Z"
                                    fill="white" />
                            </svg>
                        </template>
                        <!-- <img src="../../../images/svg/CaretDown.svg" class="arrow-down" /> -->
                    </div>
                    <div :class="menuList ? 'tw-visible tw-translate-x-0' : 'tw-invisible -tw-translate-x-full'"
                        class="!tw-z-[9999] ll-mobile-menu tw-overflow-y-auto tw-fixed tw-pt-6 tw-pb-32 tw-left-0 tw-top-[44px] tw-transition-all tw-duration-500 tw-w-full tw-h-full tw-bg-white">
                        <div class="tw-flex tw-flex-col tw-gap-6">
                            <MenuList @close-menu-list="closeMenuList" />
                        </div>
                    </div>
                </div>
                <div @click.prevent="openCart" class="cart-icon tw-relative">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17158 10.8284C8.42143 10.0783 8.00001 9.06087 8.00001 8M3.63301 7.401L2.93301 15.801C2.78301 17.606 2.70701 18.508 3.01301 19.204C3.28088 19.8154 3.74504 20.3201 4.33201 20.638C5.00001 21 5.90501 21 7.71601 21H16.283C18.093 21 18.999 21 19.667 20.638C20.2543 20.3202 20.7189 19.8156 20.987 19.204C21.292 18.508 21.217 17.606 21.067 15.801L20.367 7.401C20.237 5.849 20.172 5.072 19.828 4.485C19.5253 3.96765 19.0746 3.55282 18.534 3.294C17.92 3 17.141 3 15.583 3H8.41601C6.85801 3 6.07901 3 5.46601 3.294C4.92515 3.55239 4.4741 3.96687 4.17101 4.484C3.82701 5.072 3.76201 5.849 3.63301 7.401Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span
                        class="tw-absolute -tw-top-2.5 -tw-right-2.5 tw-w-5 tw-h-5 tw-text-sm tw-inline-flex tw-justify-center tw-items-center tw-rounded-full tw-border tw-border-[#000] tw-bg-[#000] tw-text-white"
                        v-if="cart?.items?.length">
                        {{ cart?.items?.length }}
                    </span>
                </div>

                <div v-if="!$page?.props?.user">
                    <Link class="text-decoration-none tw-font-semibold text-white" :href="route('login')">
                    <!-- <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 15C15.3137 15 18 12.3137 18 9C18 5.68629 15.3137 3 12 3C8.68629 3 6 5.68629 6 9C6 12.3137 8.68629 15 12 15Z"
                                            stroke="white" stroke-width="2" stroke-miterlimit="10" />
                                        <path
                                            d="M2.90625 20.25C3.82775 18.6536 5.15328 17.3279 6.74958 16.4062C8.34588 15.4844 10.1567 14.9992 12 14.9992C13.8433 14.9992 15.6541 15.4844 17.2504 16.4062C18.8467 17.3279 20.1722 18.6536 21.0938 20.25"
                                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> -->
                    {{ __('Login') }}
                    </Link>
                </div>
            </div>

        </div>
        <div :class="menuList ? 'tw-visible tw-translate-x-0' : 'tw-invisible -tw-translate-x-full'"
            class="!tw-z-[9999] ll-mobile-menu tw-pb-16 tw-overflow-y-auto tw-fixed tw-left-0 tw-top-[44px] tw-transition-all tw-duration-500 tw-w-full tw-h-full tw-bg-white">
            <div class="tw-flex tw-flex-col tw-gap-6 tw-py-6">
                <MenuList @close-menu-list="closeMenuList" />
            </div>
        </div>
        <Progress type="full" v-if="loading" />

        <div class="tw-fixed tw-end-0 tw-top-0 tw-transition-all tw-duration-500 tw-h-full !tw-max-w-[464px] tw-w-full tw-bg-white !tw-z-[99999]"
            :class="cartModal ? 'tw-translate-x-0' : 'tw-translate-x-full'">
            <div to="body" v-if="cartModal">
                <div class="sidebar_cart_nav"> </div>
                <div class="offcanvas offcanvas-end show tw-relative" id="productCartOffcanvs">
                    <div class="offcanvas-body tw-relative tw-bg-white !tw-z-[999999]"
                        style="z-index: 99999999 !important;">
                        <div
                            class="tw-flex tw-gap-6 tw-items-center tw-justify-between sm:tw-px-9 tw-px-3 sm:tw-pt-10 tw-pt-3">
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
                                        stroke="black" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <p v-if="checkIfUserSubscribed() == 0 && subscriptionInCart() == 1 && $page?.props?.config?.app?.subscribe_discount_status"
                            class="tw-text-base sm:tw-px-9 tw-px-3 tw-mb-5">
                            You are getting
                            <span class="tw-font-medium tw-text-[#E57F09]">
                                {{ currencyConvert(numberFormat($page?.props?.config?.app?.subscribe_discount_amount, 0)) }} DISCOUNT
                            </span>
                            on your first order
                        </p>
                        <div
                            class="offcanvs-product-card tw-h-[80%] tw-overflow-y-auto sm:tw-px-9 tw-px-3 scrollbar-hide">

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
                                                        <path d="M12 4L4 12M4 4L12 12" stroke="black" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
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
                                        <template v-for="(cartItem, cartItemIndex) in cart.items" :key="cartItemIndex">
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
                                                    <div class="tw-w-full tw-flex tw-justify-between tw-items-center">
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
                                                                {{ cartItem?.product?.purchase_options[0]?.quantity_text
                                                                }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <button @click="openCanvasModal(cartItem?.id)" type="button" class="tw-border-0 !tw-whitespace-nowrap tw-text-black tw-no-underline tw-inline-flex tw-items-center tw-gap-1 tw-text-sm">
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
                                                    class="tw-cursor-pointer tw-mt-[0.5rem] tw-flex tw-gap-4 tw-justify-start tw-items-center md:tw-py-4 tw-py-2 md:tw-px-6 tw-px-3 tw-bg-secondary">
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
                                    <ConfirmDialog ref="subscriptionConfirm" />
                                </div>
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
                                                    <div class="tw-w-full tw-flex tw-justify-between tw-items-center">
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
                                                                {{ cartItem?.product?.purchase_options[0]?.quantity_text
                                                                }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <button type="button"
                                                                class="tw-border-0 tw-inline-flex tw-items-center tw-gap-1 tw-text-sm"
                                                                @click.prevent="removeSingleProduct(cartItem.id)">
                                                                <svg width="16" height="16" viewBox="0 0 16 16"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M12 4L4 12M4 4L12 12" stroke="black"
                                                                        stroke-width="2" stroke-linecap="round"
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
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M3.33398 8H12.6673" stroke="black"
                                                                    stroke-opacity="0.5" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </button>
                                                        <div
                                                            class="tw-w-10 tw-inline-flex tw-justify-center tw-items-center">
                                                            {{ cartItem.quantity }}
                                                        </div>
                                                        <button
                                                            class="border-0 tw-inline-flex tw-justify-center tw-items-center tw-w-6 tw-h-6 tw-bg-[#E8D6C7] rounded-pill"
                                                            @click.prevent="changeCartItem(cartItemIndex, '+')">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M8.00065 3.33331V12.6666M3.33398 7.99998H12.6673"
                                                                    stroke="black" stroke-opacity="0.5" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <h6 class="tw-text-base tw-font-medium tw-mb-0 tw-text-black">
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
                                                <small style="width: 100%;float: left;font-size: 13px;color: #565656;">
                                                   Offer applied to the first month only
                                                </small>
                                            </h6>
                                            <h6 class="tw-mb-0 tw-font-medium">
                                                -{{ currencyConvert(numberFormat($page?.props?.config?.app?.subscribe_discount_amount,
                                                0)) }}
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
                                                Free
                                            </h6>
                                        </div>
                                    </template>

                                    <template v-if="subscriptionInCart() == 0 && oneTimeInCart() == 1">
                                        <div class="checkout-meta-data">
                                            <div v-if="cart?.shipping?.exact" class="d-flex justify-content-between">
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
                                <hr>
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
                        <div>
                            <div>
                                <Link @click="closeCartModal()" v-if="cart.subscribe_items > 0 && cartItemsCount == plan.product_count"
                                      :href="route('subscribe')" as="button"
                                      class="tw-absolute tw-bottom-6 tw-left-3 tw-right-3 tw-bg-black tw-text-white !tw-z-[999999] tw-py-3">
                                    Checkout
                                </Link>
                                <Link @click="closeCartModal()" v-if="cart.subscribe_items > 0 && cartItemsCount != plan.product_count"
                                      :href="route('check.plan.cart')" as="button"
                                      class="tw-absolute tw-bottom-6 tw-left-3 tw-right-3 tw-bg-black tw-text-white !tw-z-[999999] tw-py-3">
                                    Checkout
                                </Link>
                                <Link v-else @click="closeCartModal()" :href="route('checkout')" as="button"
                                      class="tw-absolute tw-bottom-6 tw-left-3 tw-right-3 tw-bg-black tw-text-white !tw-z-[999999] tw-py-3">
                                    Checkout
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div @click="closeCartModal()"
            :class="cartModal ? 'tw-fixed tw-top-0 tw-end-0 tw-w-full tw-h-full tw-bg-[rgba(0,0,0,0.5)] tw-z-[99998]' : 'hidden'">
        </div>
    </sticky-menu>
    <!-- offcanvas -->
    <off-canvas :cartOffcanvas="cartOffcanvas" @status="toggleCanvas" :subscribePlanType="plan.id" :replaceItem="replaceItem" />
</template>

<script>
    import {
        Link
    } from "@inertiajs/inertia-vue3";
    import InstantSearch from "@/Libs/Search/SearchBox.vue";
    import StickyMenu from "@/Libs/Components/StickyMenu.vue";
    import TopMenu from './TopMenu.vue'
    import axios from 'axios';
    import { useToast } from "vue-toastification";
    import MenuList from "./MenuList.vue";
    import ConfirmDialog from "../../Components/Pranta/ConfirmDialog.vue";
    import OffCanvas from '../../Pages/Subscribe/OffCanvas.vue'
    export default {
        props:['cart'],
        components: {
            Link,
            InstantSearch,
            StickyMenu,
            TopMenu,
            MenuList,
            ConfirmDialog,
            OffCanvas
        },
        data() {
            return {
                cartOffcanvas: false,
                replaceItem: '',
                logoutForm: this.$inertia.form({}),
                isSearch: false,
                cartModal: false,
                menuList: false,
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
                    if (val == false) {
                        document.body.style.setProperty('overflow', 'unset', 'important');
                    } else {
                        document.body.style.setProperty('overflow', 'hidden', 'important');
                    }
                },
            },
            isSearch: {
                deep: true,
                handler(val, oldVal) {
                    if (val == true) {
                        document.body.style.setProperty('overflow', 'hidden', 'important');
                    } else {
                        document.body.style.setProperty('overflow', 'unset', 'important');
                    }
                },
            },
            menuList: {
                deep: true,
                handler(val, oldVal) {
                    if (val == true) {
                        document.body.style.setProperty('overflow', 'hidden', 'important');
                    } else {
                        document.body.style.setProperty('overflow', 'unset', 'important');
                    }
                },
            },
            '$page.props': {
                deep: true,
                handler(val, oldVal) {
                    this.getSubscriptionData();
                },
            },

        },
        mounted() {
            this.getSubscriptionData();
        },
        setup() {
            const toast = useToast()
            return { toast }
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
            closeMenuList() {
                this.menuList = !this.menuList;
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
            isClick() {
                if (this.isSearch) {
                    this.isSearch = false
                    alert('Hi')
                }
                else {
                    this.isSearch = true
                }
            },
            isRoute(name, params) {
                return this.$page.props.ziggy.url === this.route(name, params)
            },
            openCart() {
                if (!this.$page.props.user) {
                    this.toast("Your need to login for open cart.", {
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
                } else {
                    this.cartModal = true;
                }
            },
            closeCartModal() {
                this.cartModal = false;
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
                this.cartModal = false;
                setTimeout(() => {
                    this.$inertia.get(this.route('checkout'));
                }, 500);
                document.body.style.paddingRight = '0px !important';
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

                const ok = await this.$refs.subscriptionConfirm.show({
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
        computed: {
            user() {
                return this.$page.props.user
            },
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
                    //
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
    };
</script>

<style>
    /* body:has(.ll-mobile-menu) {
        overflow: hidden !important;
    } */

    .mbl_search_box {
        position: fixed;
        left: 0;
        width: 100%;
        background: #fff;
        top: 0;
        padding: 0px;
        height: 100vh;
        z-index: 999;
        box-shadow: 1px 1px 1px 1px rgb(0, 0, 0, 0.1);
    }

    .mbl_search_box .search-left-logo {
        position: absolute;
    }

    .mbl_search_box form .inner-addon {
        width: 100%;
    }

    .mbl_search_box .search_form .custom_search_box {
        text-align: start;
        padding-inline-start: 0px !important;
    }

    .mbl_search_box .form-control.form-control-sm {
        padding: 12px 0px !important;
    }

    .mbl_search_box .search_form {
        margin-top: 0px;
    }

    .mbl_search_box .search_close,
    .mbl_search_box .search-left-logo {
        position: static;
    }

    .mbl_search_box .btn-close {
        opacity: 1;
        background: url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M18 6L6 18M6 6L18 18' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
    }

    .header-right-m-shopping {
        margin-inline-end: 10px;
    }

    .dropdown-menu {
        min-width: 320px;
    }

    .dropdown-menu:before {
        right: 4px;
    }


    @media (max-width: 374px) {
        .dropdown-menu:before {
            right: 20%;
        }
    }

    @media (max-width: 767px) {
        .header {
            border: none;
        }
    }

    .offcanvas {
        top: 0;
        width: 648px;
        z-index: 1020 !important;
        right: 0;
    }

    @media (max-width: 767.98px) {
        #right-menu {
            display: none !important;
        }
    }

    .close {
        transform: translateY(-50%);
        width: 24px;
        cursor: pointer;
        position: relative;
    }

    .close span {
        position: absolute;
        width: 100%;
        height: 3px;
        left: 10%;
        top: 45%;
        background-color: white;
    }

    .first {
        transform: rotate(45deg);
    }

    .last {
        transform: rotate(-45deg);
    }

    .mobile-logo {
        /* position: absolute;
        margin: auto;
        right: 0;
        left: 0; */
        width: 100px;
    }

    .header-right-m-shopping img {
        margin-top: -7px;
    }

    .search_btn_mobile:focus-visible {
        outline: none;
    }

    .search_close_mob {
        position: absolute !important;
        right: 28px !important;
        z-index: 999;
        top: 12px;
    }

    .ll-dropdown {
        display: inline-flex;
    }

    .ll-dropdown .dropdown-menu:before {
        background: black;
        border: 1px solid black;
    }

    .ll-dropdown .dropdown-item.active,
    .ll-dropdown .dropdown-item:active,
    .ll-dropdown .dropdown-item:hover,
    .ll-dropdown .dropdown-item:focus {
        color: white !important;
    }

    .ll-dropdown .dropdown-toggle::after {
        display: none;
    }

    @media (max-width: 525px) {
        .search_btn_mobile {
            left: 55px;
            width: 24px;
        }
    }

    .cart-minus-btn {
        position: relative;
        top: -3px !important;
        font-size: 21px;
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
