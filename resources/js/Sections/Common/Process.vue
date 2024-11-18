<template>
    <section v-if="!$page.props.user" class="ll-how-to !tw-border-t !tw-border-[#E0E0E0]">
        <div class="container !tw-max-w-[1168px] tw-mx-auto">
            <div class="row gy-3 section-header">
                <div class="col-md-12">
                    <h3 class="text-center ll-title">
                        {{ __(title)}}</h3>
                </div>
            </div>
            <div>
                <swiper class="mySwiper" :pagination="pagination" :loop="true" :modules="modules"
                    :slides-per-view="slidesPerView" :breakpoints="breakpoints" :space-between="32" :mousewheel="true">
                    <swiper-slide v-for="(step, stepIndex) in steps" :key="step.id">
                        <div>
                            <div class="how-to-image how-to-custem-img">
                                <img v-lazy="step.image" class="img-fluid" alt="how-to-process"/>
                            </div>
                            <div class="ll-how-to-process">
                                <div class="ll-serial">{{ pad(stepIndex) }}.</div>
                                <div class="ll-process-title">
                                    <h4>{{ __(step.title)}}</h4>
                                    <p>{{ __(step.desc)}}</p>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                    <div class="custom-pagination" ref="customPagination"></div>
                </swiper>
            </div>
            <!-- <div class="md:tw-hidden tw-text-center tw-pt-8">
                <template v-if="$page.props.user">
                    <inertia-link :href="route('subscribe')"
                        class="tw-text-[12px] md:tw-text-lg tw-inline-block !tw-no-underline !tw-leading-6 tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                        {{ __('APPLY') }} {{ numberFormat($page?.props?.config?.app?.subscribe_discount_amount, 0) }}% {{ __('Discount NOW') }}
                    </inertia-link>
                </template>
                <template v-else>
                    <inertia-link :href="route('register', { 'subscribe': 1 })"
                        class="tw-text-[12px] md:tw-text-lg tw-inline-block !tw-no-underline !tw-leading-6 tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                        {{ __('APPLY') }} {{ numberFormat($page?.props?.config?.app?.subscribe_discount_amount, 0) }}% {{ __('Discount NOW') }}
                    </inertia-link>
                </template>
            </div> -->
            <!-- <div class="tw-hidden md:tw-block tw-text-center tw-pt-8">
                <Link href="/smart-recommendations" class="!tw-whitespace-pre btn btn-black !tw-py-5 !tw-px-4">
                <template v-if="$page.props.user && $page.props.user.quiz_answered">
                    {{ __('Edit quiz') }}
                </template>
                <template v-else>
                    {{ __('Get Started with A quiz') }}
                </template>
                </Link>
            </div> -->
        </div>
    </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';


// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';

import { Pagination } from 'swiper';

export default {
    props: {
        title: String,
        button_text: String,
        button_link: String,
        steps: Array,
    },
    components: {
        Link,
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            slidesPerView: 1,
            breakpoints: {
                // when window width is >= 640px
                640: {
                    slidesPerView: 2,
                },
                // when window width is >= 1024px
                1024: {
                    slidesPerView: 3,
                },
            },
        }
    },
    methods: {
        pad(num) {
            return (num + 1).toString().padStart(2, "0");
        },
    },
    setup() {
        return {
            pagination: {
                el: '.custom-pagination',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '"></span>';
                },
            },
            modules: [Pagination],
        };
    },
};
</script>

<style>
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}

.ll-how-to {
    padding: 80px 0px;
}

@media (max-width: 767px) {

    .ll-how-to,
    .landing-hero-content-container {
        padding: 40px 0px;
    }
}

.ll-how-to-process {
    display: flex;
    gap: 8px;
}

.section-header .ll-title {
    font-family: 'TT Norms Pro', sans-serif;
    font-weight: 600;
    font-size: 40px;
    line-height: 48px;
    color: #000000;
    text-transform: none;
}

.section-header {
    margin-bottom: 50px;
}

.ll-serial {
    font-family: 'TT Norms Pro', sans-serif;
    font-weight: 400;
    font-size: 40px;
    line-height: 40px;
    color: #808080;
    min-width: 72px;
    height: 40px;
}

.ll-process-title {
    width: 100%;
}

.ll-process-title h4 {
    font-family: 'TT Norms Pro', sans-serif;
    font-weight: 600;
    font-size: 22px;
    line-height: 28px;
    color: #000000;
    margin-bottom: 8px;
}

.ll-process-title p {
    font-family: 'TT Norms Pro', sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
    color: #313131;
}

.how-to-image {
    margin-bottom: 40px;
}

@media(max-width: 500px) {
    .ll-serial {
        font-size: 28px;
        line-height: 28px;
        min-width: 44px;
    }

    .ll-process-title h4 {
        font-size: 18px;
    }

    .ll-process-title p {
        font-size: 14px;
    }
}

.how-to-custem-img img {
    height: 300px;
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

@media (max-width: 525px) {
    .section-header {
        margin-bottom: 32px;
    }

    .how-to-custem-img img {
        height: 200px;
        object-fit: contain;
    }

    .section-header .ll-title {
        font-size: 24px;
        line-height: 32px;
    }

    .how-to-image {
        margin-bottom: 20px;
    }
}

.custom-pagination {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.custom-pagination span {
    width: 10px;
    height: 10px;
    background-color: rgba(0, 0, 0, 0.4);
    border-radius: 50px;
    cursor: pointer;
}

.custom-pagination span.swiper-pagination-bullet-active {
    width: 24px;
    background-color: #000000;
}

@media (min-width: 1024px) {
    .custom-pagination {
        display: none;
    }
}
</style>
