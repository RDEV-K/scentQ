<template>
    <div class="header !tw-bg-gold !tw-z-[9999]">
        <div class="container">
            <div class="nav-menu d-none d-lg-flex">
                <div class="brand">
                    <Link :href="route('index')">
                    <img src="../../../images/svg/logo-white.svg" class=""
                        style="width: 180px;margin-inline-start: 10px" :alt="config.app.name" />
                    </Link>
                </div>
                <nav>
                    <ul>
                        <li class="dropdown_custom"
                            :class="route().current('new.*') ? 'tw-border-b-[2px] hover:tw-border-none tw-border-[#000000]' : ''">
                            <Link :href="route('new.arrivals')" class="dropdown-toggle">{{ __("New Arrivals") }}</Link>
                        </li>

                        <li class="dropdown_custom"
                            :class="route().current('filterGender', 'women') ? 'tw-border-b-[2px] hover:tw-border-none tw-border-[#000000]' : ''">
                            <Link :href="route('filterGender', 'women')" class="dropdown-toggle">{{ __("Women") }}
                            </Link>
                        </li>
                        <li
                            :class="route().current('filterGender', 'men') ? 'tw-border-b-[2px] hover:tw-border-none tw-border-[#000000]' : ''">
                            <Link :href="route('filterGender', 'men')">
                            {{ __("Men") }}
                            </Link>
                        </li>

                        <li
                            :class="route().current('brands') ? 'tw-border-b-[2px] hover:tw-border-none tw-border-[#000000]' : ''">
                            <Link :href="route('brands')">{{
                            __("Brands")
                            }}</Link>
                        </li>

                        <li
                            :class="route().current('product.of.month') ? 'tw-border-b-[2px] hover:tw-border-none tw-border-[#000000]' : ''">
                            <Link :href="route('product.of.month')">{{
                            __("Product Of Month")
                            }}</Link>
                        </li>
                    </ul>
                </nav>
                <div class="menu-utilities tw-flex tw-gap-5 tw-items-center">
                    <button class="search_btn text-decoration-none" v-on:click="isHidden = !isHidden">
                        <img src="/images/MagnifyingGlass2.svg" width="24" alt="search icon" />
                    </button>
                    <div class="search_box" v-if="!isHidden">
                        <Link v-on:click="isHidden = true" :href="route('index')" class="search-left-logo">
                        <img src="../../../images/svg/logo-white.svg" style="width: 132px;margin-inline-start: 10px"
                            :alt="config.app.name" />
                        <!-- <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 21.0469L16.65 16.6969M19 11.0469C19 13.1686 18.1571 15.2034 16.6569 16.7037C15.1566 18.204 13.1217 19.0469 11 19.0469C8.87827 19.0469 6.84344 18.204 5.34315 16.7037C3.84285 15.2034 3 13.1686 3 11.0469C3 8.92514 3.84285 6.89031 5.34315 5.39002C6.84344 3.88973 8.87827 3.04688 11 3.04688C13.1217 3.04688 15.1566 3.88973 16.6569 5.39002C18.1571 6.89031 19 8.92514 19 11.0469Z"
                                    stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> -->
                        </Link>

                        <div class="container">
                            <button type="button" class="btn-close text-reset search_close" v-on:click="isHidden = true"
                                aria-label="Close"></button>
                            <div class="search_form">
                                <instant-search :input-attrs="{
                                    placeholder: __('Search'),
                                    class:
                                        'form-control form-control-sm custom_search_box'
                                }" />
                            </div>
                        </div>
                    </div>
                    <Link v-if="!$page.props.user" class="text-decoration-none text-dark" :href="route('login')">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 15.0469C15.3137 15.0469 18 12.3606 18 9.04688C18 5.73317 15.3137 3.04688 12 3.04688C8.68629 3.04688 6 5.73317 6 9.04688C6 12.3606 8.68629 15.0469 12 15.0469Z"
                            stroke="black" stroke-width="2" stroke-miterlimit="10" />
                        <path
                            d="M2.90625 20.2969C3.82775 18.7004 5.15328 17.3747 6.74958 16.453C8.34588 15.5313 10.1567 15.046 12 15.046C13.8433 15.046 15.6541 15.5313 17.2504 16.453C18.8467 17.3747 20.1722 18.7004 21.0938 20.2969"
                            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </Link>
                    <div @click.prevent="openCart" class="cart-icon tw-relative">
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16 8.04688C16 9.10774 15.5786 10.1252 14.8284 10.8753C14.0783 11.6254 13.0609 12.0469 12 12.0469C10.9391 12.0469 9.92172 11.6254 9.17158 10.8753C8.42143 10.1252 8.00001 9.10774 8.00001 8.04688M3.63301 7.44788L2.93301 15.8479C2.78301 17.6529 2.70701 18.5549 3.01301 19.2509C3.28088 19.8623 3.74504 20.3669 4.33201 20.6849C5.00001 21.0469 5.90501 21.0469 7.71601 21.0469H16.283C18.093 21.0469 18.999 21.0469 19.667 20.6849C20.2543 20.3671 20.7189 19.8625 20.987 19.2509C21.292 18.5549 21.217 17.6529 21.067 15.8479L20.367 7.44788C20.237 5.89587 20.172 5.11888 19.828 4.53188C19.5253 4.01452 19.0746 3.59969 18.534 3.34087C17.92 3.04687 17.141 3.04688 15.583 3.04688H8.41601C6.85801 3.04688 6.07901 3.04687 5.46601 3.34087C4.92515 3.59926 4.4741 4.01374 4.17101 4.53088C3.82701 5.11888 3.76201 5.89587 3.63301 7.44788Z"
                                stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span
                            class="tw-absolute -tw-top-2.5 -tw-right-2.5 tw-w-5 tw-h-5 tw-text-sm tw-inline-flex tw-justify-center tw-items-center tw-rounded-full tw-border tw-border-[#000] tw-bg-[#000] tw-text-white"
                            v-if="cart?.items?.length">
                            {{ cart?.items?.length }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import InstantSearch from "@/Libs/Search/SearchBox.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import { useToast } from "vue-toastification";

    export default {
        props:['cart'],
        components: {
            Link,
            InstantSearch
        },
        data: {
            isHidden: true
        },
        watch: {
            isHidden: {
                deep: true,
                handler(val, oldVal) {
                    if (val == false) {
                        document.body.style.setProperty('overflow', 'hidden', 'important');
                    } else {
                        document.body.style.setProperty('overflow', 'unset', 'important');
                    }
                },
            },
        },
        // computed: {
        //     cart() {
        //         return this.$page.props?.user?.cart;
        //     }
        // },
        // mounted() {
        //     document.onclick = function (e) {
        //         if (document.querySelector(".menu-utilities .search_box")) {
        //             if (e.target.classList.contains("productSearchImg")) {
        //                 document
        //                     .querySelector(
        //                         ".menu-utilities .search_box .search_close"
        //                     )
        //                     .click();
        //             }

        //             let search_box = document.querySelector(
        //                 ".menu-utilities .search_box"
        //             );
        //             let search_btn = document.querySelector(".search_btn img");

        //             if (
        //                 e.target.classList.contains !== "search_box" &&
        //                 e.target != search_btn
        //             ) {
        //                 if (!search_box.contains(e.target)) {
        //                     document
        //                         .querySelector(
        //                             ".menu-utilities .search_box .search_close"
        //                         )
        //                         .click();
        //                 }
        //             }
        //         }
        //     };
        // },
        setup() {
            const toast = useToast()
            return { toast }
        },
        methods: {
            isRoute(name, params) {
                return this.$page.props.ziggy.url === this.route(name, params);
            },
            openCart() {
                if (!this.$page.props.user) {
                    this.toast("Your need to login for open cart.", {
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
                }
                this.$emit('setCartModalStatus', true)
            }
        }
    };
</script>
<style>
    .search_box .search-left-logo {
        position: absolute;
        margin-top: -12px;
        z-index: 9999;
    }

    .search_form {
        margin-top: -25px;
    }

    .login-lnk-top-menu {
        margin-inline-start: 15px;
        margin-top: 2px;
        margin-inline-end: 15px;
    }

    .header-right-m-shopping {
        margin-inline-end: 20px;
        margin-top: 5px;
    }

    .header-right-m-shopping .cart-count2 {
        position: relative;
        background-color: #e50000;
        color: #fff;
        text-align: center;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 13px;
        right: -34px;
        top: -10px;
    }

    .search_box {
        position: fixed;
        left: 0;
        width: 100%;
        background: #fff;
        top: 0;
        padding: 50px;
        z-index: 99999;
        box-shadow: 1px 1px 1px 1px rgb(0, 0, 0, 0.1);
    }

    .search_box form .inner-addon {
        width: 40%;
        margin: auto;
    }

    .search_close {
        position: absolute;
        right: 40px;
        top: 40px;
    }

    .search_btn {
        border: 0;
        background: none;
    }

    .search_form .custom_search_box {
        border-top: 0;
        border-right: 0;
        border-left: 0;
        background: transparent;
        padding-inline-start: 15px !important;
        padding-inline-end: 15px;
        text-align: center;
    }

    .search_form .inner-addon-icon {
        display: none;
    }

    .menu-utilities .cart-icon {
        display: flex;
        cursor: pointer;
    }

    .cart-count2.cart-icn-menu {
        background-color: #000;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-inline-start: -5px;
        margin-top: -5px;
        z-index: 11;

    }
</style>
