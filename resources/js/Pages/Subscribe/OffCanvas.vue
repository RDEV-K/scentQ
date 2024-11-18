<template>
    <div class="tw-fixed tw-z-[9999999] md:tw-pt-6 md:tw-px-8 tw-p-3 tw-w-full tw-max-w-[464px] tw-overflow-y-auto tw-bg-white tw-end-0 tw-top-0 tw-h-full tw-transition-all tw-duration-300"
        :class="cartOffcanvas ? 'tw-translate-x-0 offcanvas-active' : 'tw-translate-x-full'">
        <div class="tw-flex tw-justify-between tw-items-center">
            <h2 class="tw-text-xl tw-mb-0">
                Want to try something else
            </h2>
            <button @click="emitStatus(false)">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="#161719" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <p class="tw-text-base tw-mt-4 tw-mb-0">
            Add one of our best sellers for your first shipment.
        </p>
        <div class="tw-relative tw-mt-3">
            <div class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-pl-3.5 tw-pointer-events-none">
                <img src="/images/MagnifyingGlass2.svg" alt="MagnifyingGlass2">
            </div>
            <input v-model="keyword" type="text"
                class="tw-bg-white tw-border-b focus:tw-outline-none tw-border-gold-50 tw-text-gray-900 tw-text-sm  tw-block tw-w-full tw-pl-10 tw-p-3"
                placeholder="Search">
        </div>
        <div class="tw-grid tw-grid-cols-2 tw-gap-4 tw-mt-3">
            <div v-for="(product, index) in products" class="" :key="index">
                <ProductCard :product="product">
                    <template #button>
                        <template v-for="(purchaseOption, purchaseOptionIndex) in product.purchase_options"
                            :key="purchaseOptionIndex">

                            <button type="button"
                                @click.prevent="readyToAddToCart(product, product.purchase_options[purchaseOptionIndex])" class="!tw-w-full">
                                <template v-if="added == 'added' + purchaseOption.id">
                                    <button v-if="product.purchase_options[purchaseOptionIndex].type === 'subscription'"
                                        type="button"
                                        class="!tw-bg-black tw-flex tw-justify-center tw-items-center tw-gap-2 !tw-text-white !tw-w-full !tw-text-sm !tw-px-2 !tw-h-[38px]">
                                        <div class="md:!tw-text-sm tw-text-[#e0ad7d] !tw-text-xs tw-whitespace-nowrap">
                                            Selected
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15.632" height="11.141"
                                                viewBox="0 0 15.632 11.141">
                                                <path id="Ico_Check"
                                                    d="M13.616,4.316,5.192,12.739a.61.61,0,0,1-.864,0L1.071,9.479a.61.61,0,0,0-.864,0h0a.61.61,0,0,0,0,.864L3.466,13.6a1.834,1.834,0,0,0,2.591,0L14.48,5.179a.61.61,0,0,0,0-.863h0a.61.61,0,0,0-.864,0Z"
                                                    transform="translate(0.472 -3.637)" fill="#e0ad7d" stroke="#e0ad7d"
                                                    stroke-width="1" />
                                            </svg>
                                        </div>
                                    </button>
                                </template>
                                <template v-else>
                                    <button v-if="product.purchase_options[purchaseOptionIndex].type === 'subscription'"
                                        type="button"
                                        class="!tw-bg-black !tw-text-white !tw-w-full !tw-text-sm !tw-px-2 !tw-h-[38px]">
                                        <span class="md:!tw-text-sm !tw-text-xs azn tw-whitespace-nowrap">
                                            LET'S TRY THIS
                                        </span>
                                    </button>
                                </template>
                            </button>

                            <!-- <AddToCartButton
                                class="!tw-bg-black tw-hidden !tw-text-white !tw-w-full !tw-text-sm !tw-px-2 !tw-h-[38px] tw-mt-1"
                                v-if="product.purchase_options[purchaseOptionIndex].type === 'subscription'"

                                :product="product" :purchase-option="product.purchase_options[purchaseOptionIndex]"

                                @click.prevent="selectedPurchaseOption" :openCart="false"
                                :subscribePlanType="subscribePlanType" :replaceItem="replaceItem"
                                :ref="'addToCartFire' + purchaseOptionIndex">
                                <span class="md:!tw-text-sm !tw-text-xs azn tw-whitespace-nowrap">
                                    LET'S TRY THIS
                                </span>
                            </AddToCartButton> -->
                        </template>
                    </template>
                </ProductCard>
            </div>
        </div>
        <button type="button" @click="addToCart()" class="tw-w-full tw-sticky tw-bottom-0 tw-pb-12 tw-bg-white">
            <button class="tw-w-full btn-black tw-text-white tw-text-base tw-h-14 tw-mt-4" :class="opacityClass">
                Continue
            </button>
        </button>
    </div>
    <div @click="emitStatus(false)" :class="cartOffcanvas ? 'offcanvas-active' : 'tw-hidden'"
        class="tw-fixed tw-z-30 tw-top-0 tw-end-0 tw-w-full tw-h-full tw-bg-black/50">
    </div>
</template>

<script>
import ProductCard from '../../Components/Product/NewSmallProductCard.vue'
import axios from "axios";
import AddToCartButton from "@/Components/Product/AddToCartButton.vue";

export default {
    props: {
        cartOffcanvas: Boolean,
        subscribePlanType: String,
        replaceItem: String
    },
    components: { ProductCard, AddToCartButton },
    data() {
        return {
            products: [],
            keyword: '',
            opacityClass: 'tw-opacity-30',
            added: '',
            cartForm: this.$inertia.form({
                product_id: null,
                purchase_option_id: null,
                attrs: null,
                subscribe_plan_type: null,
                replaceItem: null
            }),
        }
    },
    mounted() {
        this.fetchData()
    },
    watch: {
        keyword: {
            handler(keyword) {
                setTimeout(() => {
                    this.fetchData(keyword);
                }, 100);
            },
            immediate: true,
        },
        cartOffcanvas:{
            handler(keyword) {
                this.fetchData(keyword);
            },
            immediate: true,
        }
    },
    methods: {
        readyToAddToCart(product, purchaseOption) {
            this.cartForm.product_id = product.id;
            this.cartForm.purchase_option_id = purchaseOption?.id;
            this.cartForm.subscribe_plan_type = this.subscribePlanType;
            this.cartForm.replaceItem = this.replaceItem;
            this.added = 'added' + purchaseOption.id;
            this.opacityClass = 'tw-opacity-100';
        },
        emitStatus(status) {
            this.$emit('status', status);
        },
        async fetchData(keyword = null) {
            try {
                const { data } = await axios.get(route('api.get.new.products', { 'keyword': keyword }));
                this.products = data;
            } catch (e) {
                console.error(e);
            }
        },
        addToCart() {
            this.cartForm.post(this.route("cart-item.store"), {
                preserveScroll: true,
                onSuccess: (data) => {
                    this.added = true;
                    this.opacityClass = 'tw-opacity-30';
                    this.$emit('status', false);
                    setTimeout(() => {
                        this.added = false
                    }, 3000)
                }
            });

            // Trigger Facebook Pixel 'AddToCart' event
            fbq('track', 'AddToCart');

            if (this.openCart) {
                setTimeout(function () {
                    document.querySelector(".cart-icon").click();
                    // return router.get(this.route('checkout'));
                }, 2000);
            }
        },

    }
}
</script>
