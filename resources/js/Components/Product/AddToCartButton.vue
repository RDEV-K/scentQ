<template>
    <component :is="as" @click.prevent="addToCart" :disabled="cartForm.processing">
        <slot v-if="added" name="added">
            <div class="tw-flex tw-justify-center tw-items-center tw-gap-2">
                <div class="md:!tw-text-sm tw-text-[#e0ad7d] !tw-text-xs tw-whitespace-nowrap">
                    {{ __("Selected") }}
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="15.632" height="11.141" viewBox="0 0 15.632 11.141">
                        <path id="Ico_Check"
                              d="M13.616,4.316,5.192,12.739a.61.61,0,0,1-.864,0L1.071,9.479a.61.61,0,0,0-.864,0h0a.61.61,0,0,0,0,.864L3.466,13.6a1.834,1.834,0,0,0,2.591,0L14.48,5.179a.61.61,0,0,0,0-.863h0a.61.61,0,0,0-.864,0Z"
                              transform="translate(0.472 -3.637)" fill="#e0ad7d" stroke="#e0ad7d" stroke-width="1"/>
                    </svg>
                </div>
            </div>
        </slot>
        <slot v-else></slot>
    </component>
</template>

<script>
import {useToast} from "vue-toastification";
import {router} from '@inertiajs/vue3'

export default {
    props: {
        product: Object,
        purchaseOption: Object,
        as: {
            type: String,
            default: "button",
        },
        attrs: {
            type: Object,
            default: null,
        },
        openCart: {
            type: Boolean,
            default: true,
        },
        subscribePlanType: {
            type: String,
            default: null,
        },
        replaceItem: {
            type: String,
            default: null,
        }
    },
    setup() {
        const toast = useToast();
        return {toast};
    },
    data() {
        return {
            added: false,
            cartForm: this.$inertia.form({
                product_id: null,
                purchase_option_id: null,
                attrs: null,
                subscribe_plan_type: null,
                replaceItem: null
            }),
        };
    },
    methods: {
        addToCart() {
            if (!this.user) {
                this.toast.info("Please Signup to continue.", {
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

                if (this.purchaseOption.type == 'subscription') {
                    return this.$inertia.get(this.route('register', {add_to_sub: this.product.id}));
                } else {
                    return this.$inertia.get(this.route('register', {add_to_cart: this.product.id}));
                }
            }

            this.cartForm.product_id = this.product.id;
            this.cartForm.purchase_option_id = this.purchaseOption?.id;
            this.cartForm.attrs = this.attrs;
            this.cartForm.subscribe_plan_type = this.subscribePlanType;
            this.cartForm.replaceItem = this.replaceItem;

            this.cartForm.post(this.route("cart-item.store"), {
                preserveScroll: true,
                onSuccess: (data) => {
                    this.added = true
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
                    setTimeout(function () {
                        if (window.innerWidth < 768) {
                            document.body.style.marginBottom = '8px';
                            document.body.style.position = 'relative';
                            document.body.style.minHeight = '100%';
                            document.body.style.top = '0px';
                            document.body.style.setProperty('overflow', 'unset', 'important');
                        }
                    })
                    // return router.get(this.route('checkout'));
                }, 2000);
            }
        },
    },
    computed: {
        user() {
            return this.$page.props.user;
        },
    }
};
</script>
