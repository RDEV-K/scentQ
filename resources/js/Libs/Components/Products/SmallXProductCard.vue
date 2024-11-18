<template>
    <div class="small-product-card tw-mx-3 tw-w-full !tw-bg-[#e5dbc2]">
        <Link as="div"
            :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })"
            class="cursor-pointer small-product-image">
        <img :src="product?.image?.url" class="img-fluid" :alt="product.title" />
        </Link>

        <Link as="div"
            :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })"
            class="cursor-pointer small-product-content">
        <div style="font-size: 16px; font-weight: 500;"
            class="notranslate mb-0 text-center !tw-truncate tw-text-ellipsis tw-w-full tw-block tw-overflow-hidden">
            {{ product.title }}
        </div>
        <div class="notranslate !tw-truncate text-center" style="color: rgb(120 120 120); font-size: 14px; font-weight: 300;">
            {{ product.brand?.name }}
        </div>
        <div class="product-rating !tw-mb-4 tw-mt-2">
            <star-rating :read-only="true" class="tw-flex tw-justify-center" active-color="#FF8A00" :increment="0.01"
                :fixed-points="2" :star-size="23" :rating="product.reviews_avg_rate" :show-rating="false"></star-rating>
        </div>
        <div class="product-card-action">
            <AddToQueueButton as="button" :product="product" class="btn btn-block btn-lg btn-black btn-add-to-queue">
                <template v-slot:default>
                    <span class="icon">
                        <plus-circle />
                    </span> <span class="sp-text !tw-font-light azn !tw-text-[10px] sm:!tw-text-sm">{{ __('Add To Queue')
                        }}</span>
                </template>
                <template v-slot:added>
                    <span class="icon">
                        <plus-circle />
                    </span> <span class="sp-text !tw-font-light azn !tw-text-[10px] sm:!tw-text-sm">{{ __('Added') }}</span>
                </template>
            </AddToQueueButton>
        </div>
        </Link>

        <div class="like-dis-like" v-if="likeable">
            <!--TODO: Make Like Works-->
            <button type="button" class="like-dis-like-btn liked">
                <img src="../../../../images/svg/like-dis-like/Ico_Dislike.svg" alt="dislike image" />
            </button>
            <button type="button" class="like-dis-like-btn">
                <img src="../../../../images/svg/like-dis-like/Ico_Like.svg" alt="like image" />
            </button>
        </div>
    </div>
</template>

<script>
    import AddToQueueButton from '../../../Components/Product/AddToQueueButton.vue'
    import {
        Link
    } from "@inertiajs/inertia-vue3";
    import PlusCircle from "../../../Components/SVG/PlusCircle.vue";
    import StarRating from 'vue-star-rating'

    export default {
        props: {
            product: Object,
            likeable: {
                type: Boolean,
                default: false
            }
        },
        components: {
            AddToQueueButton,
            Link,
            PlusCircle,
            StarRating
        },
        computed: {
            crate() {
                if (!this.product.reviews_avg_rate) return 0;
                return parseInt(this.product.reviews_avg_rate);
            }
        }
    }
</script>

<style>
    @media (max-width: 767px) {
        .small-product-card {
            padding: 10px 20px;
        }

        .product-card-action .btn {
            font-family: 'TT Norms Pro', sans-serif;
            font-weight: 400;
            font-size: 12px !important;
        }

        .small-product-card .small-product-image img {
            height: 120px;
        }

        .small-product-card .small-product-image {
            /* margin-bottom: 16px; */
        }

        .small-product-card .small-product-content p,
        .small-product-card .small-product-content h5 {
            font-family: 'TT Norms Pro', sans-serif;
            font-weight: normal;
            height: auto;
            font-size: 16px;
        }

        .small-product-card .small-product-content p {
            opacity: 70%;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .product-card-action .icon {
            display: none;
        }

        .product-card-action .btn-lg {
            font-size: 14px;
            line-height: 20px;
            padding: 6px 0px;
        }
    }

    .product-rating {
        justify-content: center;
    }
</style>
