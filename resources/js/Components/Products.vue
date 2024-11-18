<template>
    <div>
        <div class="row mt-5" v-if="products.length">
            <div class="col-md-4" v-for="(product, productIndex) in products" :key="productIndex">
                <BigProductCardCard :product="product"/>
            </div>
        </div>
        <Progress v-if="loading"/>
        <div class="view-more pb-5" v-if="!infinity">
            <button class="view-more-button" v-if="!loading && paginate.next_page_url != null" @click.prevent="loadProducts(filter)">
                {{ __('View more') }}
            </button>
        </div>
        <div v-else-if="!loading" class="infinity-scroll"></div>
    </div>
</template>

<script>
import axios from "axios";
import Progress from "@/Libs/Components/ProgressBar.vue";
import BigProductCard from "@/Components/Product/BigProductCard.vue";

export default {
    props: {
        filter: {
            type: Object,
            default: {}
        },
        infinity: {
            type: Boolean,
            default: false
        }
    },
    components: { Progress, BigProductCard },
    data() {
        return {
            loading: false,
            products: [],
            paginate: {
                next_page_url: null
            }
        }
    },
    created() {
        this.paginate.next_page_url = this.route('filter.data')
    },
    beforeMount() {
        this.loadProducts(this.filter, true)
    },
    mounted() {
        if (this.infinity) {
            window.addEventListener("scroll", this.handleScroll)
        }
    },
    unmounted() {
        if (this.infinity) {
            window.removeEventListener("scroll", this.handleScroll)
        }
    },
    methods: {
        loadProducts(filter, init = false) {
            if (!init && this.paginate.next_page_url == null) return;
            const url = init?this.route('filter.data'):this.paginate.next_page_url;
            this.loading = true
            if (init) {
                this.products = []
            }
            axios.get(url, {
                params: {
                    ...filter,
                    paginate: true,
                    with: ['badges', 'labels', 'notes']
                }
            }).then(({ data }) => {
                this.paginate = data
                if (data.data && data.data.length) {
                    if (init) {
                        this.products = data.data
                    } else {
                        this.products.push(...data.data)
                    }
                }
            }).finally(() => {
                this.loading = false
            })
        },
        handleScroll(e) {
            const element = document.querySelector('.infinity-scroll')
            if (element) {
                const rect = element.getBoundingClientRect();

                if (rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)) {
                    this.loadProducts(this.filter)
                }
            }
        }
    },
    watch: {
        filter: {
            deep: true,
            handler(filter) {
                this.loadProducts(filter, true)
            }
        }
    }
}
</script>
