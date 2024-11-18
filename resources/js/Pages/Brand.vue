<template>
    <section class="single-brand">
        <div class="container">
            <img :src="brand.cover_image" :alt="brand.name + ' image'" class="product-img" />

            <div class="row">
                <div class="col-md-6 m-auto">
                    <div class="brand-info d-flex justify-content-between">
                        <p class="text-secondary">{{__('establishedAt')}}: {{ brand.est_text }}</p>
                        <p class="text-secondary">{{ count }} {{ ('products') }}</p>
                    </div>
                    <div v-html="brand.description"></div>
                </div>
            </div>

            <div class="product-type mt-5" v-for="(
                                                    brandProductTypeProducts, brandProductTypeName
                                                ) in products" :key="brandProductTypeName">
                <h2 class="product-type-title">
                    {{ brandProductTypeName }}
                </h2>
                <div class="row g-2">
                    <div v-for="(product, productIndex) in brandProducts" :key="productIndex" class="col-6 col-md-4">
                        <div class="">
                            <div class="">
                                <h3 class="ll-products-list-title">
                                    {{ __(title) }}
                                </h3>
                            </div>
                        </div>
                        <SmallProductCard :product="product" />
                    </div>
                    <!-- <carousel :settings="slickSettings" :transition="1000" :autoplay="slickSettings.autoplay"
                        :breakpoints="slickSettings.breakpoints" v-if="brandProducts && brandProducts.length">
                        <slide class="" v-for="(product, productIndex) in brandProducts"
                            :key="productIndex">
                            <Product :product="product" />

                        </slide>
                        <template #addons>
                            <navigation />
                            <pagination v-if="slickSettings.dots" />
                        </template>
                    </carousel> -->
                </div>
            </div>

            <div class="row mt-5" v-if="brand.blogs && brand.blogs.length">
                <h2 class="fw-bold">{{__('moreAbout')}} {{ brand.name }}</h2>

                <div class="col-md-4 my-4" v-for="(blog, blogIndex) in brand.blogs" :key="blogIndex">
                    <Link :href="blog.button_link" class="text-decoration-none">
                    <div class="position-relative card all-product-card" style="width: 100%">
                        <Link :href="blog.button_link" class="end-0 position-absolute btn btn-light m-2">{{ __('blog') }}</Link>
                        <img :src="blog.blog_image" class="card-img-top img-fluid" alt="..." />
                        <div class="card-body">
                            <div class="discover-brand">
                                <h6 class="fw-bold">{{ blog.title }}</h6>
                                <p class="card-text mt-3">
                                    {{ excerpt(blog.desc, 200) }}
                                </p>
                            </div>
                            <div class="read-more mt-4">
                                <Link :href="blog.button_link">{{ blog.button_text }}
                                <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.99474 5.89233C6.97001 5.65635 6.86672 5.43321 6.69904 5.25354L2.21682 0.430247C1.9326 0.103171 1.47777 -0.0551087 1.03015 0.0172881C0.582528 0.0896848 0.213218 0.381259 0.0666046 0.778016C-0.0800085 1.17477 0.0193644 1.61369 0.325871 1.92317L4.11554 6L0.325871 10.0768C0.0193645 10.3863 -0.0800084 10.8252 0.0666047 11.222C0.213218 11.6187 0.582528 11.9103 1.03015 11.9827C1.47777 12.0551 1.9326 11.8968 2.21682 11.5698L6.69904 6.74646C6.919 6.51046 7.02571 6.20223 6.99474 5.89233Z"
                                        fill="currentColor"></path>
                                </svg></Link>
                            </div>
                        </div>
                    </div>
                    </Link>
                </div>
            </div>
        </div>
        <ProgressBar type="fixed" v-if="loading" />
    </section>
</template>

<script>
import layout from "../Layouts/UserPage.vue";
import { Link } from "@inertiajs/inertia-vue3";
import SmallProductCard from "@/Libs/Components/Products/SmallProductCard.vue";
import Product from "@/Libs/Components/Products/BigProduct.vue";
import "vue3-carousel/dist/carousel.css";
import {
    Carousel,
    Slide,
    Pagination,
    Navigation,
} from 'vue3-carousel'
import ProgressBar from "@/Libs/Components/ProgressBar.vue";
import axios from "axios";

export default {
    props: {
        brand: Object,
        brandProducts: Object
    },
    data() {
        return {
            loading: true,
            products: [],
            count: 0,
            slickSettings: {
                autoplay: 3000,
                dots: false,
                itemsToShow: 1,
                snapAlign: "start",
                arrows: true,
                breakpoints: {
                    // 700px and up
                    700: {
                        itemsToShow: 2,
                        snapAlign: 'center',
                    },
                    // 1024 and up
                    1024: {
                        itemsToShow: 3,
                        snapAlign: 'start',
                    },
                },
            },
        };
    },
    beforeMount() {
        this.loading = true
        axios.get(this.route('ajax', { method: 'brandData', brand_id: this.brand.id }))
            .then(({ data }) => {
                this.products = data.products
                this.count = data.count
            })
            .finally(() => {
                this.loading = false
            })
    },
    methods: {
        excerpt(string, limit = 100) {
            if (!string) return;
            return string.replace(/<\/?[^>]+>/gi, " ").slice(0, limit) + "...";
        },
    },
    components: {
        SmallProductCard,
        Product,
        Link,
        Carousel,
        Slide,
        Pagination,
        Navigation,
        ProgressBar
    },
    layout: layout,
};
</script>

<style lang="scss">
@import "../../scss/allBrands.scss";

@media only screen and (max-width: 640px) {
    .product-card {
        width: 100% !important;
    }
}

.carousel__slide {
    padding: 5px;
}

.product-img-box .product-note img {
    max-height: 64px !important;
}
</style>
