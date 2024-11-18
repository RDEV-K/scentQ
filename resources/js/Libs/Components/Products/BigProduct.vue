<template>
    <div
        class="product-card sm:!tw-p-6 !tw-p-3 sm:!tw-pt-4 tw-h-full tw-flex tw-flex-col tw-justify-between tw-overflow-hidden tw-text-center">
        <!-- <AddToQueueButton as="button" :product="product" class="btn btn-black add-btn">
            <img src="../../../../images/svg/Ico_square_Plus.svg" alt="add to queue" class="img-fluid">
        </AddToQueueButton> -->
        <inertia-link class="tw-no-underline cursor-pointer" :as="isSubscribed ? 'a' : 'button'"
            :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })"
            disabled="true">
            <div class="product-image !tw-text-center">
                <img v-lazy="product.image.url" :alt="product.title"
                    class="!tw-w-auto !tw-object-contain sm:!tw-h-[280px] !tw-h-[122px]" />
                <div class="badges" v-for="(badge, badgeIndex) in product.badges" :key="badgeIndex"><img
                        v-lazy="badge.image" :alt="badge.name" /></div>
            </div>
            <div class="product-meta">
                <!--            <h6>{{ product . title }}</h6>-->
                <h3 class="notranslate !tw-whitespace-normal tw-break-words tw-line-clamp-2 !tw-font-bold !tw-uppercase sm:!tw-text-xl !tw-text-base !tw-leading-[100%] !tw-text-gold-50 tw-mb-1">{{
                    product.title }}</h3>
                <h6 class="notranslate !tw-whitespace-normal !tw-text-sm !tw-text-black !tw-opacity-100">{{ product.brand.name }}
                </h6>
                <!-- <h6 v-if="product.retail_value">
                {{ __('Retail Price: %s%s', config . misc . currency_symbol, product . retail_value) }}
            </h6> -->
            </div>
            <div class="product-notes !tw-mt-4" v-if="product.notes">
                <div class="product-note" v-for="(note, noteIndex) in displayableNotes(product.notes)" :key="noteIndex"
                    :title="note.name">
                    <div class="note-image"><img v-lazy="note.image" :alt="note.name" /></div>
                    <span>{{ note.name }}</span>
                </div>
            </div>
            <article class="meta-text !tw-h-auto tw-my-4">
                <span v-html="excerpt(product.content)"
                    class="product-card-content !tw-text-center !tw-line-clamp-3 !tw-font-TT-Norms !tw-font-light"></span>
                <!--         <span>{{ product . excerpt }}</span>...
           <Link :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })">{{ __('Read more') }}</Link>-->
            </article>
        </inertia-link>

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
    </div>
</template>

<script>
    import {
        Link, usePage
    } from "@inertiajs/inertia-vue3";
    import AddToQueueButton from "@/Components/Product/AddToQueueButton.vue";
    import PlusCircle from "../../../Components/SVG/PlusCircle.vue";

    export default {
        props: {
            product: Object,
            filter: Object,
        },
        components: {
            Link,
            AddToQueueButton,
            PlusCircle
        },
        methods: {
            excerpt(string, limit = 150) {
                if (!string) return;
                string = string.replace(/<\/?[^>]+>/ig, ""); // Html Stripe Tags
                // string = string.replace(/&nbsp/ig, ""); // Html Stripe Tags
                // string = string.replace(';','')
                const specialEntitiesCount = (string.match(/&[a-z]{2,5};/ig) || []).length
                // console.log(limit+specialEntitiesCount)

                return string.slice(0, limit + specialEntitiesCount) + '...';
                // return string.substr(0, string.lastIndexOf(" ", (limit+specialEntitiesCount)))
                // return string.substr(0, string.lastIndexOf(" ", (limit+specialEntitiesCount)))
            },
            displayableNotes(notes) {
                if (!notes || !notes.length) return [];
                let amount = this.filter && (this.filter.type === 'perfume' || this.filter.type === 'men' || this.filter.type === 'women' || this.filter.type === 'cologne') ? 3 : 4;
                if (notes.length <= amount ?? 4) return notes;
                let listed_notes = [];

                for (let i = 0; i < amount ?? 4; i++) {
                    listed_notes.push(notes[i]);
                }
                return listed_notes;
            },
        },
        computed: {
            crate() {
                if (!this.product.reviews_avg_rate) return 0;
                return parseInt(this.product.reviews_avg_rate);
            },
        },
        mounted() {
            console.log();
        }
    }
</script>

<style>
    @media (max-width: 767px) {
        .product-card-action .btn {
            font-family: 'TT Norms Pro', sans-serif;
            font-weight: 400;
            font-size: 12px !important;
        }

        .product-card .product-image>img {
            height: 140px;
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

    .product-card-action .icon {
        display: none;
    }

    .product-card-content {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
