<template>
    <div class="position-relative">
        <div class="row g-2 products-list-row" v-if="products.length > 0">
            <div class="col-6 col-xl-4" v-for="(product, productIndex) in products" :key="productIndex">
                <Product :product="product" :filter="filter" />
            </div>
        </div>

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

        <Progress v-if="loading" />

        <div class="text-center view-more" v-if="!infinity">
            <button
                class="tw-border tw-border-black tw-inline-flex tw-h-14 tw-py-4 tw-px-10 tw-font-TT-Norms tw-tracking-[0.77px] tw-text-base !tw-text-black tw-font-semibold"
                v-if="!loading && paginate.next_page_url != null" @click.prevent="loadProducts(filter)">
                {{ __(loadMore) }}
            </button>
        </div>
        <div v-else-if="!loading" class="infinity-scroll"></div>
    </div>
</template>

<script>
    import Progress from "@/Libs/Components/ProgressBar.vue";
    import Product from "@/Libs/Components/Products/BigProduct.vue";
    import axios from "axios";

    export default {
        props: {
            filter: {
                type: Object,
                default: {},
            },
            infinity: {
                type: Boolean,
                default: false,
            },
            loadMore: {
                type: String,
                default: "Load More",
            },
        },
        components: { Progress, Product },
        data() {
            return {
                loading: false,
                product_not_found: false,
                products: [],
                paginate: {
                    next_page_url: null,
                },
            };
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
        methods: {
            loadProducts(filter, init = false) {
                if (!init && this.paginate.next_page_url == null) return;
                const url = init
                    ? this.route("filter.data")
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