<template>
    <section>
        <div class="container">
            <div
                class="home tw-border tw-border-[#e9e9e9] !tw-bg-white tw-p-5 recommended-product position-relative tw-mb-6">
                <div class="row align-items-center justify-content-between mb-3">
                    <div class="col-md-8">
                        <h2>{{ title }}</h2>
                    </div>
                    <!-- <div class="col-md-3 col-xl-2 d-none d-lg-block">
                                    <Link
                                        :href="route('recommendation')"
                                        class="btn btn-lg btn-long btn-black float-end"
                                    >
                                        {{ __("View All") }}
                                    </Link>
                                </div> -->
                </div>

                <div>
                    <carousel :settings="settings" :transition="1000" :autoplay="settings.autoplay"
                        :breakpoints="settings.breakpoints" :wrap-around="true">
                        <slide v-for="(product, productIndex) in recommendProduct" :key="productIndex">
                            <SmallProductCard :product="product" />
                        </slide>

                        <template #addons>
                            <navigation />
                            <pagination v-if="settings.dots" />
                        </template>
                    </carousel>
                    <Progress v-if="loading" />
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <Link :href="route('quiz')"
                            class="hover:!tw-text-gray-600 home text-capitalize simple-anchor simple-anchor-medium m-0 mt-3">
                        {{ __("Retake Quiz") }}
                        <img src="../../../images/svg/ico-arrow-r.svg" class="icon-right" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import 'vue3-carousel/dist/carousel.css'
import {
    Carousel,
    Slide,
    Pagination,
    Navigation,
} from 'vue3-carousel'
import axios from "axios";
import SmallProductCard from "../../Libs/Components/Products/SmallProductCard.vue";
import Progress from "@/Libs/Components/ProgressBar.vue";

export default {
    props: {
        title: String
    },
    components: {
        Link,
        Carousel,
        Slide,
        Pagination,
        Navigation,
        SmallProductCard,
        Progress
    },
    data() {
        return {
            settings: {
                autoplay: 3000,
                dots: false,
                slidesToShow: 4,
                arrows: true,
                breakpoints: {
                    425: {
                        itemsToShow: 2,
                        snapAlign: 'start',
                    },
                    // 700px and up
                    768: {
                        itemsToShow: 2,
                        snapAlign: 'start',
                    },
                    // 1024 and up
                    1024: {
                        itemsToShow: 3,
                        snapAlign: 'start',
                    },
                },
            },
            recommendProduct: [],
            loading: false,
        };
    },
    beforeMount() {
        this.loading = true;
        axios
            .get(this.route("filter.data"), {
                params: {
                    recommendation: true,
                    limit: 12,
                    with: ["badges"],
                },
            })
            .then(({ data }) => {
                this.recommendProduct = data;
            })
            .catch((e) => {
            })
            .finally(() => {
                this.loading = false;
            });
    },
};
</script>
<style>
.collection-section {
    background-color: white;
}
</style>
