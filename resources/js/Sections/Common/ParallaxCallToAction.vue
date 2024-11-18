<template>
    <section v-if="!$page.props.user" class="landing ll-call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="ll-call-to-action-container">
                        <h2>{{ __(title) }}</h2>
                        <p v-if="sub_title">{{ __(sub_title) }}</p>
                        <Link v-if="button_link && button_text" class="btn btn-black" :href="button_link">
                        {{ __(button_text) }}
                        </Link>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ll-newsletter-container newsletter">
                        <h2>
                            {{ __('Subscribe to our newsletter') }}
                        </h2>
                        <form @submit.prevent="sendEmail">
                            <div class="form-group m-0">
                                <div class="inner-addon inner-addon-left">
                                    <input type="email" v-model="form.email" class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                        placeholder="Email Address" />
                                </div>
                                <button type="submit" class="btn btn-black">
                                    {{ __('Subscribe') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section v-if="testimonials.length > 0 && route().current('index')"
        class="tw-relative tw-mt-[-236px] tw-top-[236px] !tw-z-[9998]">
        <div class="tw-max-w-[1368px] tw-mx-auto">
            <div>
                <swiper class="footerTestimonialSwiper" :navigation="navigation" :loop="true" :modules="modules"
                    :slides-per-view="slidesPerView" :breakpoints="breakpoints" :space-between="36" :mousewheel="true">
                    <swiper-slide v-for="(testimonial, index) of testimonials" :key="index">
                        <div class="tw-relative tw-bg-secondary tw-text-black tw-min-h-[96px]">
                            <div v-html="testimonial.video_url"></div>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </section>
</template>

<script>
    import { Link } from "@inertiajs/inertia-vue3";
    import EnvelopIcon from "../../Components/SVG/EnvelopIcon.vue";
    import { useToast } from "vue-toastification";
    import { Swiper, SwiperSlide } from 'swiper/vue';
    // Import Swiper styles
    import 'swiper/css';
    import 'swiper/css/navigation';
    import { Navigation } from 'swiper';
    import axios from "axios";

    export default {
        components: {
            Link,
            EnvelopIcon,
            Swiper,
            SwiperSlide,
        },
        props: {
            title: String,
            sub_title: String,
            button_text: String,
            button_link: String
        },
        setup() {
            const toast = useToast()
            return {
                toast,
                navigation: {
                    el: '.custom-navigation',
                    clickable: true,
                },
                modules: [Navigation],
            }
        },
        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                }),
                testimonials: [],
                footerData: null,
                slidesPerView: 1,
                breakpoints: {
                    // when window width is >= 640px
                    768: {
                        slidesPerView: 2,
                    },
                    // when window width is >= 1024px
                    1024: {
                        slidesPerView: 3,
                    },
                },
            }
        },
        mounted() {
            this.getTestimonial();
            this.loadInstagramScript();
        },
        methods: {
            loadInstagramScript() {
                const script = document.createElement("script");
                script.setAttribute("src", "https://www.instagram.com/embed.js");
                script.setAttribute("defer", "true"); // Set the defer attribute
                script.onload = this.handleScriptLoad;
                script.onerror = this.handleScriptError;
                document.head.appendChild(script);

                // Trigger the processing of Instagram embeds after a short delay
                script.onload = () => {
                    setTimeout(() => {
                        if (window.instgrm) {
                            window.instgrm.Embeds.process();
                        }
                    }, 1000); // You can adjust the delay as needed
                };
            },
            crate(number) {
                if (!number) return 0;
                return parseInt(number);
            },
            getTestimonial() {
                axios.get(this.route('testimonial.index'))
                    .then((response) => {
                        this.testimonials = response.data;
                        this.loadInstagramScript();
                    })
                    .catch((e) => {
                        this.testimonials = [];
                    });
            },
            sendEmail() {

                if (this.form.email == null || this.form.email == "") {
                    this.toast.error("Email address is required", {
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
                }

                this.form.post(this.route('subscriber'), {
                    onSuccess: () => {
                        this.form.reset()
                    }
                });
            }
        },
    };
</script>

<style lang="scss" scoped>
    .ll-call-to-action {
        padding: 40px 0px 80px;
    }

    .ll-call-to-action-container {
        background-image: url("../../../images/bg/call-to-action.webp");
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        border: 1px solid #E0E0E0;
        padding: 40px;
        width: 100%;
    }

    .ll-call-to-action-container .btn-black {
        padding: 14px 24px;
    }

    .ll-call-to-action-container h2,
    .ll-newsletter-container h2 {
        max-width: 358px;
        font-family: 'TT Norms Pro', sans-serif;
        font-style: normal;
        font-weight: 600;
        font-size: 24px;
        line-height: 32px;
        color: #000000;
        margin-bottom: 24px;
    }

    .ll-newsletter-container {
        padding: 48px 40px;
        background: #F7E1E5;
    }

    .ll-newsletter-container .form {
        position: relative;
    }

    .ll-newsletter-container .form input {
        display: block;
        width: 100%;
        outline: none;
        border: none;
        background: white;
        padding: 24px 60px;
    }

    .newsletter form div.inner-addon.inner-addon-left input[type=email] {
        padding: 24px 30px;
        height: 72px;
    }

    .ll-newsletter-container .btn {
        padding: 12px 24px !important;
    }

    @media (max-width: 525px) {
        .ll-call-to-action {
            padding: 40px 0px;
        }

        .ll-newsletter-container,
        .ll-call-to-action-container {
            padding: 24px;
        }

        .newsletter form div.inner-addon.inner-addon-left input[type=email] {
            height: 48px;
        }

        .newsletter form {
            height: max-content !important;
        }
    }
</style>
