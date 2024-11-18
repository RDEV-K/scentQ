<template>
    <section class="home trending-notes collection-section position-relative">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-6">
                    <div class="collection-section-heading">
                        <h2>{{ title }}</h2>
                        <p>{{ sub_title }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <carousel :settings="settings" :transition="1000" :autoplay="settings.autoplay" :breakpoints="settings.breakpoints"
                    :wrap-around="true">
                    <slide
                        class="col-md-2"
                        v-for="(note, noteIndex) in TrendingNotes"
                        :key="noteIndex">
                        <div class="single-trending-note">
                            <div class="img-thumbnail border-0 text-center p-0">
                                <img
                                    :src="note.image"
                                    class="img-fluid"
                                    :alt="note.name+' image'"
                                />
                            </div>
                            <h6>{{ note.name }}</h6>
                            <span>{{ note.products_count }} products</span>
                        </div>
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
import 'vue3-carousel/dist/carousel.css'
import {
    Carousel,
    Slide,
    Pagination,
    Navigation,
} from 'vue3-carousel'
import Progress from "@/Libs/Components/ProgressBar.vue";
import axios from "axios";

export default {
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
        Progress
    },
    props: {
        title: String,
        sub_title: String,
    },
    data() {
        return {
            settings: {
                autoplay: 3000,
                dots: false,
                slidesToShow: 6,
                // slidesToShow: 1,
                arrows: true,
                breakpoints: {
                    1024: {
                        itemsToShow: 4,
                        snapAlign: 'start',
                    },
                    768: {
                        itemsToShow: 3,
                        snapAlign: 'start',
                    },
                    640: {
                        itemsToShow: 2,
                        snapAlign: 'start',
                    }
                },
            },
            TrendingNotes: [],
            loading: false,
        };
    },
    beforeMount() {
        this.loading = true;
        axios
            .get(this.route("section.data", "getTrendingNotes"))
            .then(({ data }) => {
                this.TrendingNotes = data;
            })
            .catch((e) => {
            })
            .finally(() => {
                this.loading = false;
            });
    },
};
</script>
