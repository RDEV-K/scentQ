<template>
    <Layout>
        <toasts />
        <!-- top bar -->
        <MainMenu />
        <!-- Mobile Menus -->
        <MobileMenu />
        <!-- Mobile Menus -->

        <!-- <div class="landing-nav">
            <div class="row h-100 align-items-center">
                <div class="col-md-4 col-lg-6 icon">
                    <img src="../../images/svg/icon.svg">
                </div>
                <div class="col-md-8 col-lg-6 landing-nav-right">
                    <form action="#">
                        <InstantSearch :input-attrs="{placeholder: 'Search', class: 'form-control form-control-sm'}"/>
                    </form>
                    <Link class="btn btn-black btn-lg btn-long text-uppercase" :href="route('login')">
                        {{ __('Log In') }}
                    </Link>
                </div>
            </div>
        </div> -->
        <!-- top bar -->

        <!-- Product List Hover -->
        <ProductListHoverNav />
        <!-- Product List Hover -->

        <slot></slot>

        <!-- Newsletter -->
        <Newsletter />
        <!-- Newsletter -->

        <FAQ />

        <!-- footer section -->
        <Footer />
        <!-- footer section -->
    </Layout>
</template>

<script>
import InstantSearch from "@/Libs/Search/SearchBox.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Footer from '@/Sections/Common/Footer.vue'
import Newsletter from '@/Sections/Common/Newsletter.vue'
import Layout from "@/Libs/Layout.vue";
import Toasts from "@/Libs/Toasts.vue";
import ProductListHoverNav from "@/Sections/Common/ProductListHoverNav.vue";
import MainMenu from "@/Sections/Common/MainMenu.vue";
import MobileMenu from "@/Sections/Common/MobileMenu.vue";
import FAQ from "../Sections/Common/FAQ.vue";

export default {
    components: { Layout, Toasts, InstantSearch, Link, Footer, Newsletter, ProductListHoverNav, MainMenu, MobileMenu, FAQ },

    data() {
        return {
            cartModal: false,
        }
    },
    methods: {
        handleCartModalStatus: function (value) {
            this.cartModal = value;
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
    }
}
</script>
