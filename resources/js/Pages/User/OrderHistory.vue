<template>
    <section class="profile profile-content">
        <div class="container-xl">
            <div class="row">
                <!-- flex-row-reverse -->
                <div class="col-md-5 col-xl-4 !tw-pr-4 !tw-md-pr-0">
                    <sidebar />
                </div>

                <div class="col-md-6 ms-lg-5 order-first order-md-2">
                    <div class="profile-contant">
                        <h4>
                            {{ __('Order tracking & history') }}
                        </h4>
                        <div class="anchor-tab">
                            <Link :href="route('order', 'subscription')"
                                :class="{ active: isRoute('order', 'subscription') }">{{ __('Subscription') }}
                            </Link>
                            <Link :href="route('order')" :class="{ active: isRoute('order') }">{{ __('Orders') }}
                            </Link>
                        </div>
                        <template v-if="isRoute('order', 'subscription')">
                            <div class="tw-mt-4">
                                <template v-if="order_creating">

                                    <div class="tw-text-lg tw-text-center tw-mt-12">
                                        {{ __('Your Order Is Creating!') }}
                                    </div>
                                    <div class="tw-flex tw-justify-center">
                                        <div class="progress-container" :class="'progress-' + type">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                                fill="currentColor" viewBox="0 0 256 256">
                                                <path
                                                    d="M230,128a102,102,0,0,1-204,0c0-40.18,23.35-76.86,59.5-93.45a6,6,0,0,1,5,10.9C58.61,60.09,38,92.49,38,128a90,90,0,0,0,180,0c0-35.51-20.61-67.91-52.5-82.55a6,6,0,0,1,5-10.9C206.65,51.14,230,87.82,230,128Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                </template>
                                <template v-else>
                                    <template v-if="subscription_orders.data.length > 0">
                                        <div v-for="(order, index) in subscription_orders.data" :key="index"
                                            class="tw-font-TT-Norms tw-p-6 tw-bg-secondary tw-flex tw-flex-col tw-gap-4 tw-my-6">
                                            <div
                                                class="tw-flex tw-flex-wrap tw-gap-4 tw-justify-between tw-items-start">
                                                <div class="tw-flex tw-flex-col tw-flex-shrink tw-gap-4">
                                                    <div class="tw-flex tw-gap-3 tw-items-center">
                                                        <p class="order-id !tw-pb-0 tw-mb-0">
                                                            #{{ order.order_no }}
                                                        </p>
                                                        <template
                                                            v-if="order.status === 'processing' || order.status === 'pending'">
                                                            <span
                                                                class="tw-bg-white tw-shadow-[0px_2px_3px_rgba(0,0,0,0.08)] tw-inline-flex tw-font-TT-Norms tw-tracking-[-0.01em] tw-py-1 tw-px-3 tw-text-sm tw-font-bold tw-text-black/70">
                                                                {{__('Processing')}}
                                                            </span>
                                                        </template>
                                                        <template v-else>
                                                            <span
                                                                class="tw-bg-white tw-shadow-[0px_2px_3px_rgba(0,0,0,0.08)] tw-inline-flex tw-font-TT-Norms tw-tracking-[-0.01em] tw-py-1 tw-px-3 tw-text-sm tw-font-bold !tw-capitalize tw-text-black/70">
                                                                {{ removeUnderscoresAndCapitalize(order.status) }}
                                                            </span>
                                                        </template>
                                                    </div>
                                                    <p
                                                        class="!tw-mb-0 !tw-pb-0 tw-font-medium tw-flex tw-items-center tw-gap-1.5 tw-text-black">
                                                        <span class="tw-text-lg">
                                                            {{ currencyConvert(order.gross_total)
                                                            }}
                                                        </span>
                                                        <span>/</span>
                                                        <span class="tw-text-base tw-text-black/70">
                                                            {{ order?.items?.length }} Fragrance
                                                        </span>
                                                    </p>
                                                    <p class="!tw-mb-0 tw-text-sm !tw-pb-0 tw-text-black">
                                                        <span class="tw-text-black/70">
                                                            {{__('Order placed')}}:
                                                        </span>
                                                        <span class="tw-font-medium">
                                                            {{ order.formatted_created_at }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="tw-text-base tw-flex tw-gap-6 tw-items-center">
                                                    <Link :href="route('order.track', order.order_no ?? order.id)"
                                                        class="tw-inline-block tw-underline !tw-text-black/80 tw-font-medium">
                                                    {{__('View Detail')}}
                                                    </Link>
                                                    <template v-if="order.status === 'completed'">
                                                        <template v-if="order.reviewed">
                                                            <div
                                                                class="tw-inline-block !tw-text-gray-500 tw-font-semibold">
                                                                {{ __('Reviewed') }}
                                                            </div>
                                                        </template>
                                                        <template v-else>
                                                            <Link
                                                                :href="route('order.track', order.order_no ?? order.id)"
                                                                :data="{ review: true }"
                                                                class="tw-inline-block tw-underline !tw-text-black tw-font-semibold">
                                                            {{ __('Write a Review') }}
                                                            </Link>
                                                        </template>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="">
                                            <h3 class="">
                                                {{ __('No subscription product history yet!') }}
                                            </h3>
                                            <p>
                                                {{ __('Activate your subscription and add to your queue — you’ll be able to see your monthly fragrances here.') }}
                                            </p>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </template>
                        <template v-else>
                            <div>
                                <template v-if="orders.data.length > 0">
                                    <div v-for="(order, index) in orders.data" :key="index"
                                        class="tw-font-TT-Norms tw-p-6 tw-bg-secondary tw-flex tw-flex-col tw-gap-4 tw-my-6">
                                        <div class="tw-flex tw-flex-wrap tw-gap-4 tw-justify-between tw-items-start">
                                            <div class="tw-flex tw-flex-col tw-flex-shrink tw-gap-4">
                                                <div class="tw-flex tw-gap-3 tw-items-center">
                                                    <p class="order-id !tw-pb-0 tw-mb-0">
                                                        #{{ order.order_no }}
                                                    </p>
                                                    <template
                                                        v-if="order.status === 'processing' || order.status === 'pending'">
                                                        <span
                                                            class="tw-bg-white tw-shadow-[0px_2px_3px_rgba(0,0,0,0.08)] tw-inline-flex tw-font-TT-Norms tw-tracking-[-0.01em] tw-py-1 tw-px-3 tw-text-sm tw-font-bold tw-text-black/70">
                                                            {{ __('Processing') }}
                                                        </span>
                                                    </template>
                                                    <template v-else>
                                                        <span
                                                            class="tw-bg-white tw-shadow-[0px_2px_3px_rgba(0,0,0,0.08)] tw-inline-flex tw-font-TT-Norms tw-tracking-[-0.01em] tw-py-1 tw-px-3 tw-text-sm tw-font-bold !tw-capitalize tw-text-black/70">
                                                            {{ removeUnderscoresAndCapitalize(order.status) }}
                                                        </span>
                                                    </template>
                                                </div>
                                                <p
                                                    class="!tw-mb-0 !tw-pb-0 tw-font-medium tw-flex tw-items-center tw-gap-1.5 tw-text-black">
                                                    <span class="tw-text-lg">
                                                        {{ currencyConvert(order.gross_total)
                                                        }}
                                                    </span>
                                                    <span>/</span>
                                                    <span class="tw-text-base tw-text-black/70">
                                                        {{ order?.items?.length }} Fragrance
                                                    </span>
                                                </p>
                                                <p class="!tw-mb-0 tw-text-sm !tw-pb-0 tw-text-black">
                                                    <span class="tw-text-black/70">
                                                        {{ __('Order placed') }}:
                                                    </span>
                                                    <span class="tw-font-medium">
                                                        {{ order.formatted_created_at }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="tw-text-base tw-flex tw-gap-6 tw-items-center">
                                                <Link :href="route('order.track', order.order_no ?? order.id)"
                                                    class="tw-inline-block tw-underline !tw-text-black/80 tw-font-medium">
                                                {{__('View Detail')}}
                                                </Link>
                                                <template v-if="order.status === 'completed'">
                                                    <template v-if="order.reviewed">
                                                        <div class="tw-inline-block !tw-text-gray-500 tw-font-semibold">
                                                            {{ _('Reviewed') }}
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <Link :href="route('order.track', order.order_no ?? order.id)"
                                                            :data="{ review: true }"
                                                            class="tw-inline-block tw-underline !tw-text-black tw-font-semibold">
                                                        {{ __('Write a Review') }}
                                                        </Link>
                                                    </template>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="card-body">
                                        <h3 class="">
                                            {{ __('Your future purchases will live here') }}
                                        </h3>
                                        <p>
                                            {{ __('Once your first delivery has shipped, the items you’ve purchased will show up here.') }}
                                        </p>
                                        <Link :href="route('new.arrivals')" class="">
                                        <button type="button"
                                            class="tw-mt-2 btn btn-black !tw-text-xs btn-lg text-center">
                                            {{ __('Browse new arrivals') }}
                                        </button>
                                        </Link>
                                    </div>
                                </template>
                                <Pagination :links="orders.links" />
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Empty order product  -->
    <div class="modal fade" id="emptyOrderModal" tabindex="-1" aria-labelledby="emptyOrderModalLabel"
        aria-hidden="true">
        <search-client index="products">
            <div class="modal-dialog modal-full modal-dialog-centered">
                <div class="modal-content !tw-p-3 md:!tw-p-6 !tw-mb-24 lg:!tw-mb-0 !tw-bg-white">
                    <div class="modal-header tw-flex tw-gap-6 tw-justify-between tw-items-center border-0 p-0">
                            <h3 class="tw-text-base md:tw-text-2xl !tw-font-bold">
                                Choose your <span class="tw-capitalize">{{ product_add_month }}</span> fragrance
                            </h3>
                            <button type="button" class="btn-close p-0" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="md:tw-flex !tw-justify-between !tw-items-center">

                        <div>
                            <div class="tw-relative tw-mb-6">
                                <ais-configure :hits-per-page.camel="5" :distinct="true" />
                                <ais-search-box>
                                    <template v-slot="{ currentRefinement, isSearchStalled, refine }">
                                        <div
                                            class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-pl-3.5 tw-pointer-events-none">
                                            <img src="/images/MagnifyingGlass2.svg" alt="MagnifyingGlass2">
                                        </div>
                                        <input @input="refine($event.currentTarget.value)" v-bind="inputAttrs"
                                            type="text"
                                            class="tw-bg-white tw-border-b focus:tw-outline-none tw-border-gold-50 tw-text-gray-900 tw-text-sm  tw-block tw-w-full tw-pl-10 tw-p-3"
                                            placeholder="Search">
                                    </template>
                                </ais-search-box>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body p-0">
                        <div class="">
                            <div class="mt-3 row g-3 g-md-4 justify-content-center">
                                <div class="">
                                    <ais-hits>
                                        <template v-slot="{ items, sendEvent }">
                                            <div class="row g-2" v-if="items.length > 0">
                                                <div class="col-6 col-sm-3 col-md-4"
                                                    v-for="(product, productIndex) in items" :key="productIndex">
                                                    <BigProduct @close-modal="closeModal" from="order"
                                                        :month="product_add_month" :product="product" />
                                                </div>
                                            </div>
                                            <template v-else>
                                                <Products :filter="{ bestSelling: true }" @close-modal="closeModal"
                                                    :month="product_add_month" :year="year" from="order"
                                                    :load-more="load_more" />
                                            </template>
                                        </template>
                                    </ais-hits>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </search-client>
    </div>
</template>

<script>
    import { Link } from "@inertiajs/inertia-vue3"
    import UserPage from "@/Layouts/UserPage.vue";
    import Sidebar from "../../Layouts/Partials/Sidebar.vue"
    import Pagination from "@/Components/Pagination.vue";
    import SubscriptionDetails from "@/Layouts/Partials/SubscriptionDetails.vue";
    import Progress from "@/Libs/Components/ProgressBar.vue";

    import SearchClient from "@/Libs/Search/SearchClient.vue";
    import algoliasearch from "algoliasearch/lite";
    import {
        AisInstantSearch,
        AisSearchBox,
        AisHits,
    } from 'vue-instantsearch/vue3/es';
    import Products from "@/Libs/Components/ProductsForMyQueuePage.vue";
    import BigProduct from '@/Libs/Components/Products/BigProductForMyQueuePage.vue'
    export default {
        components: {
            UserPage,
            Link,
            Sidebar,
            Pagination,
            SubscriptionDetails,
            Progress,
            SearchClient,
            algoliasearch,
            AisInstantSearch,
            AisSearchBox,
            AisHits,
            Products,
            BigProduct
        },
        props: {
            orders: Object,
            subscription_orders: Object,
            type: String,
            year: String,
        },
        data() {
            return {
                order_creating: false,
                showEmptyOrderModal: false,
                product_add_month: ''
            }
        },
        watch: {
            subscription_orders: {
                deep: true,
                handler(val, oldVal) {
                    if (this.getSearchParams('order')) {
                        this.order_creating = true;
                    } else {
                        this.order_creating = false;
                    }
                },
            },
            order_creating: {
                deep: true,
                handler(val, oldVal) {
                    setTimeout(() => {
                        this.order_creating = false;
                    }, 6000);
                },
            }
        },
        created() {
            this.product_add_month = this.getCurrentMonthName();
        },
        mounted() {
            if (this.getSearchParams('order')) {
                this.order_creating = true;
            }
            if (this.getSearchParams('show_modal')) {

                if (this.getSearchParams('show_modal') == 'show_true') {
                    this.emptyOrderModal();
                }
            }
            // this.product_add_month = this.getCurrentMonthName();
            setTimeout(() => {
                this.order_creating = false;
            }, 6000);
        },
        methods: {
            removeUnderscoresAndCapitalize(inputString) {
                // Remove underscores and split the string into an array of words
                const words = inputString.split('_');

                // Capitalize the first letter of each word and join them back into a string
                const capitalizedString = words
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');

                return capitalizedString;
            },
            getCurrentMonthName() {
                const months = [
                    'January', 'February', 'March', 'April',
                    'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December'
                ];

                const now = new Date();
                let currentMonth = months[now.getMonth()];
                return currentMonth;
            },
            emptyOrderModal() {
                if (this.showEmptyOrderModal) {
                    this.showEmptyOrderModal.hide();
                }
                this.showEmptyOrderModal = new window.bootstrap.Modal("#emptyOrderModal");
                this.showEmptyOrderModal.show();
            },
            closeModal() {

                if (this.showEmptyOrderModal) {
                    this.showEmptyOrderModal.hide();
                }
                this.showEmptyOrderModal = new window.bootstrap.Modal("#emptyOrderModal");
                this.showEmptyOrderModal.hide();
            },
            getSearchParams(k) {
                var p = {};
                location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (s, k, v) { p[k] = v })
                return k ? p[k] : p;
            },
            isRoute(name, params) {
                return this.$page.props.ziggy.url === this.route(name, params)
            },
            monthName(monthNumber) {
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return months[monthNumber - 1]
            },
            attrStr(attrs) {
                if (typeof attrs != 'object') return;
                return Object.keys(attrs).reduce((acc, currentKey) => {
                    const html = '<b>' + currentKey.toUpperCase() + '</b>: ' + attrs[currentKey]
                    return acc + html + ', '
                }, '')
            },
            calculateDiscount(...amounts) {
                return amounts.reduce((acc, cur) => acc + Number(cur), 0)
            }
        },
        layout: UserPage
    }
</script>
<style>
    .ais-Hits {
        position: unset !important;
        width: 100%;
        top: 100%;
        left: 0;
        background: #fff;
    }

    .mt-minus-60px {
        margin-top: -60px !important;
    }

    .mr-minus-25px {
        margin-inline-end: -25px !important;
    }

    @media (max-width: 639.98px) {
        .queue-card-right button img {
            width: 20px;
        }
    }

    /* Small screens */
    @media (max-width: 576px) {
        .modal-full {
            max-width: 100% !important;
        }

        .mt-minus-60px {
            margin-top: 0px !important;
        }

        .mr-minus-25px {
            margin-inline-end: 0px !important;
        }
    }

    /* Medium screens */
    @media (min-width: 577px) and (max-width: 767px) {
        .modal-full {
            max-width: 100% !important;
        }

        .mt-minus-60px {
            margin-top: 0px !important;
        }

        .mr-minus-25px {
            margin-inline-end: 0px !important;
        }
    }

    /* Large and Extra-large screens */
    @media (min-width: 768px) {
        .modal-full {
            max-width: 90% !important;
        }
    }

    .progress-data {
        position: relative;
        top: 0;
        left: 0;
        width: 10%;
        height: 10%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: transparent;
        color: #000;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .progress-container {
        z-index: 9 !important;
    }

    .progress-container svg {
        animation-name: spin;
        animation-duration: 2000ms;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>
