<template>
    <section class="filter-padding">
        <div class="container">
            <div class="row justify-content-around g-5">

                <!-- <div class="container">

                    <div class="row justify-content-center other-fragrances" v-if="brandProducts && brandProducts.length">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>
                                Other fragrances from this brand
                            </h2>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <div class="row products-list-row" v-if="brandProducts.length > 0">
                                    <div class="col-6 col-lg-4" v-for="(product, productIndex) in brandProducts"
                                        :key="productIndex">
                                        <Product :product="product" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <inertia-link as="div" href="#" class="text-center view-more">
                        <button
                            class="tw-border-2 tw-border-black tw-inline-flex tw-h-14 tw-py-4 tw-px-10 tw-font-TT-Norms tw-tracking-[0.77px] tw-text-base tw-font-semibold !tw-text-black">
                            View More Perfume
                        </button>
                    </inertia-link>
                </div> -->




                <!-- right -->
                <div class="col-12">
                    <!-- perfume-list -->
                    <section class="filter-perfume-list">
                        <div class="tw-flex tw-gap-4 tw-flex-col md:tw-flex-row tw-justify-between md:tw-items-center">
                            <div>
                                <div class="tw-text-2xl tw-font-bold tw-p-2">
                                    {{ __("Your scent recommendations") }}
                                </div>
                                <div class="tw-text-md !tw-font-TT-Norms tw-p-2">
                                    {{ __('Your answers of') }}
                                    <template v-for="(item, index) in quiz_items" :key="index">
                                        <template v-if="quiz_items.length == index + 1">
                                            {{ __('and') }}
                                        </template>
                                        <span class="tw-font-bold" style="font-family: 'TT Norms Pro', sans-serif;">
                                            {{ item }}
                                        </span>
                                        <template v-if="quiz_items.length != index + 1">
                                            ,
                                        </template>
                                    </template>
                                    <!-- <span class="tw-font-bold" style="font-family: 'Milliard Book';">clean</span>
                                                                                    with a
                                                                                    <span class="tw-font-bold" style="font-family: 'Milliard Book';">clean & fresh</span> -->
                                    {{__('feel, we recommend these matches to your Fragrance Families.')}}
                                </div>
                            </div>
                            <div>
                                <inertia-link :href="route('quiz')" class="btn btn-black tw-whitespace-nowrap">
                                    {{ __('Edit Quiz') }}
                                </inertia-link>
                            </div>
                        </div>
                        <div class="mt-3 row g-3 g-md-4 justify-content-center">
                            <div class="position-relative">

                                <div class="row g-2" v-if="products.length > 0">
                                    <div class="col-6 col-lg-4" v-for="(product, productIndex) in products"
                                        :key="productIndex">
                                        <Product :product="product" />
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

                                <Progress v-if="loading" />

                                <div class="text-center view-more" v-if="!infinity">
                                    <button class="btn btn-lg btn-long btn-black"
                                        v-if="!loading && paginate.next_page_url != null"
                                        @click.prevent="loadProducts(filter)">
                                        {{ __(loadMore) }}
                                    </button>
                                </div>
                                <div v-else-if="!loading" class="infinity-scroll"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import UserPage from "../Layouts/UserPage.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import axios from "axios";
    import Progress from "@/Libs/Components/ProgressBar.vue";
    import Product from "@/Libs/Components/Products/BigProduct.vue";

    export default {
        layout: UserPage,
        components: {
            Progress,
            Product
        },
        props: {
            quiz_items: Array
        },
        data() {
            return {
                loading: false,
                product_not_found: false,
                products: [],
                paginate: {
                    next_page_url: null,
                },
                infinity: {
                    type: Boolean,
                    default: false,
                },
                loadMore: {
                    type: String,
                    default: "Load More",
                },
            };
        },
        created() {
            this.paginate.next_page_url = this.route("get.recommendation.products");
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
        methods: {
            loadProducts(filter, init = false) {
                if (!init && this.paginate.next_page_url == null) return;
                const url = init
                    ? this.route("get.recommendation.products")
                    : this.paginate.next_page_url;
                this.loading = true;
                if (init) {
                    this.products = [];
                }
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
        },
    };
</script>

<style lang="scss">
    @import "../../scss/filter.scss";

    .filter-padding {
        padding: 0px !important;
    }
</style>
