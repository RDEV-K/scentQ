<template>
    <Layout class="auth-body">
        <toasts />
        <Link as="div" class="logo-bar cursor-pointer" :href="route('index')">
        <!--            <img src="../../images/svg/icon.svg" class="me-3" />-->
        <img src="../../images/svg/Icon_Light.svg" class="me-3 icon-size" />
        <!--            <img src="../../images/svg/logo-white.svg" :alt="config.app.name"/>-->
        <img src="../../images/svg/logo-light.svg" class="logo-size" :alt="config.app.name" />
        </Link>
        <Link class="discount-bar sticky-top" v-if="offer" as="div" :href="offer.link">{{ offer.text }}</Link>
        <!--        TODO: Make Offer Dynamic-->
        <!--        <Link class="discount-bar sticky-top d-lg-none" as="div" :href="route('subscribe')">Get 50% off. Offer ends soon</Link>-->
        <div class="container">
            <slot></slot>
        </div>
        <FAQ />
        <Footer />
    </Layout>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    import Layout from "@/Libs/Layout.vue";
    import Toasts from "@/Libs/Toasts.vue";
    import Footer from "@/Sections/Common/Footer.vue";
    import FAQ from '../Sections/Common/FAQ.vue';

    export default {
        components: { Layout, Link, Toasts, FAQ, Footer },
        props: {
            offer: {
                type: Object,
                default: null
            }
        },
        data() {
            return {};
        },

        computed: {
            user() {
                return this.$page.props.user;
            },
            year() {
                return new Date().getFullYear()
            }
        }
    };
</script>

<style lang="scss">
    @import "../../scss/auth.scss";

    .auth-body {
        background-color: #fff;
    }

    hr {
        background-color: #d5d5d5;
        margin: 0;
    }

    .copyright-text {
        background-color: #fff;
        color: #5d5d5d;
        font-size: 1rem;
    }

    .social-buttons .btn {
        font-family: 'TT Norms Pro', sans-serif;
        text-transform: capitalize;
    }

    .social-buttons {
        padding: 40px;
        background: #f2f2f2;
    }

    .social-buttons p {
        font-family: 'TT Norms Pro', sans-serif;
        font-size: 20px;
        line-height: 28px;
        text-transform: uppercase;
        color: #000;
    }

    .auth-card {
        margin-top: 0px;
        min-height: calc(100vh - 98px - 48.3px);
    }

    .logo-bar {
        padding: 0 !important;
    }

    .icon-size {
        width: 58px;
    }

    .logo-size {
        height: 31px;
        margin-top: auto;
        margin-bottom: auto;
    }
</style>