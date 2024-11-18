<template>
    <section v-if="showSection" class="common-header-top-section !tw-bg-[#AA0406] tw-border-b tw-border-gray-400"
        :class="color">
        <p class="!tw-text-white" :class="classes" v-if="text" v-html="text"></p>

        <Link v-if="link != route('subscribe')" :href="link" class="btn btn-lg btn-long !tw-border !tw-border-white"
            :class="'btn-' + buttonColor">
        {{ linkText }}
        <img src="../../../images/svg/arrao-light-r-sharp.svg" class="icon-right" />
        </Link>
        <a v-else href="#0" @click.prevent="handleSubscribe" class="btn btn-lg btn-long" :class="'btn-' + buttonColor">
            {{ linkText }}
            <img src="../../../images/svg/arrao-light-r-sharp.svg" class="icon-right" />
        </a>

        <button class="close-btn" @click="showSection = !showSection">
            <close-icon />
        </button>
    </section>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import CloseIcon from '../../Components/SVG/CloseIcon.vue';
import { useToast } from "vue-toastification";

export default {
    props: {
        color: {
            type: String,
            default: 'pink'
        },
        text: {
            type: String,
            default: null
        },
        link: {
            type: String,
            default: '#'
        },
        linkText: {
            type: String,
            default: 'Update'
        },
        classes: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            countDownInterval: null,
            counter_minute: 18,
            counter_second: 59,
            showSection: true
        };
    },
    mounted() {
        this.counter_minute = this.counter_minute;
        this.counter_second = this.counter_second;
        this.countDownInterval = setInterval(this.countDown, 1000);
    },
    setup() {
        const toast = useToast()
        return { toast }
    },
    methods: {
        countDown() {
            if (this.counter_second > 0) {
                this.counter_second -= 1;
            } else if (this.counter_minute > 0) {
                this.counter_minute -= 1;
                this.counter_second = 59;
            }
        },
        handleSubscribe(e) {
            e.preventDefault();
            if (!this.user) {
                this.toast.error("Please Signup to continue.", {
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

                return setTimeout(() => {
                    this.$inertia.get(this.route('register'));
                }, 500);
            }
        }
    },
    beforeUnmount() {
        clearInterval(this.countDownInterval);
    },
    components: { Link, CloseIcon },
    computed: {
        buttonColor() {
            switch (this.color) {
                case 'black':
                    return 'pink';
                default:
                    return 'dark'
            }
        },
        user() {
            return this.user
        }
    }
}

</script>

<style>
.box-timer-top-left {
    float: left;
    width: 48px;
    height: 40px;
    text-align: center;
    padding-top: 2px;
    margin-top: 5px;
    margin-inline-end: 10px;
    border-radius: 6px;
    background-color: #ffffff;
    font-size: 24px;
    font-weight: 600;
    font-stretch: normal;
    font-style: normal;
    letter-spacing: normal;
    font-family: 'TT Norms Pro', sans-serif;
}

.box-timer-top-right {
    float: left;
    width: 48px;
    height: 40px;
    text-align: center;
    padding-top: 2px;
    margin-top: 5px;
    font-size: 24px;
    font-weight: 600;
    font-stretch: normal;
    font-style: normal;
    letter-spacing: normal;
    font-family: 'TT Norms Pro', sans-serif;
    border-radius: 6px;
    background-color: #ffffff;
}

.sec-mins-title {
    font-size: 12px;
    color: #fff;
    letter-spacing: 0.2px;
    font-family: 'TT Norms Pro', sans-serif;
    font-weight: 100;
    margin-top: 5px;
}

.timer-colon {
    float: left;
    height: 45px;
    text-align: center;
    width: 5px;
    margin-inline-end: 9px;
    padding-top: 8px;
    font-size: 25px;
}

.common-header-top-section {
    position: relative;
}

.close-btn {
    position: absolute;
    top: 30px;
    right: 30px;
    width: 40px;
    height: 40px;
    border: none;
    background: rgba(0, 0, 0, 0.16);
    border-radius: 4px;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
