<template>
    <section ref="targetSection" class="main-notes !tw-pb-8 !tw-bg-transparent" id="main-notes"
        v-if="products.length > 0">
        <div class="container">
            <div class="row">
                <div class="col-md-6 m-auto text-center text-center">
                    <h5 class="tw-text-sm tw-mb-1 tw-text-[rgba(175,105,41,1)]">
                        {{ __("This just in") }}
                    </h5>
                    <h2 class="!tw-text-[30px] !tw-mb-8 !tw-uppercase !tw-font-bold !tw-leading-[30px]">
                        {{ __("New arrivals") }}
                    </h2>
                </div>
            </div>

            <div class="row justify-content-center">
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
                                <product-card :product="product">
                                    <template #button>
                                        <AddToQueueButton as="button" :product="product"
                                            class="!tw-bg-black !tw-text-white !tw-w-full !tw-text-sm !tw-px-2 !tw-h-[38px]">
                                            <template v-slot:default>
                                                <span class="icon">
                                                    <plus-circle />
                                                </span> <span class="sp-text azn !tw-font-light">{{ __('Add To Queue')
                                                }}</span>
                                            </template>
                                            <template v-slot:added>
                                                <span class="icon">
                                                    <plus-circle />
                                                </span> <span class="sp-text azn !tw-font-light">{{ __('Added') }}</span>
                                            </template>
                                        </AddToQueueButton>
                                    </template>
                                </product-card>
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
            </div>
        </div>
        <div class=" tw-block tw-text-center tw-pt-8">
            <inertia-link href="/new-arrivals" class="!tw-whitespace-pre btn btn-lg btn-black">
                <button>
                    {{ __('See All New Arrivals') }}
                </button>
            </inertia-link>
        </div>
    </section>
</template>

<script>
import AddToQueueButton from '../../Components/Product/AddToQueueButton.vue'
import ProductCard from '../../Components/Product/NewSmallProductCard.vue'
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
        AddToQueueButton,
        ProductCard
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

<style lang="scss">
    @import "../../../scss/productDetails.scss";

    /* .form-control {
        padding: 5px 10px !important;
    } */
    .carousel__next,
    .carousel__prev {
        display: block !important;
    }

    .slide-enter-active {
        transition: transform 0.5s;
    }

    .product-img-box img {
        border: 0px !important;
    }

    .slide-enter {
        transform: translateX(100%);
    }

    .slide-leave-active {
        transition: transform 0.5s;
    }

    .slide-leave-to {
        transform: translateX(-100%);
    }

    .subscriptions-wrapper .product-quantity-price .img-thumbnail {
        width: 80px;
        height: 80px;
        border: 0;
    }

    @media (max-width: 425px) {
        .subscriptions-wrapper .product-quantity-price .img-thumbnail {
            width: 56px;
            height: 56px;
        }
    }

    .accordion-button:after {
        background-image: url("../../images/svg/Ico_Plus_Not_Circle.svg");
    }

    .accordion-button:not(.collapsed):after {
        background-image: url("../../images/svg/Ico_Minus.svg");
        transform: rotate(0deg) !important;
    }

    .cart-custom-btn {
        background: transparent;
        color: #000;
    }

    .cart-custom-btn:hover {
        background: transparent;
    }

    .progress-data {
        position: fixed;
    }

    .single-perfume-type-box.active {
        background: #f5f5f5 !important;
    }

    #disclaimerModal .modal-body p span,
    #disclaimerModal .modal-body p,
    #disclaimerModal .modal-body {
        font-family: "TT Norms Pro", sans-serif !important;
        font-size: 20px !important;
    }

    #disclaimerModal .modal-body p span strong {
        font-family: "TT Norms Pro", sans-serif !important;
        font-size: 20px !important;
    }

    a.pagination-page-link:not(:first-child):not(:last-child) {
        border-radius: 50%;
        width: 25px;
        height: 25px;
        text-align: center;
        display: block;
        color: #000;
    }

    a.pagination-page-link {
        color: #000;
    }

    .pagination-page-link-active {
        background-color: #000 !important;
        pointer-events: none;
    }

    .single-trending-note .img-thumbnail img {
        object-fit: contain;
    }

    .collection-section {
        background-color: #f9f9f9;
        border: none;
    }

    .product-feedback {
        margin-top: 0px;
    }

    @media (min-width: 992px) {
        .product-detail-navbar {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            transition: top 0.3s;
            background: #F9F9F9;
            z-index: 9;
        }
    }

    /* .ll-breadcrumbs-sec .container {
    max-width: 1320px;
    padding: 0px;
} */
    .breadcrumb-tab-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
    }

    .breadcrumb-tab-wrap .breadcrumb-wrap p {
        margin-bottom: 0px;
        padding: 16px 0px;
    }

    section {
        scroll-behavior: smooth !important;
    }


    .customRateClass {
        border-radius: 4px;
        border-color: blue;
    }

    @media (max-width: 767px) {
        .feedback-taxonomy-images {
            display: none;
        }

        .prodImage_thumbs {
            justify-content: start;
        }

        .main-notes__intro {
            width: 100%;
            margin: 0px;
        }

        section.review-summery,
        section.product-ratings,
        section.product-feedback {
            padding: 12px;
        }

        .ll-btn {
            font-family: "TT Norms Pro", sans-serif !important;
            width: max-content !important;
            font-size: 12px !important;
            padding: 6px 8px !important;
        }

        .product-quantity-price .btn-add-to-queue {
            margin-inline-start: auto !important;
        }

        .subscriptions-wrapper .product-quantity-price {
            padding: 8px 0px !important;
        }

        .subscriptions-wrapper .product-quantity-price .quantity-price-text h6 {
            display: flex !important;
            gap: 8px;
        }

        .subscriptions-wrapper .product-quantity-price .quantity-price-text span {
            font-family: "TT Norms Pro", sans-serif !important;
            font-size: 14px !important;
        }

        .product-quantity-price .btn-add-to-queue img {
            display: none;
        }

        .subscriptions-wrapper .product-quantity-price {
            gap: 8px;
        }
    }

    @media (max-width: 767px) {
        .product-details-content .product-title {
            font-size: 24px !important;
            line-height: 32px !important;
        }

        .product-details-content .product_brand__name {
            font-size: 18px;
            line-height: 28px;
        }

        .product-ratings h2 {
            font-size: 24px;
            line-height: 32px;
        }
    }

    .ad-text {
        font-size: 16px !important;
        line-height: 24px !important;
        padding: 16px 0px !important;
        display: block !important;
    }

    @media (max-width:525px) {
        .ad-text {
            font-size: 14px !important;
            line-height: 16px !important;
        }
    }

    @media (max-width:425px) {
        .ad-text {
            font-size: 12px !important;
            line-height: 16px !important;
        }
    }

    @media (max-width:374px) {
        .ad-text {
            font-size: 10px !important;
            line-height: 16px !important;
        }
    }



    .ll-mysterious-feeling-content1 {
        background-size: contain;
        background-position: center center;
        background-repeat: no-repeat;
        padding: 80px 0px;
        overflow: hidden;
    }

    @media (max-width: 1200px) {
        .ll-mysterious-feeling-content1 {
            background-size: cover;
        }

        .ll-mysterious-feeling-content-container {
            max-width: 524px;
            text-align: center;
        }
    }

    @media (min-width: 1024px) {
        .ll-mysterious-feeling-content-container {
            max-width: 524px;
            text-align: center;
        }
    }


    .ll-mysterious-feeling-content-container h3 {
        font-family: 'TT Norms Pro', sans-serif;
        font-weight: 600;
        font-size: 40px;
        line-height: 48px;
        color: #000000;
        margin-bottom: 24px;
    }

    .ll-mysterious-feeling-content-container p {
        font-family: 'TT Norms Pro', sans-serif;
        font-weight: 400;
        font-size: 20px;
        line-height: 28px;
        color: #000000;
        margin-bottom: 24px;
    }

    @media (max-width: 525px) {
        .ll-mysterious-feeling-content1 {
            padding: 40px 24px;
        }

        .ll-mysterious-feeling-content-container h3 {
            font-size: 24px;
            line-height: 32px;
        }
    }

    .carousel__viewport {
        margin: 0px 30px;
    }

    .section-title {
        h5 {
            color: #d5b76c
        }
    }

    /* Style for custom navigation buttons */
    .custom-navigation {
        background: #000;
        color: white;
        border-radius: 50%;
    }

    .custom-navigation.swiper-button-disabled {
        background-color: #dadada;
    }

    @media (max-width: 767px) {
        .custom-navigation {
            display: none;
        }
    }

    /* Your existing styles */

    /* Style for custom navigation buttons */
    .custom-navigation {
        background: #000;
        color: white;
        border-radius: 50%;
    }

    .custom-navigation.swiper-button-disabled {
        background-color: #dadada;
    }

    @media (max-width: 767px) {
        .custom-navigation {
            display: none;
        }
    }
</style>
