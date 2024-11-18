<template>
    <div class="tw-flex tw-justify-between tw-items-center">
        <button class="custom-navigation prev" @click="swiperPrev">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
        <div class="swiper-container tw-w-full tw-max-w-[1168px]">
            <swiper :slidesPerView="2" :spaceBetween="10" :breakpoints="{
                '640': {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                '768': {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                '1024': {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
                '1320': {
                    slidesPerView: 6,
                    spaceBetween: 20,
                },
            }" :navigation="swiperOptions.navigation" :modules="modules" class="mySwiper">
                <swiper-slide v-for="(product, ProductIndex) in products" :key="ProductIndex">
                    <inertia-link as="div"
                        :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })"
                        class="tw-cursor-pointer tw-bg-[rgba(247,239,233,1)] tw-p-3 tw-w-full tw-text-center">
                        <img class="tw-w-[146px] tw-h-[146px]" :src="product?.image?.url" :alt="product.title">
                        <div class="tw-text-center">
                            <h3
                                class="notranslate tw-text-base md:tw-truncate tw-mt-2 tw-mb-0 tw-leading-4 tw-text-[rgba(177,119,66,1)] tw-line-clamp-2">
                                {{ product.title }}
                            </h3>
                            <p class="notranslate tw-mb-0 tw-mt-1 tw-text-sm tw-line-clamp-2">
                                {{ product.brand?.name }}
                            </p>
                            <div class="tw-mt-3">
                                <star-rating :read-only="true" class="tw-flex tw-justify-center"
                                    active-color="rgba(177, 119, 66, 1)" :increment="0.01" :fixed-points="2"
                                    :star-size="14" :rating="product.reviews_avg_rate"
                                    :show-rating="false"></star-rating>
                            </div>
                            <div class="tw-mt-4">
                                <AddToQueueButton as="button" :product="product"
                                    class="!tw-bg-black !tw-text-white !tw-w-full !tw-text-sm !tw-px-2 !tw-h-[38px]">
                                    <template v-slot:default>
                                        <span class="icon">
                                            <plus-circle />
                                        </span> <span class="sp-text !tw-font-light azn !tw-text-[10px] sm:!tw-text-sm">{{
                                            __('Add To Queue') }}</span>
                                    </template>
                                    <template v-slot:added>
                                        <span class="icon">
                                            <plus-circle />
                                        </span> <span class="sp-text !tw-font-light azn !tw-text-[10px] sm:!tw-text-sm">{{
                                            __('Added') }}</span>
                                    </template>
                                </AddToQueueButton>
                            </div>
                        </div>
                    </inertia-link>
                </swiper-slide>
            </swiper>
        </div>
        <button class="custom-navigation next" @click="swiperNext">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>
</template>

<script>
    import AddToQueueButton from './Product/AddToQueueButton.vue'

    // Import Swiper Vue.js components
    import { Swiper, SwiperSlide } from 'swiper/vue';

    // Import Swiper styles
    import 'swiper/css';
    import 'swiper/css/navigation';

    // import required modules
    import { Navigation } from 'swiper';
    import StarRating from 'vue-star-rating'
    import { onMounted, ref } from 'vue'
    import axios from "axios";

    export default {
        components: {
            Swiper,
            SwiperSlide,
            StarRating,
            AddToQueueButton
        },
        setup() {
            const modules = [Navigation];
            const products = ref([]);

            const swiperOptions = {
                navigation: {
                    nextEl: '.custom-navigation.next',
                    prevEl: '.custom-navigation.prev',
                },
            };

            const swiperPrev = () => {
                const swiper = document.querySelector('.mySwiper').swiper;
                swiper.slidePrev();
            };

            const swiperNext = () => {
                const swiper = document.querySelector('.mySwiper').swiper;
                swiper.slideNext();
            };

            const fetchData = async () => {
                try {
                    const { data } = await axios.get(route('api.get.new.products'));

                    products.value = data;
                } catch (e) {
                    console.error(e);
                }
            };

            onMounted(() => {
                // Call fetchData when the component is mounted
                fetchData();
            });

            return {
                products,
                modules,
                swiperOptions,
                swiperPrev,
                swiperNext,
                fetchData,
            };
        },
    };

</script>
