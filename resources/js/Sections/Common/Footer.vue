<template>
    <section ref="footer" class="footer tw-relative" :class="route().current('product')
            ? 'tw-z-[9997] tw-pt-[60px]'
            : (
                route().current('index')
                    ? (testimonials.length > 0 ? 'tw-pt-[256px]' : 'tw-pt-[60px]')
                    : 'tw-pt-[60px]'
            )
        ">
        <div class="container">
            <div class="row gx-5">
                <div class="col-md-3">
                    <div class="footer-content">
                        <Link href="/" class="tw-flex tw-items-center">
                        <div class="mb-3 footer-logo">
                            <img class="!tw-h-10 !tw-mr-2" src="../../../../public/images/footer-logo.png"
                                :alt="config.app.name" />
                            <img src="../../../images/svg/logo-light.svg" :alt="config.app.name" />
                        </div>
                        </Link>
                        <p>
                            {{ __('Discover new fragrances every') }} {{ footerData?.plan?.interval_count }} {{ __('month for') }} {{
                                currencyConvert(footerData?.plan?.total_price) }}
                        </p>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-sm-8 col-md-8 col-lg-9">
                            <div class="footer-content footer-content-about">
                                <div class="row gx-4">
                                    <div class="col-12 tw-mb-4">
                                        <h6>{{ __('Store') }}</h6>
                                        <ul class="!tw-mt-1 md:!tw-mt-4">
                                            <li>
                                                <Link :href="route('brands')">{{ __('All Brands') }}</Link>
                                            </li>
                                            <li>
                                                <Link :href="route('filter', 'perfume')">{{ __('Shop Perfumes') }}
                                                </Link>
                                            </li>
                                            <li>
                                                <Link :href="route('filter', 'cologne')">{{ __('Shop Colognes') }}
                                                </Link>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="icons-row col-sm-6 col-md-4 col-lg-3 ">
                            <div class="footer-content">
                                <h6>{{ __('Social Media') }}</h6>
                                <div class="tw-flex tw-items-center tw-gap-3 !tw-mt-1 md:!tw-mt-4"
                                    v-if="$page.props.social_links">
                                    <a class="tw-inline-block" v-for="(link, index) in $page.props.social_links"
                                        :key="index" :href="link.link" target="_blank">
                                        <img class="tw-min-w-[24px]" width="24" height="24" :src="link.icon_url"
                                            :alt="link.name" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom align-items-start !tw-font-TT-Norms">
                <p class="m-0">© {{ $page.props.config.app.name }} {{ thisYear }}</p>
                <div class="bottom-link tw-flex-wrap !tw-gap-y-3">
                    <Link :href="route('page', 'about-us')">{{ __('About Us') }}</Link>
                    <Link :href="route('faq')">{{ __('FAQs') }}</Link>
                    <Link :href="route('page', 'privacy-policy')">{{ __('Privacy Policy') }}</Link>
                    <Link :href="route('page', 'terms-and-conditions')">{{ __('Terms And Conditions') }}</Link>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {
    Link
} from "@inertiajs/inertia-vue3";
import axios from "axios";
// Import Swiper Vue.js components
import {
    Swiper,
    SwiperSlide
} from 'swiper/vue';


// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';

import {
    Navigation
} from 'swiper';

export default {
    components: {
        Link,
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            footerData: null,
            slidesPerView: 1,
            testimonials: [],
            breakpoints: {
                // when window width is >= 640px
                768: {
                    slidesPerView: 2,
                },
                // when window width is >= 1024px
                1024: {
                    slidesPerView: 3,
                },
            },
        }
    },
    mounted() {
        axios.get(this.route('section.data', 'footer'))
            .then(({ data }) => this.footerData = data);

        this.getTestimonial();
    },
    computed: {
        thisYear: () => new Date().getFullYear(),
    },
    methods: {
        socialLink(link) {
            window.open(link, "_blank")
            return false;
        },
        getTestimonial() {
            axios.get(this.route('testimonial.index'))
                .then((response) => {
                    this.testimonials = response.data;
                })
                .catch((e) => {
                    this.testimonials = [];
                });
        },
    },
    setup() {
        return {
            navigation: {
                el: '.custom-navigation',
                clickable: true,
            },
            modules: [Navigation],
        };
    },
}
</script>

<style>
.footer-logo img {
    max-width: 200px;
}

.footer-social-icon a:hover {
    /* filter: invert(48%) sepia(68%) saturate(3422%) hue-rotate(320deg) brightness(100%) contrast(102%); */
}

.footerTestimonialSwiper.swiper {
    padding: 36px;
}

.footerTestimonialSwiper .swiper-button-prev {
    left: 0px;
    z-index: 999999 !important;
}

.footerTestimonialSwiper .swiper-button-prev::after {
    content: url("data:image/svg+xml,%3Csvg width='56' height='57' viewBox='0 0 56 57' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg filter='url(%23filter0_d_1565_598)'%3E%3Crect width='24' height='24' rx='12' transform='matrix(-1 0 0 1 40 16.9531)' fill='%23b17742'/%3E%3Cpath d='M30 24.9531L26 28.9531L30 32.9531' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/g%3E%3Cdefs%3E%3Cfilter id='filter0_d_1565_598' x='0' y='0.953125' width='56' height='56' filterUnits='userSpaceOnUse' color-interpolation-filters='sRGB'%3E%3CfeFlood flood-opacity='0' result='BackgroundImageFix'/%3E%3CfeColorMatrix in='SourceAlpha' type='matrix' values='0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0' result='hardAlpha'/%3E%3CfeOffset/%3E%3CfeGaussianBlur stdDeviation='8'/%3E%3CfeComposite in2='hardAlpha' operator='out'/%3E%3CfeColorMatrix type='matrix' values='0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0'/%3E%3CfeBlend mode='normal' in2='BackgroundImageFix' result='effect1_dropShadow_1565_598'/%3E%3CfeBlend mode='normal' in='SourceGraphic' in2='effect1_dropShadow_1565_598' result='shape'/%3E%3C/filter%3E%3C/defs%3E%3C/svg%3E%0A");
}

.footerTestimonialSwiper .swiper-button-next {
    right: 0px;
    z-index: 999999 !important;
}

.footerTestimonialSwiper .swiper-button-next::after {
    content: url("data:image/svg+xml,%3Csvg width='56' height='57' viewBox='0 0 56 57' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg filter='url(%23filter0_d_1565_596)'%3E%3Crect x='16' y='16.9531' width='24' height='24' rx='12' fill='%23b17742'/%3E%3Cpath d='M26 24.9531L30 28.9531L26 32.9531' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/g%3E%3Cdefs%3E%3Cfilter id='filter0_d_1565_596' x='0' y='0.953125' width='56' height='56' filterUnits='userSpaceOnUse' color-interpolation-filters='sRGB'%3E%3CfeFlood flood-opacity='0' result='BackgroundImageFix'/%3E%3CfeColorMatrix in='SourceAlpha' type='matrix' values='0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0' result='hardAlpha'/%3E%3CfeOffset/%3E%3CfeGaussianBlur stdDeviation='8'/%3E%3CfeComposite in2='hardAlpha' operator='out'/%3E%3CfeColorMatrix type='matrix' values='0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0'/%3E%3CfeBlend mode='normal' in2='BackgroundImageFix' result='effect1_dropShadow_1565_596'/%3E%3CfeBlend mode='normal' in='SourceGraphic' in2='effect1_dropShadow_1565_596' result='shape'/%3E%3C/filter%3E%3C/defs%3E%3C/svg%3E%0A");
}
</style>
