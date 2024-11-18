<template>
    <div class="landing-nav product-list-hover-nav fixed-top !tw-bg-gold">
        <div class="container tw-h-full tw-flex tw-items-center tw-justify-center">
            <div class="row align-items-center tw-w-full">
                <inertia-link href="/" class="col-md-3 col-lg-3 icon stick-nav-left">
                    <img src="../../../images/svg/logo-dark.svg" style="width: 150px;margin-inline-start: 10px;"
                        :alt="config.app.name" />
                </inertia-link>
                <div class="col-md-9 col-lg-9 px-0 landing-nav-right">
                    <button type="button" @click="openFAQModal"
                        class="btn tw-border !tw-border-black tw-h-14 !tw-text-black btn-lg sm:!tw-text-base !tw-text-xs btn-long text-uppercase faq-stick-btn">
                        {{ __('FAQ') }}
                    </button>

                    <Link v-if="this.user"
                        class="btn !tw-h-14 !tw-bg-gold-dark !tw-whitespace-nowrap !tw-text-white btn-black btn-lg sm:!tw-text-base !tw-text-xs btn-long text-uppercase continue-stick-btn !tw-flex tw-gap-1.5 tw-items-center tw-justify-center"
                        :href="cUrl">
                    <span>{{ __('Subscribe Now') }}</span>
                    </Link>
                    <template v-else>
                        <template v-if="$page.props.queue_session">
                            <a href="#0" @click.prevent="handleContinueBtn"
                                class="btn btn-black !tw-bg-gold-dark !tw-whitespace-nowrap !tw-h-14 !tw-text-white btn-lg sm:!tw-text-base !tw-text-xs btn-long text-uppercase continue-stick-btn !tw-flex tw-gap-1.5 tw-items-center tw-justify-center">
                                <span>{{ __('Subscribe Now') }}</span>
                            </a>
                        </template>
                        <template v-else>
                            <a href="#0" @click.prevent="handleContinueBtn"
                                class="btn btn-black !tw-bg-gold-dark !tw-whitespace-nowrap !tw-h-14 !tw-text-white btn-lg sm:!tw-text-base !tw-text-xs btn-long text-uppercase continue-stick-btn !tw-flex tw-gap-1.5 tw-items-center tw-justify-center">
                                <span>{{ __('Subscribe Now') }}</span>
                            </a>
                        </template>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Link } from "@inertiajs/inertia-vue3";
    import { useToast } from "vue-toastification";

    export default {
        components: { Link },
        // props: ['user'],
        mounted() {
            this.onScroll()
            window.addEventListener('scroll', this.onScroll)
        },
        beforeUnmount() {
            window.removeEventListener('scroll', this.onScroll)
            this.$el.classList.remove('show')
        },
        methods: {
            isRoute(name, params) {
                return this.$page.props.ziggy.url === this.route(name, params)
            },
            onScroll() {
                const element = document.querySelector('.products-list-row')
                if (element) {
                    const rect = element.getBoundingClientRect()
                    if (this.isInViewport(element) && rect.top <= 82) {
                        this.$el.classList.add('show')
                    } else {
                        this.$el.classList.remove('show')
                    }
                } else {
                    this.$el.classList.remove('show')
                }
            },
            isInViewport(ele) {
                if (!ele) return false
                const rect = ele.getBoundingClientRect()
                const elementTop = rect.top + window.scrollY;
                const elementBottom = elementTop + rect.height
                const viewportTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
                const viewportBottom = viewportTop + document.querySelector('html').clientHeight;
                return elementBottom > viewportTop && elementTop < viewportBottom;
            },
            handleContinueBtn(e) {
                // e.preventDefault();
                this.$inertia.get(this.route('register'));
                // if (!this.user) {
                //     this.toast.info("Please login to continue.", {
                //         position: "top-right",
                //         timeout: 5000,
                //         closeOnClick: true,
                //         pauseOnFocusLoss: true,
                //         pauseOnHover: true,
                //         draggable: true,
                //         draggablePercent: 0.6,
                //         showCloseButtonOnHover: false,
                //         hideProgressBar: true,
                //         closeButton: "button",
                //         icon: true,
                //         rtl: false
                //     });

                //     return setTimeout(() => {
                //         this.$inertia.get(this.route('login'));
                //     }, 500);
                // }
            },
            openFAQModal() {
                this.modal = new window.bootstrap.Modal("#faqModal");
                this.modal.show();
            }
        },
        computed: {
            user() {
                return this.$page.props.user;
            },
            queueCount() {
                return this.$page.props.queueCount
            },
            cUrl() {
                if (!this.user) return "#0";
                if (!this.user) return this.route('subscribe')
                if (this.user && !this.user.personal_subscription) return this.route('subscribe')
                if (this.user && this.user.personal_subscription && this.user.personal_subscription && !this.user.personal_subscription?.is_valid) return this.route('subscribe')
                return this.route('queue.purchase')
            }
        },
        setup() {
            const toast = useToast()
            return { toast }
        },
    }
</script>

<style>
    @media (max-width: 767.98px) {
        /* .product-list-hover-nav .landing-nav-right {
        display: block;
    } */

        .product-list-hover-nav .stick-nav-left,
        .product-list-hover-nav .shopping-bag {
            display: none;
        }

        .product-list-hover-nav .container,
        .product-list-hover-nav {
            padding: 0;
        }

        .product-list-hover-nav {
            height: 65px;
        }

        .product-list-hover-nav .continue-stick-btn,
        .product-list-hover-nav .faq-stick-btn {
            margin: 0 !important;
            width: 50%;
        }
    }

    .product-list-hover-nav {
        transform: translate3d(0, -500%, 0);
        transition: transform 0.4s;
    }

    .product-list-hover-nav .icon img {
        transform: unset;
    }

    .product-list-hover-nav .continue-stick-btn {
        background-color: #fff;
        color: #000;
        /* margin-top: 13px;
    margin-inline-end: 45px; */
    }

    .product-list-hover-nav .faq-stick-btn {
        border: 1px solid #fff;
        color: #fff;
        padding-inline-start: 75px;
        padding-inline-end: 75px;
    }

    @media (max-width: 767px) {

        .product-list-hover-nav .faq-stick-btn,
        .product-list-hover-nav .continue-stick-btn {
            padding-inline-start: 24px;
            padding-inline-end: 24px;
        }
    }

    .product-list-hover-nav .continue-stick-btn .continue-svg {
        margin-top: -6px;
    }

    .product-list-hover-nav.show {
        transform: none;
    }

    .product-list-hover-nav .icon {
        text-align: start;
    }

    .product-list-hover-nav .shopping-bag {
        margin-top: 22px;
        right: 22px;
    }

    .shopping-bag span {
        position: absolute;
        padding: 0px 8px;
        background: #fff;
        color: #000;
        border-radius: 50%;
        top: -15px;
        left: 15px;
    }

    .shopping-bag {
        position: relative;
    }
</style>
