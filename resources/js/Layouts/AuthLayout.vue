<template>
    <Layout class="auth-body">
        <toasts />
        <notice-bar v-if="$page?.props?.user?.is_card_denied"
            :text="__('Payment Problem. Your Card Was Declined. Please Update Your Billing Info.')"
            :link="route('address', 'billing')" :link-text="__('Update')" />

        <notice-bar
            v-else-if="$page?.props?.user?.personal_subscription && !$page?.props?.user?.personal_subscription?.is_valid"
            :text="__('Payment Problem. Please Update Your Billing Info.')" :link="route('address', 'billing')"
            :link-text="__('Update')" />
        <!-- <notice-bar v-else-if="!$page?.props?.user?.personal_subscription" :text="__('Get 50%% off. Offer ends soon')"
            :link="route('subscribe')" :link-text="__('Subscribe')" /> -->
        <TopMenu v-if="$page?.props?.user" :cartModal="cartModal" @setCartModalStatus="handleCartModalStatus()" />
        <MainMenu @setCartModalStatus="handleCartModalStatus()" />
        <MobileMenu @setCartModalStatus="openCart()" />
        <div>
            <slot></slot>
        </div>
        <div class="fixed-bottomm">
            <div class="container">
                <hr />
                <div class="copyright-text">© {{ config.app.name }} {{ year }}</div>
            </div>
        </div>
    </Layout>
</template>

<script>
import MainMenu from '../Sections/Common/MainMenu.vue'
import MobileMenu from '../Sections/Common/MobileMenu.vue'
import NoticeBar from '../Sections/Common/NoticeBar.vue'
import TopMenu from '../Sections/Common/TopMenu.vue'
import InstantSearch from '@/Libs/Search/SearchBox.vue'
import {
    Link
} from '@inertiajs/inertia-vue3'
import Layout from "@/Libs/Layout.vue";
import Toasts from "@/Libs/Toasts.vue";

export default {
    components: {
        Layout,
        Link,
        Toasts,
        InstantSearch,
        NoticeBar,
        TopMenu,
        MainMenu
    },
    props: {
        offer: {
            type: Object,
            default: null
        }
    },
    methods: {
        isRoute(name, params) {
            return this.$page.props.ziggy.url === this.route(name, params)
        },

        handleCartModalStatus: function (value) {
            this.cartModal = value;
        }
    },
    data() {
        return {
            cartModal: false,
        };
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
