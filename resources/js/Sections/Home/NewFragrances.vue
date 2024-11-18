<template>
    <section
        class="home collection-section recommended-product position-relative"
    >
        <div class="container">
            <div class="row align-items-center justify-content-between mb-3">
                <div class="col-md-8">
                    <h2>{{ title }}</h2>
                </div>
                <div class="col-md-3 col-xl-2 d-none d-lg-block">
                    <Link
                        :href="route('new.arrivals', 'fine-fragrance')"
                        class="btn btn-lg btn-long btn-black float-end"
                    >
                        {{ __('View All') }}
                    </Link>
                </div>
            </div>

            <div class="row">
                <carousel :settings="settings" :transition="1000" :autoplay="settings.autoplay" :breakpoints="settings.breakpoints"
                    :wrap-around="true">
                    <slide
                        class="col-md-3"
                        v-for="(product, productIndex) in newFragrances"
                        :key="productIndex">
                        <SmallProductCard :product="product" />
                    </slide>

                    <template #addons>
                        <navigation />
                        <pagination v-if="settings.dots" />
                    </template>
                </carousel>
                <Progress v-if="loading" />
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
    components: { Link,
        Carousel,
        Slide,
        Pagination,
        Navigation,
        SmallProductCard,
        Progress
    },
    props: {
        title: String,
    },
    data() {
        return {
            settings: {
                autoplay: 3000,
                dots: false,
                slidesToShow: 4,
                arrows: true,
                breakpoints: {
                    1024: {
                        itemsToShow: 3,
                        snapAlign: 'start',
                    },
                    768: {
                        itemsToShow: 2,
                        snapAlign: 'start',
                    },
                    640: {
                        itemsToShow: 1,
                        snapAlign: 'start',
                    }
                },
            },
            newFragrances: [],
            loading: false,
        };
    },
    beforeMount() {
        this.loading = true;
        axios
            .get(this.route("filter.data"), {
                params: {
                    new: true,
                    type: ["perfume", "cologne"],
                    with: ["badges"],
                    limit: 12,
                },
            })
            .then(({ data }) => {
                this.newFragrances = data;
            })
            .catch((e) => {
            })
            .finally(() => {
                this.loading = false;
            });
    },
};
</script>
