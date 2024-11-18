<template>
    <div scroll-region>

        <div class="checkout-info md:!tw-mt-0">
                <h3 class="tw-font-bold tw-text-[#212529] !tw-text-sm tw-leading-[100%] tw-uppercase !tw-mt-0 !tw-mb-4">
                    {{ __('Subscription Type') }}
                </h3>
                <div v-for="(item, index) in all_plans" :key="item.id" class="tw-py-0.5">

                    <label :for="'plan' + item.id" class="subs_type__radio tw-flex tw-justify-between tw-items-center tw-border-2 tw-rounded-md tw-py-2.5 tw-px-4 tw-cursor-pointer" :class="selectPlan == item?.id ? 'tw-border-gold' : 'tw-border-gray-200'">
                        <input type="radio" @change="getPlan(item.id)" name="subscription_type" :id="'plan' + item.id" :checked="select_plan == item.id ||  item?.is_default" hidden>
                        <div class="tw-flex tw-justify-center tw-items-center tw-gap-3 tw-text-black tw-font-bold">
                            <template v-if="item?.product_count == 3">
                                <img class="tw-w-14" src="../../../images/product3.png" alt="product3">
                            </template>
                            <template v-else-if="item?.product_count == 2">
                                <img class="tw-w-14" src="../../../images/product2.png" alt="product2">
                            </template>
                            <template v-else>
                                <img class="tw-w-14" src="../../../images/product1.png" alt="product1">
                            </template>
                           <div>
                            {{ item?.product_count }} {{ __('Product') }}{{ item?.product_count > 1 ? 's' : '' }} / {{ __('Month') }} - <span class="tw-text-gold"> {{ currencyConvert(item?.total_price) }} </span>
                           </div>
                        </div>
                        <div v-if="selectPlan == item?.id">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15.632" height="11.141" viewBox="0 0 15.632 11.141">
                                <path id="Ico_Check"
                                    d="M13.616,4.316,5.192,12.739a.61.61,0,0,1-.864,0L1.071,9.479a.61.61,0,0,0-.864,0h0a.61.61,0,0,0,0,.864L3.466,13.6a1.834,1.834,0,0,0,2.591,0L14.48,5.179a.61.61,0,0,0,0-.863h0a.61.61,0,0,0-.864,0Z"
                                    transform="translate(0.472 -3.637)" fill="#e0ad7d" stroke="#e0ad7d" stroke-width="1" />
                            </svg>
                        </div>
                    </label>
                </div>
                <br>
            <div class="queue-list tw-bg-secondary p-3 tw-rounded">
                <!-- subscription product  -->
                <template v-if="user_with_cart.cart.subscribe_items > 0">
                    <div>
                        <p class="!tw-mb-2 tw-font-medium !tw-text-sm md:!tw-text-base tw-text-black">
                            {{ __('You are getting...') }}
                        </p>
                        <p class="mb-4 !tw-text-xs d-flex tw-items-center tw-gap-4">
                            {{ __('A month-to-month subscription to ScentQ. Billed monthly, renews automatically, and ships from our warehouse mid - month.') }}
                        </p>
                        <p class="what-u-r-getting-p tw-mb-2.5" style="text-transform:uppercase;">
                            {{ arrivesInMonth() }} {{ __('Order') }}
                        </p>
                    </div>
                    <div v-for="(cartItem, cartItemIndex) in user_with_cart.cart.items" :key="cartItemIndex">
                        <div v-if="user_with_cart.cart.subscribe_items > 0 && cartItem.purchase_option_type == 'subscription'" class="cart_item" style=" border:none;position: relative;" :style="cartItemIndex == 0 ?'margin-top: 0rem' : 'margin-top: 0.5rem'">
                            <div class="d-flex justify-content-between align-items-center"
                                :class="user_with_cart.cart.items.length > 1 && user_with_cart.cart.items.length !== cartItemIndex + 1 ? 'tw-mb-6' : ''">
                                <div class="tw-flex tw-gap-3 tw-justify-center tw-items-center">
                                    <div
                                        class="tw-inline-flex tw-justify-center tw-items-center tw-w-12 tw-h-12 md:tw-w-16 md:tw-h-16 tw-max-w-[64px] tw-max-h-[64px]">
                                        <img class="tw-w-full tw-h-full tw-object-contain"
                                            :src="cartItem?.product?.image?.url" :alt="cartItem.product.title" />
                                    </div>
                                    <div class="notranslate">
                                        <h6 class="tw-text-sm md:tw-text-lg tw-font-bold tw-mb-2 tw-text-black">
                                            {{ cartItem.product.title }}
                                            <span v-if="cartItem.attrs" v-html="attrStr(cartItem.attrs)"></span>
                                        </h6>
                                        <p class="!tw-text-xs md:!tw-text-base tw-font-normal tw-mb-0 tw-text-black">
                                            {{ cartItem.product.brand.name }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" @click="emitStatus(true, cartItem.id)"
                                        class="tw-text-base !tw-whitespace-nowrap tw-text-black tw-cursor-pointer tw-underline tw-font-bold">
                                        {{ __('Edit') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template v-if="plan.product_count - user_with_cart.cart.subscribe_items > 0">
                        <template v-for="left in (plan.product_count ?? 0) - (user_with_cart.cart.subscribe_items ?? 0)">
                            <div @click="emitStatus(true)"
                                class="tw-cursor-pointer tw-mt-[0.5rem] tw-flex tw-gap-4 tw-justify-start tw-items-center md:tw-py-4 tw-py-2 md:tw-px-6 tw-px-3 tw-bg-secondary">
                                <div
                                    class="tw-w-[64px] tw-min-w-[64px] tw-h-[64px] tw-min-h-[64px] tw-inline-flex tw-justify-center tw-items-center">
                                    <img src="../../../images/product-Icon.png" class="tw-w-full tw-h-full tw-object-contain"
                                        alt="" />
                                </div>
                                <div>
                                    <h6 class="tw-text-sm md:tw-text-lg tw-font-bold tw-mb-2 tw-text-black">
                                        {{ __('Pick Your Scent') }}
                                    </h6>
                                    <p class="tw-text-base tw-font-normal tw-mb-0 tw-text-black">
                                        {{ __('Should this slot be empty, we will deliver our specially curated Fragrance of the Month to you.') }}
                                    </p>
                                </div>
                            </div>
                        </template>
                    </template>
                </template>
                <template v-else>
                    <template v-if="plan.product_count - user_with_cart.cart.subscribe_items > 0">
                        <template v-for="left in (plan.product_count ?? 0) - (user_with_cart.cart.subscribe_items ?? 0)">
                            <div @click="emitStatus(true)"
                                class="tw-cursor-pointer tw-mt-[0.5rem] tw-flex tw-gap-4 tw-justify-start tw-items-center tw-py-4 tw-px-6 tw-bg-secondary">
                                <div
                                    class="tw-w-[64px] tw-min-w-[64px] tw-h-[64px] tw-min-h-[64px] tw-inline-flex tw-justify-center tw-items-center">
                                    <img src="../../../images/product-Icon.png" class="tw-w-full tw-h-full tw-object-contain"
                                        alt="" />
                                </div>
                                <div>
                                    <h6 class="tw-text-sm md:tw-text-lg tw-font-bold tw-mb-2 tw-text-black">
                                        {{ __('Pick Your Scent') }}
                                    </h6>
                                    <p class="tw-text-base tw-font-normal tw-mb-0 tw-text-black">
                                        {{ __('Should this slot be empty, we will deliver our specially curated Fragrance of the Month to you.') }}
                                    </p>
                                </div>
                            </div>
                        </template>
                    </template>
                </template>

                <!-- One time product -->
                <div v-for="(cartItem, cartItemIndex) in user_with_cart.cart.items" :key="cartItemIndex"
                    :class="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time' ? 'checkout-meta-data align-items-start cart_item ' : ''"
                    style="border:none;position: relative;" :style="cartItemIndex == 0 ?'margin-top: 1.5rem' : 'margin-top: 0.5rem'">

                    <div v-if="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time'">
                        <p class="mb-2 what-u-r-getting-p">
                            {{ __('ONE-TIME PURCHASE') }}
                        </p>
                    </div>

                    <div v-if="!cartItem.purchase_option_type || cartItem.purchase_option_type == 'one_time'" class="d-flex">
                        <div class="d-flex justify-content-start align-items-start">
                            <img :src="cartItem?.product?.image?.url" class="img-fluid" :alt="cartItem.product.title"
                                style="width: 62px; height: 62px; object-fit: contain;" />
                        </div>
                        <div>
                            <h6 style="font-weight: normal;font-size: 1rem;font-family: 'TT Norms Pro', sans-serif;"
                                class="w-100 text-uppercase !tw-text-black">
                                <span class="notranslate">{{ cartItem.product.title }}</span>
                                <span v-if="cartItem.attrs" v-html="attrStr(cartItem.attrs)"></span>
                            </h6>
                            <p class="notranslate !tw-text-[#4D4D4D]">
                                {{ cartItem.product.brand.name }}
                            </p>
                            <p style="font-size: 13px;line-height: 1.5;" v-if="cartItem.product.sub_type">
                                {{ cartItem.product.sub_type.name }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- one time end  -->

            </div>
            <div class="checkout-meta-data">
                <h6>
                    {{ __('Total') }}
                    <span class="simple-price text-uppercase tw-font-bold">
                        {{ currencyConvert(net_total) }}
                    </span>
                </h6>
            </div>

            <div class="checkout-meta-data" v-if="sub_discount == 1 && checkSubscriptionInCart() == 1 && $page?.props?.config?.app?.subscribe_discount_status"
                style="position: relative;">
                <h6 style="margin-bottom: 6px;margin-top: -9px;">
                    {{ __('Subscription discount') }}
                    <small style="width: 100%;float: left;margin-top: -9px;font-size: 13px;color: #565656;">
                        {{ __('Offer applied to the first month only')}}
                    </small>
                    <span class="simple-price text-uppercase" style="position: absolute;right: 0px;margin-top: 6px;">
                        - {{ $page?.props?.config?.app?.subscribe_discount_amount }}%
                    </span>
                </h6>
            </div>

            <template v-if="checkSubscriptionInCart() == 1 && checkOneTimeInCart() == 1">
                <div class="checkout-meta-data">
                    <h6>
                        {{ __('Subscription shipping') }}
                        <span class="simple-price" style="text-transform: none;">{{ __('Always Free') }}</span>
                    </h6>
                </div>
                <div class="checkout-meta-data">
                    <h6>
                        {{ __('Ecommerce shipping') }}
                        <span v-if="user_with_cart?.cart?.shipping?.exact" class="simple-price text-uppercase">
                            {{ currencyConvert(user_with_cart?.cart?.shipping?.exact?.charge) }}
                        </span>
                        <span v-else class="simple-price text-uppercase">
                            {{ currencyConvert(config.misc.default_shipping) }}
                        </span>
                    </h6>
                </div>
            </template>

            <template v-if="checkSubscriptionInCart() == 1 && checkOneTimeInCart() == 0">
                <div class="checkout-meta-data">
                    <h6>
                        {{ __('Shipping') }}
                        <span class="simple-price" style="text-transform: none;">
                            <template v-if="config.misc.default_shipping > 0">
                                {{ currencyConvert(config.misc.default_shipping) }}
                            </template>
                            <template v-else>
                                {{ __('Free') }}
                            </template>
                        </span>
                    </h6>
                </div>
            </template>

            <template v-if="checkSubscriptionInCart() == 0 && checkOneTimeInCart() == 1">
                <div class="checkout-meta-data">
                    <h6>
                        {{ __('Shipping') }}
                        <span v-if="user_with_cart?.cart?.shipping?.exact" class="simple-price text-uppercase">
                            {{ currencyConvert(user_with_cart?.cart?.shipping?.exact?.charge) }}
                        </span>
                        <span v-else class="simple-price text-uppercase">
                            <template v-if="config.misc.default_shipping > 0">
                                {{ currencyConvert(config.misc.default_shipping) }}
                            </template>
                            <template v-else>
                                {{ __('Free') }}
                            </template>
                        </span>
                    </h6>
                </div>
            </template>


            <div class="checkout-meta-data" v-if="first_time_subscribe">
                <h6>
                    {{ __("First-Time for First-Month") }}

                    <span class="simple-price text-uppercase">
                        -{{ currencyConvert($page?.props?.config?.app?.subscribe_discount_amount, 0) }} {{ __('Off') }}
                    </span>
                </h6>
            </div>
            <div class="checkout-meta-data"
                v-if="user_with_cart?.cart?.policy_discount && user_with_cart?.cart?.policy_discount > 0">
                <h6>
                    {{ __('Special Discount') }}
                    <span class="simple-price text-uppercase">
                        - {{ currencyConvert(user_with_cart?.cart?.policy_discount) }}
                    </span>
                </h6>
            </div>
            <div class="checkout-meta-data d-flex align-items-center" v-if="user_with_cart?.cart?.coupon_code">
                <div>
                    <h6>
                        {{  __("Coupon Discount") }}
                        <span class="discount-price ms-3">
                            {{ currencyConvert(user_with_cart?.cart?.discount) }}
                        </span>
                    </h6>
                    <p>
                        {{ __("Coupon Code: %s", user_with_cart?.cart?.coupon_code) }}
                    </p>
                </div>
                <span @click.prevent="removeCoupon" class="cursor-pointer ms-auto remove-queue">
                    <img src="../../../images/svg/Ico_Cancel.svg" />
                </span>
            </div>
            <div class="checkout-meta-data">
                <!-- <template v-if="user_with_cart.cart.subscribe_items > 0"> -->
                <h6>
                    {{ __('Net Total') }}
                    <span class="simple-price text-uppercase tw-font-bold">
                        {{ currencyConvert(total) }}
                    </span>
                </h6>
            </div>
            <template v-if="!user_with_cart?.cart?.coupon_code">
                <span class="checkout-meta-anchor cursor-pointer" @click.prevent="couponToggle = !couponToggle">
                    {{ __("Have  a coupon code ? ") }}
                </span>
                <div class="form-group mt-2 coupon-form" v-if="couponToggle">
                    <div class="input-group">
                        <input type="text" class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black" :class="{ 'is-invalid': errors.code }"
                            placeholder="Coupon Code" v-model="couponForm.code" />
                        <button class="btn btn-sm btn-black" @click.prevent="addCoupon" :disabled="couponForm.processing">
                            <svg v-if="couponForm.processing" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 256 256">
                                <path
                                    d="M230,128a102,102,0,0,1-204,0c0-40.18,23.35-76.86,59.5-93.45a6,6,0,0,1,5,10.9C58.61,60.09,38,92.49,38,128a90,90,0,0,0,180,0c0-35.51-20.61-67.91-52.5-82.55a6,6,0,0,1,5-10.9C206.65,51.14,230,87.82,230,128Z">
                                </path>
                            </svg>
                            <small v-else>{{ __("Apply") }}</small>
                        </button>
                    </div>
                    <div class="text-danger" v-if="errors.code">
                        {{ errors.code }}
                    </div>
                </div>
            </template>
        </div>

        <div class="checkout-info mt-3 tw-hidden md:tw-block">
            <div class="d-flex">
                <div class="bottom-checkout-box-img">
                    <img src="../../../images/svg/Setup_Queue.svg" alt="QUEUE" />
                </div>
                <div class="bottom-checkout-box-content">
                    <h6>
                        {{ __('Guaranteed Safe Checkout') }}
                    </h6>
                    <p class="!tw-text-xs md:!tw-text-base">
                        {{ __('All data is encrypted. Your card number is never stored on :app_name servers.', {app_name : config.app.name}) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";
export default{
    props: {
        user_with_cart: Object,
        select_plan: String,
        plan: Object,
        arrivesInMonth: String,
        checkSubscriptionInCart: String,
        checkOneTimeInCart: String,
        net_total: String,
        config: Object,
        total: String,
        errors: Object,
        first_time_subscribe: Boolean,
        all_plans: Object,
    },
    data(){
        return{
            couponToggle: false,
            couponForm: this.$inertia.form({
                code: ''
            }),
            selectPlan: ''
        }
    },
    mounted(){
        if (this.plan) {
            this.selectPlan = this.plan.id;
        }
    },
    watch: {
        // Watch for changes in the plan prop
        plan: {
            handler(plan) {
                // Check if plan exists and has the plan property
                if (plan) {
                    this.selectPlan = plan.id;
                }
            },
            immediate: true, // Trigger the handler immediately when the component is created
        },
    },
    setup() {
        const toast = useToast()
        return { toast }
    },
    methods:{
        emitStatus(status, cartItem) {
            this.$emit('status', { status, cartItem });
        },
        getPlan(plan){
            this.selectPlan = plan;
            this.changePlan();
        },
        changePlan(){
            this.$inertia.get(this.route('subscribe', this.selectPlan), {},{
                 preserveScroll: true
            })
        },
        codeInvalidError() {
            this.toast.error(this.errors.code, {
                position: "top-right",
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: true,
                closeButton: "button",
                icon: true,
                rtl: false
            });
            return false;
        },
        addCoupon() {
            // this.couponForm.post(this.route('coupon.attach'))
            this.couponForm.post(this.route('coupon.attach'), {
                preserveScroll: true,
                onFinish: (visit) => {
                    this.codeInvalidError()
                }
            })
        },
    }
}
</script>

<style lang="scss" scoped>
@import "../../../scss/checkout.scss";

// @import 'vue-select/dist/vue-select.css';
.checkout-meta-data img {
    width: 70px;
    margin-inline-end: 10px;
}

.vs__dropdown-toggle {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    display: flex;
    padding: 0 0 4px;
    background: none;
    border: 0px !important;
    white-space: normal;
}

.form-floating label {
    margin-bottom: 22px !important;
}

.checkout-meta-data p img {
    width: 20px;
    margin-inline-end: 5px;
}

.remove-queue img {
    width: 30px !important;
}

.cart_item {
    background: var(--secondary);
    padding: 16px 24px;
    border-radius: 0px;
}
@media (max-width: 525px) {
        .cart_item {
            padding: 8px 12px;
        }
    }

.cart_btn {
    background: #000 !important;
    color: #fff;
}

.product-close-btn {
    background-color: transparent;
    margin-inline-end: 10px;
}

.cart-count {
    line-height: 1.5;
    top: -5px !important;
}

.what-u-r-getting-p {
    font-weight: bold;
    font-size: 13px !important;
    font-family: 'TT Norms Pro', sans-serif;
}

.subs_type__radio:has(input:checked) div::after {
    border: 5px solid #000;
    // background: var(--primary);
}

body:has(.offcanvas-active) {
    overflow: hidden !important;
}
</style>
