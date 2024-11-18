<template>
    <Layout>
        <toasts />
        <!-- Notice Bars -->
        <!--        <notice-bar-->
        <!--            :text="__('Payment Problem. Your Card Was Declined. Please Update Your Billing Info.')"-->
        <!--            :link="route('address', 'billing')"-->
        <!--            :link-text="__('Update')"/>-->
        <notice-bar v-if="$page?.props?.user?.is_card_denied"
            :text="__('Payment Problem. Your Card Was Declined. Please Update Your Billing Info.')"
            :link="route('address', 'billing')" :link-text="__('Update')" />

        <notice-bar
            v-else-if="$page?.props?.user?.personal_subscription && !$page?.props?.user?.personal_subscription?.is_valid"
            :text="__('Payment Problem. Please Update Your Billing Info.')" :link="route('address', 'billing')"
            :link-text="__('Update')" />
        <!-- <notice-bar v-else-if="!$page?.props?.user?.personal_subscription" :text="__('Get 50%% off. Offer ends soon')"
            :link="$page?.props?.user ? route('subscribe') : route('login', { 'subscribe': 1 })"
            :link-text="__('Subscribe')" /> -->
        <!-- Notice Bars -->

        <!-- Top Menu: If Auth Exists -->
        <TopMenu v-if="$page?.props?.user" :cart="cart" :cartModal="cartModal" @setCartModalStatus="handleCartModalStatus" />
        <!-- Top Menu: If Auth Exists -->

        <!-- Main Menu -->
        <MainMenu :cart="cart" @setCartModalStatus="handleCartModalStatus" />
        <!-- Main Menu -->

        <!-- Product List Hover -->
        <ProductListHoverNav />
        <!-- Product List Hover -->

        <!-- Mobile Menus -->
        <mobile-menu :cart="cart" @setCartModalStatus="handleCartModalStatus()" />
        <!-- Mobile Menus -->

        <slot></slot>

        <!-- Newsletter -->
        <!-- <Newsletter/> -->
        <!-- Newsletter -->

        <FAQ />

        <!-- Footer -->
        <Footer />
        <!-- Footer -->


        <!-- Loading  -->
        <Progress v-if="showSpinner" />
        <!-- Loading End  -->
    </Layout>
</template>

<script>
import NoticeBar from '@/Sections/Common/NoticeBar.vue'
import TopMenu from '@/Sections/Common/TopMenu.vue'
import MainMenu from '@/Sections/Common/MainMenu.vue'
import MobileMenu from '@/Sections/Common/MobileMenu.vue'
import Footer from '@/Sections/Common/Footer.vue'
import Layout from "@/Libs/Layout.vue";
import Toasts from "@/Libs/Toasts.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ProductListHoverNav from "@/Sections/Common/ProductListHoverNav.vue";
import FAQ from '../Sections/Common/FAQ.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Progress from "@/Libs/Components/ProgressBar.vue";
import axios from 'axios';

export default {
    components: {
        NoticeBar,
        TopMenu,
        MainMenu,
        MobileMenu,
        Footer,
        Layout,
        Toasts,
        Link,
        ProductListHoverNav,
        FAQ,
        Progress,
    },
    setup() {
        const showSpinner = ref(false);
        // loading state
        router.on('start', (event) => {
            showSpinner.value = true;
        })
        router.on('finish', (event) => {
            showSpinner.value = false;
        })

        // Return the variables/functions you want to expose to the template
        return {
            showSpinner,
        };
    },
    data() {
        return {
            cartModal: false,
            cart: this.$page.props?.user?.cart
        }
    },
    mounted() {
        this.getUserCart();
    },
    methods: {
        handleCartModalStatus(value) {
            this.cartModal = value;
        },
        getUserCart() {
            axios.post(this.route('api.get.user.cart'))
                .then((res) => {
                    this.cart = res.data;
                })
                .catch((e) => {
                    console.log(e);
                });
        }
    },
    watch: {
        cartModal: {
            deep: true,
            handler(val, oldVal) {
                if (val) {
                    document.body.style.setProperty("overflow", "hidden", "important");
                } else {
                    document.body.style.setProperty("overflow", "unset", "important");
                }
            },
        },
        '$page.props': {
            deep: true,
            handler(val, oldVal) {
                this.getUserCart();
            },
        },
    },
}
</script>