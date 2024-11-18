<template>
    <section class="your-queue tw-mb-20">
        <div class="container">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <section class="buy-queue">
                        <div class="row">
                            <div class="col-lg-8">
                                <h2>{{ __('Buy Products From Your Queue — Save ⏰ And 💰') }}</h2>
                                <p>
                                    You have {{ queue_items.length }} products in your queue. Why wait {{ monthCount }}
                                    months if
                                    you can get them right now and save? Our prices drop as you
                                    add more products to your cart. {{ minCount }} products minimum.
                                </p>
                            </div>
                        </div>
                    </section>
                    <div class="row !tw-flex-col-reverse xl:!tw-flex-row tw-py-6">
                        <div class="col-12 col-md-12 col-xl-8">
                            <section class="tw-mt-10 tw-mb-10" v-if="queue_items.length">
                                <div class="row">
                                    <h3>
                                        {{ __('Your Queue') }}
                                    </h3>
                                </div>

                                <div class="row gx-3 gx-sm-4">
                                    <div v-for="(queue_item, queue_item_index) in queue_items" :key="queue_item_index"
                                        class="col-6 col-sm-6 col-xl-4">
                                        <div class="single-queue-product cursor-pointer"
                                            @click.prevent="inCart(queue_item.product_id) ? null : addToTemp(queue_item_index)">
                                            <div class="queue-product-img !tw-bg-secondary"
                                                :class="{ 'selected-queue !tw-bg-secondary': inCart(queue_item.product_id) }">
                                                <div class="img--thumbnail2 border-0 text-center">
                                                    <img :src="queue_item?.product?.image?.url" class="img-fluid"
                                                        :alt="queue_item?.product?.title" />
                                                </div>
                                                <div class="queue-btn-box">
                                                    <button v-if="inCart(queue_item.product_id)" type="button"
                                                        class="btn lh-1 check-icon">
                                                        <img src="../../images/svg/Queue/Ico_Check-new.svg"
                                                            class="img-fluid" alt="added" />
                                                    </button>
                                                    <button v-else type="button" class="btn btn-black lh-1 queue-icon">
                                                        <img src="../../images/svg/Ico_square_Plus.svg"
                                                            class="img-fluid" alt="add to cart" />
                                                    </button>
                                                </div>
                                            </div>
                                            <h5 class="notranslate">
                                                {{ queue_item.product.brand.name }}
                                            </h5>
                                            <p class="notranslate">
                                                {{ queue_item.product.title }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-12 col-md-12 col-xl-4">
                            <div class="!tw-bg-secondary py-4">
                                <div class="md:tw-block px-4" v-if="cart_items.length">
                                    <h6 class="tw-text-xl mb-4">
                                        {{ __('Your Cart') }}
                                    </h6>
                                    <ul class="tw-p-0 tw-flex tw-flex-col tw-gap-4 tw-mb-6">
                                        <li v-for="(cartItem, cartItemIndex) in cart_items" :key="cartItemIndex">
                                            <div class="tw-flex tw-gap-3 tw-items-center">
                                                <div class="tw-w-14 tw-object-cover">
                                                    <img :src="cartItem?.product?.image?.url"
                                                        :alt="cartItem?.product?.title"
                                                        class="tw-w-full tw-h-full tw-object-cover">
                                                </div>
                                                <div class="tw-flex-auto notranslate">
                                                    <h3 class="tw-text-base tw-text-black tw-font-semibold tw-mb-1">
                                                        {{ cartItem.product.brand.name }}
                                                    </h3>
                                                    <p class="tw-text-sm tw-font-medium tw-mb-0">
                                                        {{ cartItem.product.title }}
                                                    </p>
                                                </div>
                                                <button @click.prevent="removeItem(cartItemIndex)">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 4L4 12M4 4L12 12" stroke="#808080" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="cart-actions tw-px-4 !tw-flex tw-justify-center">
                                    <button :disabled="cart_items.length < minCount || queuePurchaseForm.processing"
                                        @click.prevent="addToCart"
                                        :class="cart_items.length < minCount ? 'btn-black-outline' : 'btn-black'"
                                        class="btn btn-lg tw-w-full !tw-px-0 btn-long disabled:!tw-cursor-not-allowed">
                                        <span v-if="showSinglePrice">
                                            {{ __('Buy now') }}
                                            <span> {{ currencyConvert(showSinglePrice) }}
                                            </span>
                                        </span>
                                        <span v-else>
                                            {{ __('Buy now') }}
                                            <span v-if="discountAmount > 0">
                                                and save {{ currencyConvert(discountAmount) }}
                                            </span>
                                            <span v-else>
                                                and save {{ currencyConvert(0.00) }}
                                            </span>
                                        </span>
                                    </button>

                                    <p v-if="cart_items.length < minCount">
                                        You have to select at least {{ minCount }} products
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { Link } from "@inertiajs/inertia-vue3";
    import UserPage from '../Layouts/UserPage.vue'
    import Progress from "@/Libs/Components/ProgressBar.vue";
    import 'vue3-carousel/dist/carousel.css'
    import QueueProduct from "../../images/products/queue-product-01.png";

    export default {
        components: {
            Link,
            Progress,
        },
        props: {
            queue_items: Array,
            policies: Array,
            max_count: Number
        },
        data() {
            return {
                cart_items: [],
                discountAmount: 0,
                showSinglePrice: null,
                queuePurchaseForm: this.$inertia.form({
                    items: [],
                    policy_id: null
                }),
                QueueProduct: QueueProduct,
            }
        },
        watch: {
            cart_items: {
                deep: true,
                handler(val, oldVal) {
                    if (val.length > 1) {
                        this.showSinglePrice = null;
                    } else {
                        this.showSinglePrice = val[0]?.product?.additional_price;
                    }
                },
            },
        },
        methods: {
            addToTemp(queue_item_index) {
                let amount = this.cart_items.length + 1;
                if (amount > 1) {
                    this.discountAmount = this.discountAmount + Number(this.policies[0].discount)
                }
                console.log(amount);
                this.cart_items.push(this.queue_items[queue_item_index])
            },
            inCart(product_id) {
                // console.log(product_id);
                return this.cart_items.find((item, index) => item.product_id === product_id);
            },
            removeItem(cartItemIndex) {
                this.cart_items.splice(cartItemIndex, 1);
                let amount = this.cart_items.length + 1;
                if (amount > 1) {
                    this.discountAmount = this.discountAmount - Number(this.policies[0].discount)
                }
            },
            addToCart() {
                this.queuePurchaseForm.items = this.cart_items.map(cartItem => ({
                    product_id: cartItem.product_id,
                    purchase_option_id: cartItem.product?.purchase_options[0]?.id
                }))
                if (this.policies.length) {
                    this.queuePurchaseForm.policy_id = this.policies[0].id
                }
                this.queuePurchaseForm.post(this.route('queue.purchase.store'))
            }
        },
        computed: {
            // monthCount() {
            //     return Math.ceil((this.queue_items.length / this.max_count))
            // },
            minCount() {
                const arr = this.policies.map(policy => Number(policy.minimum_count))
                const min = Math.min(...arr)
                return isNaN(min) ? 0 : min;
            },
            // total() {
            //     return this.cart_items.reduce((acc, curr) => {
            //         const price = curr?.product?.purchase_options[0]?.price ?? 0
            //         return acc + Number(price)
            //     }, 0)
            // },
            // eligiblePolicies() {
            //     return this.policies.filter((policy) => {
            //         return policy.minimum_count <= this.cart_items.length && policy.maximum_count >= this.cart_items.length
            //     })
            // },
            // discountAmount() {
            //     let flatDiscount = 0
            //     if (this.policies.length) {
            //         flatDiscount = flatDiscount + (Number(this.policies[0].discount))
            //     }
            //     return flatDiscount;
            // },
            // gross() {
            //     return (this.total - this.discountAmount).toFixed(this.config.misc.round)
            // }
        },
        layout: UserPage,
    }
</script>

<style lang="scss">
    @import "../../scss/buyYourQueue.scss";

    .img--thumbnail2 {
        padding: 0.25rem;
        border: 1px solid #dee2e6;
        max-width: 100%;
        height: auto;
    }

    .single-queue-product .queue-product-img div.img--thumbnail2 img {
        max-width: 150px !important;
    }
</style>