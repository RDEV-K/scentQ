<template>
    <section class="home landing-hero">
        <div class="home landing-hero-content">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="home landing-hero-content-container">
                        <h1>{{ title }}</h1>
                        <p>{{ sub_title }}</p>
                        <div class="timer-card">{{ counter_box.text }}
                            <div>
                                <div class="box">{{ minute }}<span>{{ __('MINS') }}</span></div>
                                <div class="box">{{ seconds }}<span>{{ __('SECS') }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="home landing-hero-background row justify-content-end g-0">
            <div class="col-xl-7">
                <carousel :settings="settings" :transition="1000" :autoplay="settings.autoplay" :breakpoints="settings.breakpoints"
                    :wrap-around="true">
                    <slide v-for="(slide, slideIndex) in slides" :key="slideIndex">
                        <img :src="slide.image" alt="Landing 2 Banner"/>
                    </slide>
                    <template #addons>
                        <navigation />
                        <pagination v-if="settings.dots" />
                    </template>
                </carousel>
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

export default{
    props: {
        title: String,
        sub_title: String,
        counter_box: Object,
        slides: Array,
    },
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation
    },
    data() {
        return {
            countDownInterval: null,
            minute: 0,
            seconds: 0,
            settings: {
                arrows: false,
                autoplay: 3000,
                dots: false,
                slidesToShow: 2,
                breakpoints: {
                    1024: {
                        itemsToShow: 1,
                        snapAlign: 'start',
                    },
                    768: {
                        itemsToShow: 1,
                        snapAlign: 'start',
                    },
                    640: {
                        itemsToShow: 1,
                        snapAlign: 'start',
                    }
                },
            },
        };
    },
    mounted() {
        this.minute = Number(this.counter_box.minute ?? 0);
        this.seconds = Number(this.counter_box.second ?? 0);
        this.countDownInterval = setInterval(this.countDown, 1000);
    },
    methods: {
        countDown() {
            if (this.seconds > 0) {
                this.seconds -= 1;
            } else if (this.minute > 0) {
                this.minute -= 1;
                this.seconds = 59;
            }
        },
    },
    beforeUnmount() {
        clearInterval(this.countDownInterval);
    },
};
</script>

<style lang="scss">
@import "../../../scss/home.scss";
</style>
