<template>
    <section>
        <div class="container">
            <div class="ll-order-history tw-my-12">
                <h2 class="tw-text-[40px] tw-leading-[48px] tw-font-semibold tw-text-black tw-mb-6">
                    {{ __('Track Order') }}
                </h2>
                <div class="ll-order-history__wizard !tw-bg-secondary tw-border tw-border-[#E0E0E0]">
                    <div class="md:tw-p-8 tw-p-5 tw-border-b tw-border-[#E6E6E6]">
                        <div class="tw-flex lg:tw-flex-row tw-flex-col tw-gap-6 lg:tw-items-center tw-mb-8">
                            <div class="lg:tw-w-1/2 tw-w-full">
                                <h3 class="tw-text-2xl tw-mb-1.5 tw-text-black tw-font-semibold">
                                    #{{ order.order_no ?? order.id }} Status:
                                    <span class="tw-text-[#000]" v-html="order.html_status"></span>
                                </h3>
                                <p class="tw-text-base tw-font-medium tw-text-black">
                                    We received your order. it’s {{ removeTags(order.html_status) }}.
                                </p>
                            </div>
                            <div
                                class="lg:tw-w-1/2 tw-w-full lg:tw-grid tw-flex tw-flex-wrap tw-gap-6 lg:tw-grid-cols-5">
                                <div>
                                    <h4
                                        class="tw-text-base tw-text-center tw-font-medium tw-text-black tw-mb-1 tw-whitespace-nowrap">
                                        {{ order.formatted_created_at }}
                                    </h4>
                                    <p
                                        class="tw-text-sm tw-text-center tw-font-medium tw-text-opacity-70 tw-text-black tw-whitespace-nowrap">
                                        {{ __('Order Placed') }}
                                    </p>
                                </div>
                                <div>
                                    <h4
                                        class="tw-text-base tw-text-center tw-font-medium tw-text-black tw-mb-1 tw-whitespace-nowrap">
                                        {{ order.items.length }}
                                    </h4>
                                    <p
                                        class="tw-text-sm tw-text-center tw-font-medium tw-text-opacity-70 tw-text-black tw-whitespace-nowrap">
                                        {{ __('Total Items') }}
                                    </p>
                                </div>
                                <div>
                                    <h4
                                        class="tw-text-base tw-text-center tw-font-medium tw-text-black tw-mb-1 tw-whitespace-nowrap">
                                        <template v-if="order.shipping_cost > 0">
                                            {{ currencyConvert(order.shipping_cost) }}
                                        </template>
                                        <template v-else>
                                            {{ __('Free') }}
                                        </template>
                                    </h4>
                                    <p
                                        class="tw-text-sm tw-text-center tw-font-medium tw-text-opacity-70 tw-text-black tw-whitespace-nowrap">
                                        {{ __('Shipping') }}
                                    </p>
                                </div>
                                <div>
                                    <h4
                                        class="tw-text-base tw-text-center tw-font-medium tw-text-black tw-mb-1 tw-whitespace-nowrap">
                                        <template v-if="order.coupon?.discount_type == 1">
                                            {{ order.discount }}%
                                        </template>
                                        <template v-else>
                                            {{ currencyConvert(order.discount) }}
                                        </template>
                                    </h4>
                                    <p
                                        class="tw-text-sm tw-text-center tw-font-medium tw-text-opacity-70 tw-text-black tw-whitespace-nowrap">
                                        {{ __('Discount') }}
                                    </p>
                                </div>
                                <div>
                                    <h4
                                        class="tw-text-base tw-text-center tw-font-medium tw-text-black tw-mb-1 tw-whitespace-nowrap">
                                        {{ currencyConvert(order.gross_total) }}
                                    </h4>
                                    <p
                                        class="tw-text-sm tw-text-center tw-font-medium tw-text-opacity-70 tw-text-black tw-whitespace-nowrap">
                                        {{ __('Total Amount') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tw-flex tw-items-center tw-mx-[5%] tw-mb-8">
                            <div class="tw-inline-flex tw-relative tw-z-10">
                                <span class="tw-flex tw-justify-center tw-items-center tw-w-12 tw-h-12 tw-rounded-full"
                                      :class="orderPlaced ? 'tw-bg-[#000] tw-text-white' : 'tw-bg-[#CCCCCC]'">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 12L8.95 16.95L19.557 6.34299" stroke="currentColor" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="tw-flex-auto tw-h-3 -tw-ml-1 -tw-mr-1 tw-z-0"
                                 :class="orderProcessing ? 'tw-bg-[#000]' : orderHold || orderPending ? 'tw-bg-[#000]' : 'tw-bg-[#CCCCCC]'">
                            </div>
                            <div class="tw-inline-flex tw-relative tw-z-10" v-if="orderHold">
                                <span class="tw-flex tw-justify-center tw-items-center tw-w-12 tw-h-12 tw-rounded-full"
                                      :class="orderHold ? 'tw-bg-[#000] tw-text-white' : 'tw-bg-[#CCCCCC] tw-text-black'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                         viewBox="0 0 256 256">
                                        <path
                                            d="M200,32H160a16,16,0,0,0-16,16V208a16,16,0,0,0,16,16h40a16,16,0,0,0,16-16V48A16,16,0,0,0,200,32Zm0,176H160V48h40ZM96,32H56A16,16,0,0,0,40,48V208a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V48A16,16,0,0,0,96,32Zm0,176H56V48H96Z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                            <div class="tw-inline-flex tw-relative tw-z-10" v-else>
                                <span class="tw-flex tw-justify-center tw-items-center tw-w-12 tw-h-12 tw-rounded-full"
                                      :class="orderProcessing ? 'tw-bg-[#000] tw-text-white' : 'tw-bg-[#CCCCCC] tw-text-black'">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17158 10.8284C8.42143 10.0783 8.00001 9.06087 8.00001 8M3.63301 7.401L2.93301 15.801C2.78301 17.606 2.70701 18.508 3.01301 19.204C3.28088 19.8154 3.74504 20.3201 4.33201 20.638C5.00001 21 5.90501 21 7.71601 21H16.283C18.093 21 18.999 21 19.667 20.638C20.2543 20.3202 20.7189 19.8156 20.987 19.204C21.292 18.508 21.217 17.606 21.067 15.801L20.367 7.401C20.237 5.849 20.172 5.072 19.828 4.485C19.5253 3.96765 19.0746 3.55282 18.534 3.294C17.92 3 17.141 3 15.583 3H8.41601C6.85801 3 6.07901 3 5.46601 3.294C4.92515 3.55239 4.4741 3.96687 4.17101 4.484C3.82701 5.072 3.76201 5.849 3.63301 7.401Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="tw-flex-auto tw-h-3 -tw-ml-1 -tw-mr-1 tw-z-0"
                                 :class="orderInTransit ? 'tw-bg-[#000]' : 'tw-bg-[#CCCCCC]'">
                            </div>
                            <div class="tw-inline-flex tw-relative tw-z-10">
                                <span class="tw-flex tw-justify-center tw-items-center tw-w-12 tw-h-12 tw-rounded-full"
                                      :class="orderInTransit ? 'tw-bg-[#000] tw-text-white' : 'tw-bg-[#CCCCCC] tw-text-black'">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_607_542)">
                                            <path
                                                d="M16 1C16.2652 1 16.5196 1.10536 16.7071 1.29289C16.8946 1.48043 17 1.73478 17 2V3H22V9H19.981L22.727 16.544C22.9851 17.5322 22.8555 18.5818 22.3646 19.4774C21.8737 20.3731 21.0588 21.0471 20.0869 21.3612C19.115 21.6752 18.0597 21.6056 17.1375 21.1666C16.2153 20.7276 15.496 19.9524 15.127 19H10.874C10.6467 19.8777 10.1282 20.6521 9.40329 21.1966C8.6784 21.7411 7.79011 22.0233 6.88389 21.9971C5.97767 21.9708 5.10721 21.6376 4.41506 21.0521C3.72291 20.4665 3.25008 19.6633 3.074 18.774C2.74993 18.6047 2.47846 18.3498 2.28911 18.0371C2.09976 17.7243 1.99977 17.3656 2 17V7C2 6.73478 2.10536 6.48043 2.29289 6.29289C2.48043 6.10536 2.73478 6 3 6H10C10.2652 6 10.5196 6.10536 10.7071 6.29289C10.8946 6.48043 11 6.73478 11 7V12C11 12.2652 11.1054 12.5196 11.2929 12.7071C11.4804 12.8946 11.7348 13 12 13H14C14.2652 13 14.5196 12.8946 14.7071 12.7071C14.8946 12.5196 15 12.2652 15 12V3H12V1H16ZM7 16C6.46957 16 5.96086 16.2107 5.58579 16.5858C5.21071 16.9609 5 17.4696 5 18C5 18.5304 5.21071 19.0391 5.58579 19.4142C5.96086 19.7893 6.46957 20 7 20C7.53043 20 8.03914 19.7893 8.41421 19.4142C8.78929 19.0391 9 18.5304 9 18C9 17.4696 8.78929 16.9609 8.41421 16.5858C8.03914 16.2107 7.53043 16 7 16ZM19 15.999C18.5747 15.9991 18.1605 16.1348 17.8176 16.3864C17.4746 16.638 17.2208 16.9923 17.093 17.398C16.9652 17.8037 16.9701 18.2395 17.1069 18.6422C17.2436 19.0449 17.5052 19.3936 17.8537 19.6375C18.2021 19.8814 18.6192 20.0078 19.0444 19.9985C19.4696 19.9892 19.8808 19.8446 20.2182 19.5856C20.5556 19.3267 20.8017 18.9669 20.9207 18.5586C21.0397 18.1503 21.0255 17.7147 20.88 17.315L20.864 17.271C20.7173 16.8962 20.4609 16.5743 20.1283 16.3476C19.7958 16.1208 19.4025 15.9997 19 16V15.999ZM17.853 9H17V12C17 12.7956 16.6839 13.5587 16.1213 14.1213C15.5587 14.6839 14.7956 15 14 15H12C11.2044 15 10.4413 14.6839 9.87868 14.1213C9.31607 13.5587 9 12.7956 9 12H4V15.354C4.48084 14.8095 5.10081 14.4062 5.79345 14.1872C6.48608 13.9682 7.22524 13.9419 7.93169 14.1111C8.63813 14.2802 9.28522 14.6385 9.80355 15.1474C10.3219 15.6564 10.6919 16.2968 10.874 17H15.126C15.378 16.0252 15.9881 15.1812 16.8348 14.6362C17.6814 14.0913 18.7024 13.8856 19.694 14.06L17.853 9ZM9 8H4V10H9V8ZM20 5H17V7H20V5Z"
                                                fill="currentColor"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_607_542">
                                                <rect width="24" height="24" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                            </div>
                            <div class="tw-flex-auto tw-h-3 -tw-ml-1 -tw-mr-1 tw-z-0"
                                 :class="orderCompleted ? 'tw-bg-[#000]' : orderCanceled ? 'tw-bg-red-500' : 'tw-bg-[#CCCCCC]'">
                            </div>
                            <!-- order canceled -->
                            <div class="tw-inline-flex tw-relative tw-z-10" v-if="orderCanceled">
                                <span class="tw-flex tw-justify-center tw-items-center tw-w-12 tw-h-12 tw-rounded-full"
                                      :class="orderCanceled ? 'tw-bg-red-500 tw-text-white' : 'tw-bg-[#CCCCCC] tw-text-black'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                         viewBox="0 0 256 256">
                                        <path
                                            d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                            <!-- order completed -->
                            <div class="tw-inline-flex tw-relative tw-z-10" v-else>
                                <span class="tw-flex tw-justify-center tw-items-center tw-w-12 tw-h-12 tw-rounded-full"
                                      :class="orderCompleted ? 'tw-bg-[#000] tw-text-white' : 'tw-bg-[#CCCCCC] tw-text-black'">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.5 7.27801L12 12M12 12L3.5 7.27801M12 12V21.5M21 16.059V7.94201C21 7.59901 21 7.42801 20.95 7.27501C20.9051 7.13974 20.8318 7.01564 20.735 6.91101C20.626 6.79201 20.477 6.70901 20.177 6.54301L12.777 2.43201C12.493 2.27401 12.352 2.19501 12.202 2.16501C12.0691 2.13766 11.9319 2.13766 11.799 2.16501C11.649 2.19501 11.507 2.27501 11.223 2.43201L3.823 6.54201C3.523 6.70901 3.373 6.79201 3.265 6.91101C3.16821 7.01564 3.09491 7.13974 3.05 7.27501C3 7.42801 3 7.59901 3 7.94201V16.059C3 16.401 3 16.573 3.05 16.725C3.09491 16.8603 3.16821 16.9844 3.265 17.089C3.374 17.208 3.523 17.291 3.823 17.457L11.223 21.568C11.507 21.726 11.648 21.805 11.799 21.836C11.932 21.863 12.069 21.863 12.201 21.836C12.351 21.805 12.493 21.726 12.777 21.568L20.177 17.458C20.477 17.291 20.627 17.208 20.735 17.089C20.8318 16.9844 20.9051 16.8603 20.95 16.725C21 16.573 21 16.401 21 16.059Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path d="M16.5 9.5L7.5 4.5" stroke="currentColor" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="lg:tw-flex tw-justify-between tw-items-center">
                            <div>
                                <h3 class="tw-text-lg tw-font-semibold tw-text-black tw-mb-2">
                                    {{ __('Ships To') }}
                                </h3>
                                <p class="tw-text-base tw-text-black tw-text-opacity-70 tw-max-w-[392px] mb-2">
                                    {{ shipping?.name }}
                                </p>
                                <p class="tw-text-base tw-text-black tw-text-opacity-70 tw-max-w-[392px]">
                                    <span>
                                        {{ shipping?.line1 }}
                                    </span>
                                    <span v-if="shipping?.line2">
                                        , {{ shipping?.line2 }}
                                    </span>
                                    <span v-if="shipping?.city">
                                        , {{ shipping?.city }}
                                    </span>
                                    <span v-if="shipping?.state">
                                        , {{ shipping?.state }}
                                    </span>
                                    <span v-if="shipping?.postal_code">
                                        , {{ shipping?.postal_code }}
                                    </span>
                                    <span v-if="shipping?.country">
                                        , {{ shipping?.country }}
                                    </span>
                                </p>
                            </div>
                            <div v-if="order.status == 'in_transit'">
                                <h3 class="tw-text-lg tw-font-semibold tw-text-black tw-mb-2">
                                    {{ __('Courier Tracking Details') }}
                                </h3>
                                <p class="tw-text-base tw-text-black tw-text-opacity-70 tw-max-w-[392px] mb-2">
                                    {{ __('Tracking No') }} : {{ order.tracking_no }}
                                </p>
                                <a :href="order.tracking_url" target="_blank"
                                   class="tw-text-base tw-no-underline tw-text-black tw-text-opacity-70 tw-max-w-[392px] mb-2">
                                    {{ __('Tracking Url') }} : <span class="tw-text-blue-500">{{
                                        order.tracking_url
                                    }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="md:tw-p-8 tw-p-5 tw-w-full tw-overflow-auto">
                        <table class="tw-w-[550px] md:tw-w-full">
                            <thead>
                            <tr>
                                <th scope="col" class="tw-py-3 tw-px-12 md:tw-px-0 tw-whitespace-nowrap">
                                    {{ __('Products') }}
                                </th>
                                <th scope="col" class="tw-py-3 tw-px-12 md:tw-px-0 tw-whitespace-nowrap">
                                    {{ __('Price') }}
                                </th>
                                <th scope="col" class="tw-py-3 tw-px-12 md:tw-px-0 tw-whitespace-nowrap">
                                    {{ __('Quantity') }}
                                </th>
                                <th scope="col"
                                    class="tw-py-3 tw-px-12 md:tw-px-0 tw-text-right tw-whitespace-nowrap">
                                    {{ __('Subtotal') }}
                                </th>
                                <th scope="col"
                                    class="tw-py-3 tw-px-12 md:tw-px-0 tw-text-right tw-whitespace-nowrap">
                                    {{ __('Rating') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in order.items" :key="index"
                                class="tw-border-t tw-border-[#E6E6E6]">
                                <td class="tw-py-3 tw-px-12 md:tw-px-0 tw-whitespace-nowrap" width="60%">
                                    <Link
                                        :href="route('product', { productType: item.product?.type, brandSlug: item.product?.brand?.slug, productSlug: item.product?.slug })"
                                        class="tw-flex tw-gap-4 tw-items-center !tw-no-underline">
                                        <img
                                            :src="item.product?.image?.url ? item.product?.image?.url : item.product_image"
                                            alt="" class="tw-w-[50px] tw-h-auto tw-object-cover">
                                        <div>
                                            <h3 class="tw-text-base tw-font-medium tw-text-black tw-mb-2">
                                                {{ item.product_title }}
                                            </h3>
                                            <p
                                                class="tw-text-sm tw-font-medium !tw-no-underline tw-text-black tw-text-opacity-60">
                                                {{ item.brand_name }}
                                            </p>
                                        </div>
                                    </Link>
                                </td>
                                <td
                                    class="tw-py-3 tw-px-12 md:tw-px-0 tw-whitespace-nowrap tw-text-base tw-text-black tw-font-medium">
                                    {{ currencyConvert(item.amount) }}
                                </td>
                                <td
                                    class="tw-py-3 tw-px-12 md:tw-px-0 tw-whitespace-nowrap tw-text-base tw-text-black tw-font-medium">
                                    {{ item.quantity }}
                                </td>
                                <td
                                    class="tw-py-3 tw-px-12 md:tw-px-0 tw-text-right tw-whitespace-nowrap tw-text-base tw-text-black tw-font-medium">
                                    {{ currencyConvert(item.amount) }}
                                </td>
                                <td
                                    class="tw-py-3 tw-px-12 md:tw-px-0 tw-text-right tw-whitespace-nowrap tw-text-base tw-text-black tw-font-medium">
                                    <template v-if="item.product?.reviewed">
                                        <button type="button" disabled
                                                class="!tw-no-underline !tw-text-base tw-font-semibold tw-font-TT-Norms !tw-capitalize tw-py-2.5 tw-px-[54px] tw-bg-white tw-text-black">
                                            {{ __('Reviewed') }}
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button @click.prevent="openReviewModal(item.product)" type="button"
                                                class="!tw-no-underline !tw-text-base tw-font-semibold tw-font-TT-Norms !tw-capitalize tw-py-2.5 tw-px-6 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                                            {{ __('WRITE A REVIEW') }}
                                        </button>
                                    </template>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <collection title="Great Ideas For Future Deliveries ScentQ Capsule Collection" type="capsule"/>
    <collection title="Scentq Curated Collection" type="curated"/>
    <recommendation title="Recommended For You"/>
    <!-- <ParallaxCallToAction title="Find Your Perfect Scent" :button_link="route('new.arrivals')" button_text="New Arrivals" /> -->

    <!-- review set modal  -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content !tw-mb-24 lg:!tw-mb-0 !tw-bg-secondary">
                <div @click="showModal = false" class="modal-header border-0 p-0">
                    <button type="button" class="btn-close p-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="container">
                        <div>
                            <h3 class="modal-title">
                                Review your product
                            </h3>
                            <p class="modal-description">
                                Tell us what you thought of this product!
                            </p>
                        </div>

                        <div class="review-item-infograph">
                            <div>
                                <img :src="product?.image?.url" style="width: 80px; height: 80px"
                                     :alt="product?.title"/>
                            </div>

                            <div>
                                <p>{{ product?.brand?.name }}</p>
                                <small>{{ product?.title }}</small>
                            </div>
                            <div>
                                <div class="product-rating">
                                    <star-rating active-color="#FF8A00" v-model:rating="reviewForm.rate"></star-rating>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <i class="fas fa-star rate-star me-1 cursor-pointer" v-for="index in 5" :key="index"
                                       :class="{
                                            'text-warning':
                                                index <=
                                                reviewForm.rate,
                                            'text-secondary':
                                                index >
                                                reviewForm.rate
                                        }" @click="
    reviewForm.rate = index
    "></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4" v-for="(e, i) in $page.props.errors" :key="i">
                            <div class="text-danger">
                                {{ e }}
                            </div>
                        </div>
                        <!-- <div class="mt-4">
                            <h5>{{ __("Add a few helpful tags!") }}</h5>

                            <div class="mt-3" v-for="(taxonomy,
                                taxonomyIndex) in taxonomies" :key="taxonomyIndex">
                                <template v-if="taxonomy.terms.length">
                                    <p class="mt-0 mb-2 text-uppercase">
                                        👍 {{ taxonomy.name }}
                                    </p>
                                    <div class="d-flex review-term-input-wrapper">
                                        <div v-for="(term,
                                            termIndex) in taxonomy.terms" :key="termIndex" class="review-term-input">
                                            <input type="checkbox" :name="'taxonomy_' +
                                                taxonomy.id +
                                                '[]'
                                                " :id="'term-' + term.id" :value="term.id" class="d-none" v-model="reviewForm
        .terms
        " />
                                            <label :for="'term-' + term.id" class="review-button-tagr">{{
                                                term.name
                                            }}</label>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div> -->

                        <div class="mt-4">
                            <h5>Tell us some specific details</h5>

                            <form class="mt-3 review-form">
                                <div class="mb-3">
                                    <input type="text"
                                           class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                           :class="{
                                        'is-invalid': errors.title
                                    }" placeholder="Title" required v-model="reviewForm.title
    "/>
                                    <div class="invalid-feedback" v-if="errors.title">
                                        {{ errors.title }}
                                    </div>
                                </div>

                                <div>
                                    <textarea class="form-control"
                                              placeholder="Example: The notes in the scent were exactly what I had imagined. It smelled just as spicy as I thought it would, I really love it and gets tons of compliments!"
                                              style="height: 150px" v-model="reviewForm.content
                                            "></textarea>
                                </div>

                                <button class="mt-4 choose-btn btn btn-black py-3 cathrine-monthly-btn"
                                        @click.prevent="submitReview" :disabled="reviewForm.processing
                                        ">
                                    Submit review
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserPage from "@/Layouts/UserPage.vue";
import Collection from "@/Sections/Common/Collection.vue";
import Recommendation from "@/Sections/Common/Recommendation.vue";
import ParallaxCallToAction from "@/Sections/Common/ParallaxCallToAction.vue";
import {Link, useForm} from "@inertiajs/inertia-vue3";
import StarRating from 'vue-star-rating'

export default {
    props: {
        errors: Object,
        order: Object,
        shipping: Object,
        taxonomies: Object,
    },
    layout: UserPage,
    components: {
        Collection,
        Recommendation,
        ParallaxCallToAction,
        Link,
        StarRating
    },
    methods: {
        submitReview() {
            this.reviewForm.post(this.route("review.store"), {
                preserveScroll: true,
                onSuccess: () => {
                    if (this.modal) {
                        this.modal.hide();
                    }
                },
                onError: () => {
                    this.modal.show();
                }
            });
        },
        openReviewModal(product) {
            this.reviewForm.product_id = product?.id;
            this.product = product;

            if (this.modal) {
                this.modal.hide();
            }
            this.modal = new window.bootstrap.Modal("#reviewModal");
            this.modal.show();
        },
        monthName(monthNumber) {
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            return months[monthNumber - 1]
        },
        removeTags(str) {
            if ((str === null) || (str === ''))
                return false;
            else
                str = str.toString();
            // Regular expression to identify HTML tags in
            // the input string. Replacing the identified
            // HTML tag with a null string.
            return str.replace(/(<([^>]+)>)/ig, '');
        },
        orderStatus() {
            let status = this.order.status;
            this.orderPlaced = true;

            if (status == 'processing') {
                this.orderProcessing = true;
            } else if (status == 'hold') {
                this.orderHold = true;
            } else if (status == 'in_transit') {
                this.orderProcessing = true;
                this.orderInTransit = true;
            } else if (status == 'completed') {
                this.orderProcessing = true;
                this.orderInTransit = true;
                this.orderCompleted = true;
            } else if (status == 'canceled') {
                this.orderProcessing = true;
                this.orderInTransit = true;
                this.orderCanceled = true;
            } else {
                this.orderPending = true;
            }
        },
        setScrollHeight(height) {
            window.scrollTo({
                top: height,
                behavior: 'smooth' // You can change this to 'auto' for instant scrolling
            });
        }
    },
    mounted() {
        const searchParams = window.location.search.substring(1).split('&');
        if (searchParams.includes('review=true')) {
            setTimeout(() => {
                this.setScrollHeight(500);
            }, 100);
        }
        this.orderStatus();
    },
    data() {
        return {
            product: null,
            modal: null,
            orderPlaced: false,
            orderPending: false,
            orderProcessing: false,
            orderHold: false,
            orderInTransit: false,
            orderCompleted: false,
            orderCanceled: false,
            defaultOrderStatus: [
                "no_entry",
                "pending",
                "processing",
                "in_transit",
                "completed",
                "hold",
                "canceled",
            ],
            reviewForm: useForm({
                product_id: null,
                title: null,
                content: null,
                rate: 1,
                terms: []
            })
        }
    },
};
</script>

<style lang="scss">
@import "../../../scss/productDetails.scss";
@import "../../../scss/tracking.scss";

/* .form-control {
    padding: 5px 10px !important;
} */
.carousel__next,
.carousel__prev {
    display: block !important;
}

.slide-enter-active {
    transition: transform 0.5s;
}

.product-img-box img {
    border: 0px !important;
}

.slide-enter {
    transform: translateX(100%);
}

.slide-leave-active {
    transition: transform 0.5s;
}

.slide-leave-to {
    transform: translateX(-100%);
}

.subscriptions-wrapper .product-quantity-price .img-thumbnail {
    width: 80px;
    height: 80px;
    border: 0;
}

@media (max-width: 425px) {
    .subscriptions-wrapper .product-quantity-price .img-thumbnail {
        width: 56px;
        height: 56px;
    }
}

.accordion-button:after {
    background-image: url("../../images/svg/Ico_Plus_Not_Circle.svg");
}

.accordion-button:not(.collapsed):after {
    background-image: url("../../images/svg/Ico_Minus.svg");
    transform: rotate(0deg) !important;
}

.cart-custom-btn {
    background: transparent;
    color: #000;
}

.cart-custom-btn:hover {
    background: transparent;
}

.progress-data {
    position: fixed;
}

.single-perfume-type-box.active {
    background: #f5f5f5 !important;
}

#disclaimerModal .modal-body p span,
#disclaimerModal .modal-body p,
#disclaimerModal .modal-body {
    font-family: "TT Norms Pro", sans-serif !important;
    font-size: 20px !important;
}

#disclaimerModal .modal-body p span strong {
    font-family: "TT Norms Pro", sans-serif !important;
    font-size: 20px !important;
}

a.pagination-page-link:not(:first-child):not(:last-child) {
    border-radius: 50%;
    width: 25px;
    height: 25px;
    text-align: center;
    display: block;
    color: #000;
}

a.pagination-page-link {
    color: #000;
}

.pagination-page-link-active {
    background-color: #000 !important;
    pointer-events: none;
}

.single-trending-note .img-thumbnail img {
    object-fit: contain;
}

.collection-section {
    margin-bottom: 35px;
}

.collection-section,
.product-feedback {
    margin-top: 0px;
}

@media (min-width: 992px) {
    .product-detail-navbar {
        position: sticky;
        top: 0;
        left: 0;
        right: 0;
        transition: top 0.3s;
        background: #F9F9F9;
        z-index: 9;
    }
}

/* .ll-breadcrumbs-sec .container {
max-width: 1320px;
padding: 0px;
} */
.breadcrumb-tab-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
}

.breadcrumb-tab-wrap .breadcrumb-wrap p {
    margin-bottom: 0px;
    padding: 16px 0px;
}

.tabs {
    display: flex;
}

.tabs ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 16px;
}

@media (max-width: 991px) {
    .tab-wrap {
        display: none;
    }
}

.tabs li a {
    cursor: pointer;
    padding: 16px 0px 14px;
    border-bottom: 2px solid transparent;
    font-family: "TT Norms Pro", sans-serif;
    text-decoration: none;
    font-style: normal;
    font-weight: 500;
    font-size: 15px;
    display: inline-flex;
    line-height: 24px;
    color: #666666;
}

section {
    scroll-behavior: smooth !important;
}

.tabs li.active a {
    color: #000000;
    border-bottom-color: #000000;
}

.customRateClass {
    border-radius: 4px;
    border-color: blue;
}

@media (max-width: 767px) {
    .feedback-taxonomy-images {
        display: none;
    }

    .prodImage_thumbs {
        justify-content: start;
    }

    .main-notes__intro {
        width: 100%;
        margin: 0px;
    }

    .peoples-Prefer.collection-section,
    .main-notes.collection-section,
    section.review-summery,
    section.product-ratings,
    section.product-feedback {
        padding: 12px;
    }

    .ll-btn {
        font-family: "TT Norms Pro", sans-serif !important;
        width: max-content !important;
        font-size: 12px !important;
        padding: 6px 8px !important;
    }

    .product-quantity-price .btn-add-to-queue {
        margin-inline-start: auto !important;
    }

    .subscriptions-wrapper .product-quantity-price {
        padding: 8px 0px !important;
    }

    .subscriptions-wrapper .product-quantity-price .quantity-price-text h6 {
        display: flex !important;
        gap: 8px;
    }

    .subscriptions-wrapper .product-quantity-price .quantity-price-text span {
        font-family: "TT Norms Pro", sans-serif !important;
        font-size: 14px !important;
    }

    .product-quantity-price .btn-add-to-queue img {
        display: none;
    }

    .subscriptions-wrapper .product-quantity-price {
        gap: 8px;
    }
}

@media (max-width: 767px) {
    .product-details-content .product-title {
        font-size: 24px !important;
        line-height: 32px !important;
    }

    .product-details-content .product_brand__name {
        font-size: 18px;
        line-height: 28px;
    }

    .product-ratings h2 {
        font-size: 24px;
        line-height: 32px;
    }
}

.ad-text {
    font-size: 16px !important;
    line-height: 24px !important;
    padding: 16px 0px !important;
    display: block !important;
}

@media (max-width: 525px) {
    .ad-text {
        font-size: 14px !important;
        line-height: 16px !important;
    }
}

@media (max-width: 425px) {
    .ad-text {
        font-size: 12px !important;
        line-height: 16px !important;
    }
}

@media (max-width: 374px) {
    .ad-text {
        font-size: 10px !important;
        line-height: 16px !important;
    }
}
</style>
