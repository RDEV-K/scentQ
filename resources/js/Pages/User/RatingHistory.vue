<template>
    <section class="profile profile-content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-xl-4 d-none d-md-block">
                    <sidebar />
                </div>

                <div class="col-md-7 col-xl-8 !md:tw-ps-16">
                    <h2 class="!tw-text-2xl tw-mb-6 tw-font-medium">
                        {{ __('Rating & Review') }}
                    </h2>
                    <div class="tw-grid tw-grid-cols-1 tw-gap-6 lg:tw-grid-cols-2">
                        <template v-if="ratings?.data?.length > 0">
                            <template v-for="(item, index) in ratings?.data" :key="index">
                                <div>
                                    <inertia-link as="div"
                                        :href="route('product', { productType: item?.product?.type, brandSlug: item?.product?.brand.slug, productSlug: item?.product?.slug })"
                                        class="tw-cursor-pointer tw-flex tw-gap-2.5 tw-items-center tw-px-4 tw-py-3 tw-bg-[#DBCEAD]">
                                        <img class="tw-h-12" :src="item?.product?.image?.url" alt="">
                                        <div>
                                            <h4 class="!tw-text-base !tw-mb-0">
                                                {{ item?.product?.title }}
                                            </h4>
                                        </div>
                                    </inertia-link>
                                    <div class="tw-p-6 tw-bg-[#F7F0E9]">
                                        <h4 class="tw-text-xl tw-font-medium tw-mb-3.5">
                                            {{ item?.title }}
                                        </h4>
                                        <div class="tw-flex tw-items-center tw-gap-1 tw-mb-3">
                                            <star-rating :read-only="true" class="tw-flex tw-justify-center"
                                                active-color="#FF8A00" :increment="0.01" :fixed-points="2"
                                                :star-size="20" :rating="item?.rate" :show-rating="true"></star-rating>
                                        </div>
                                        <p class="tw-text-base tw-mb-6">
                                            {{ item?.content }}
                                        </p>
                                        <div>
                                            <button @click="goEdit(item)" type="button"
                                                class="tw-inline-flex !tw-whitespace-nowrap tw-items-center tw-text-black tw-no-underline tw-gap-1.5 tw-text-sm tw-font-medium">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M16.862 4.487L18.549 2.799C18.9007 2.44733 19.3777 2.24976 19.875 2.24976C20.3723 2.24976 20.8493 2.44733 21.201 2.799C21.5527 3.15068 21.7502 3.62766 21.7502 4.125C21.7502 4.62235 21.5527 5.09933 21.201 5.451L10.582 16.07C10.0533 16.5984 9.40137 16.9867 8.685 17.2L6 18L6.8 15.315C7.01328 14.5986 7.40163 13.9467 7.93 13.418L16.862 4.487ZM16.862 4.487L19.5 7.125M18 14V18.75C18 19.3467 17.7629 19.919 17.341 20.341C16.919 20.763 16.3467 21 15.75 21H5.25C4.65326 21 4.08097 20.763 3.65901 20.341C3.23705 19.919 3 19.3467 3 18.75V8.25C3 7.65327 3.23705 7.08097 3.65901 6.65901C4.08097 6.23706 4.65326 6 5.25 6H10"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span>{{ __('Edit') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <template v-else>
                            <div class="tw-col-span-full tw-text-gray-500 tw-text-center tw-text-sm">
                                {{ __('No Rating & Review Found.') }}
                            </div>
                        </template>
                    </div>
                    <template v-if="ratings?.total > currentAmount">
                        <inertia-link preserveScroll :href="route('rating-history', { amount: amount })"
                            class="text-center tw-flex tw-justify-center tw-items-center tw-no-underline tw-mt-6">
                            <button
                                class="tw-border tw-border-black tw-inline-flex tw-h-14 tw-py-4 tw-px-10 tw-font-TT-Norms tw-tracking-[0.77px] tw-text-base !tw-text-black tw-font-semibold">
                                {{ __('View More Review') }}
                            </button>
                        </inertia-link>
                    </template>
                </div>
            </div>
        </div>
        <!-- review set modal  -->
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content !tw-mb-24 lg:!tw-mb-0 !tw-bg-secondary">
                    <div @click="showModal = false" class="modal-header border-0 p-0">
                        <button type="button" class="btn-close p-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="container">
                            <div>
                                <h3 class="modal-title">
                                    Edit your feedback
                                </h3>
                                <p class="modal-description">
                                    Tell us what you thought of this product!
                                </p>
                            </div>

                            <div class="review-item-infograph">
                                <div>
                                    <img :src="editReview?.product?.image?.url" style="width: 80px; height: 80px"
                                        :alt="editReview?.product?.title" />
                                </div>

                                <div>
                                    <p>{{ editReview?.product?.brand?.name }}</p>
                                    <small>{{ editReview?.product?.title }}</small>
                                </div>
                                <div>
                                    <div class="product-rating">
                                        <star-rating active-color="#FF8A00"
                                            v-model:rating="reviewForm.rate"></star-rating>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h5>Tell us some specific details</h5>

                                <form class="mt-3 review-form">
                                    <div class="mb-3">
                                        <input type="text" class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black" :class="{ 'is-invalid': errors.title }"
                                            placeholder="Title" required v-model="reviewForm.title" />
                                        <div class="invalid-feedback" v-if="errors.title">
                                            {{ errors.title }}
                                        </div>
                                    </div>

                                    <div>
                                        <textarea class="form-control"
                                            placeholder="Example: The notes in the scent were exactly what I had imagined. It smelled just as spicy as I thought it would, I really love it and gets tons of compliments!"
                                            style="height: 150px" v-model="reviewForm.content
                                                "></textarea>
                                    </div>

                                    <button class="mt-4 choose-btn btn btn-black py-3 cathrine-monthly-btn"
                                        @click.prevent="updateReview" :disabled="reviewForm.processing
                                            ">
                                        Update review
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import UserPageVue from '@/Layouts/UserPage.vue'
    import Sidebar from '@/Layouts/Partials/Sidebar.vue'
    import Star from "../../Components/SVG/BlackStar.vue"
    import StarRating from 'vue-star-rating'
    import { Link, useForm } from "@inertiajs/inertia-vue3";
    import Pagination from '@/Components/Pagination.vue';

    export default {
        components: { Sidebar, Star, StarRating, Pagination },
        layout: UserPageVue,
        props: {
            errors: Object,
            ratings: Object
        },
        data() {
            return {
                modal: null,
                showModal: false,
                amount: 10,
                currentAmount: 10,
                editReview: null,
                reviewForm: useForm({
                    title: null,
                    content: null,
                    rate: 1,
                    _method: 'PUT'
                })
            }
        },
        mounted() {
            if (this.getSearchParams('amount')) {
                this.amount = parseInt(this.getSearchParams('amount')) + 6;
                this.currentAmount = parseInt(this.getSearchParams('amount'));
                // console.log(this.getSearchParams('amount'));
            }
        },
        methods: {
            getSearchParams(k) {
                var p = {};
                location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (s, k, v) { p[k] = v })
                return k ? p[k] : p;
            },
            goEdit(item) {
                this.editReview = item;

                this.reviewForm.title = item?.title;
                this.reviewForm.content = item?.content;
                this.reviewForm.rate = item?.rate;

                // open modal
                if (this.modal) {
                    this.modal.hide();
                }
                this.modal = new window.bootstrap.Modal("#reviewModal");
                this.modal.show();
            },
            updateReview() {

                this.reviewForm.post(this.route("review.update", this.editReview?.id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        if (this.modal) {
                            this.modal.hide();
                        }
                    },
                    onError: () => {
                        this.modal.show();
                    }
                });
            }
        }
    }
</script>

<style lang="scss">
    @import "../../../scss/productDetails.scss";
    @import "../../../scss/tracking.scss";

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
        margin-bottom: 35px;
    }

    .collection-section,
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

    .tabs {
        display: flex;
    }

    .tabs ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 16px;
    }

    @media (max-width: 991px) {
        .tab-wrap {
            display: none;
        }
    }

    .tabs li a {
        cursor: pointer;
        padding: 16px 0px 14px;
        border-bottom: 2px solid transparent;
        font-family: "TT Norms Pro", sans-serif;
        text-decoration: none;
        font-style: normal;
        font-weight: 500;
        font-size: 15px;
        display: inline-flex;
        line-height: 24px;
        color: #666666;
    }

    section {
        scroll-behavior: smooth !important;
    }

    .tabs li.active a {
        color: #000000;
        border-bottom-color: #000000;
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

        .peoples-Prefer.collection-section,
        .main-notes.collection-section,
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
</style>
