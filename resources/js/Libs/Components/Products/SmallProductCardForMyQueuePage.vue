<template>
    <div class="tw-relative tw-mt-0">
        <div class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-pl-3.5 tw-pointer-events-none">
            <img src="/images/MagnifyingGlass2.svg" alt="MagnifyingGlass2">
        </div>
        <input v-model="filter.keyword" type="text"
            class="tw-bg-transparent tw-border-b tw-border-gold-50 focus:tw-outline-none tw-text-gray-900 tw-text-sm  tw-block tw-w-full tw-pl-10 tw-p-3"
            placeholder="Search">
    </div>
    
    <div class="row g-2 !tw-mt-3" v-if="products.length > 0">
        <div class="col-6" v-for="(product, productIndex) in products" :key="productIndex">
            <div class="tw-w-full !tw-bg-secondary !tw-p-3">
                <Link @click="$emit('close-modal')" as="div"
                    :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })"
                    class="cursor-pointer small-product-image tw-flex tw-justify-center tw-items-center tw-mb-2">
                <img :src="product?.image?.url" class="!tw-w-[152px] !tw-h-1/2 img-fluid" :alt="product.title" />
                </Link>

                <Link @click="$emit('close-modal')" as="div"
                    :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })"
                    class="cursor-pointer small-product-content">
                <div  class="notranslate mb-0 text-center !tw-text-gold-50 !tw-truncate tw-text-ellipsis tw-w-full tw-block tw-overflow-hidden">
                    {{ product.title }}
                </div>
                <div class="notranslate !tw-truncate text-center" style="color: rgb(120 120 120); font-size: 14px; font-weight: 300;">
                    {{ product.brand?.name }}
                </div>
                <div class="product-rating !tw-mb-4 tw-mt-2">
                    <star-rating :read-only="true" class="tw-flex tw-justify-center" active-color="#FF8A00"
                        :increment="0.01" :fixed-points="2" :star-size="16" :rating="product.reviews_avg_rate"
                        :show-rating="false"></star-rating>
                </div>
                </Link>
                <div class="product-card-action">
                    <AddToQueueButton @click="$emit('close-modal')" as="button" :month="month" :year="year"
                        :product="product" class="btn btn-block btn-lg btn-black btn-add-to-queue">
                        <template v-slot:default>
                            <span class="icon">
                                <plus-circle />
                            </span> <span class="sp-text !tw-font-light azn !tw-text-[10px] sm:!tw-text-sm">
                                {{ __('Add To Queue') }}
                            </span>
                        </template>
                        <template v-slot:added>
                            <span class="icon">
                                <plus-circle />
                            </span> <span class="sp-text !tw-font-light azn !tw-text-[10px] sm:!tw-text-sm">{{ __('Added')
                            }}</span>
                        </template>
                    </AddToQueueButton>
                </div>

                <div class="like-dis-like" v-if="likeable">
                    <!--TODO: Make Like Works-->
                    <button type="button" class="like-dis-like-btn liked">
                        <img src="../../../../images/svg/like-dis-like/Ico_Dislike.svg" alt="dislike image" />
                    </button>
                    <button type="button" class="like-dis-like-btn">
                        <img src="../../../../images/svg/like-dis-like/Ico_Like.svg" alt="like image" />
                    </button>
                </div>
            </div>
        </div>
        <div class="text-center view-more" v-if="!infinity">
            <button
                class="tw-border-2 tw-border-black tw-w-full tw-text-center tw-inline-flex tw-h-14 tw--mt-12 tw-py-4 tw-justify-center tw-px-10 tw-font-TT-Norms tw-tracking-[0.77px] tw-text-base tw-font-semibold !tw-text-black tw-no-underline"
                v-if="!loading && paginate.next_page_url != null" @click.prevent="loadProducts(filter)">
                {{ __('Load More') }}
            </button>
        </div>
    </div>
    <template v-else>
        <h5 v-if="loading || products.length == 0" class="text-center p-5">
            <template v-if="loading">
                {{ __("Loading...") }}
            </template>
            <template v-else>
                <template v-if="products.length == 0">
                    {{ __("No Product Found") }}
                </template>
            </template>
        </h5>
    </template>
</template>

<script>
import AddToQueueButton from '../../../Components/Product/AddToQueueButtonForQueuePage.vue'
import {
    Link
} from "@inertiajs/inertia-vue3";
import PlusCircle from "../../../Components/SVG/PlusCircle.vue";
import StarRating from 'vue-star-rating'
import axios from "axios";
export default {
    props: {
        month: String,
        year: String,
        likeable: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            products: [],
            loading: false,
            product_not_found: false,
            paginate: {
                next_page_url: null,
            },
            filter:{
                keyword: ''
            }
        }
    },
    components: {
        AddToQueueButton,
        Link,
        PlusCircle,
        StarRating
    },
    created() {
        this.paginate.next_page_url = this.route("filter.data");
    },
    beforeMount() {
        this.loadProducts(this.filter, true);
    },
    mounted() {
        if (this.infinity) {
            window.addEventListener("scroll", this.handleScroll);
        }
    },
    unmounted() {
        if (this.infinity) {
            window.removeEventListener("scroll", this.handleScroll);
        }
    },
    watch: {
        'filter.keyword': {
            handler(keyword) {
                setTimeout(() => {
                    this.loadProducts();
                }, 100);
            },
            immediate: true,
        },
    },
    methods: {
        loadProducts(filter, init = false) {
            if (!init && this.paginate.next_page_url == null) return;
            const url = init
                ? this.route("filter.data")
                : this.paginate.next_page_url;
            this.loading = false;
            // if (init) {
            //     this.products = [];
            // }
            axios
                .get(url, {
                    params: {
                        ...filter,
                        paginate: true,
                        with: ["badges", "labels", "notes"],
                    },
                })
                .then(({ data }) => {
                    this.paginate = data;

                    if (!data.data?.length) {
                        this.product_not_found = true;
                    }

                    if (data.data && data.data.length) {
                        if (init) {
                            this.products = data.data;
                        } else {
                            this.products.push(...data.data);
                        }
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        handleScroll(e) {
            const element = document.querySelector(".infinity-scroll");
            if (element) {
                const rect = element.getBoundingClientRect();

                if (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <=
                    (window.innerHeight ||
                        document.documentElement.clientHeight) &&
                    rect.right <=
                    (window.innerWidth ||
                        document.documentElement.clientWidth)
                ) {
                    this.loadProducts(this.filter);
                }
            }
        },
    },
    watch: {
        filter: {
            deep: true,
            handler(filter) {
                this.loadProducts(filter, true);
            },
        },
        month: {
            deep: true,
            handler(filter) {
                this.loadProducts(this.filter, true);
            },
        }
    },
    computed: {
        crate() {
            if (!this.product.reviews_avg_rate) return 0;
            return parseInt(this.product.reviews_avg_rate);
        }
    }
}
</script>

<style>
@media (max-width: 767px) {
    .small-product-card {
        padding: 10px 20px;
    }

    .product-card-action .btn {
        font-family: 'TT Norms Pro', sans-serif;
        font-weight: 400;
        font-size: 12px !important;
    }

    .small-product-card .small-product-image img {
        height: 120px;
    }

    .small-product-card .small-product-image {
        margin-bottom: 16px;
    }

    .small-product-card .small-product-content p,
    .small-product-card .small-product-content h5 {
        font-family: 'TT Norms Pro', sans-serif;
        font-weight: normal;
        height: auto;
        font-size: 16px;
    }

    .small-product-card .small-product-content p {
        opacity: 70%;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .product-card-action .icon {
        display: none;
    }

    .product-card-action .btn-lg {
        font-size: 14px;
        line-height: 20px;
        padding: 6px 0px;
    }
}

.product-rating {
    justify-content: center;
}
</style>
