<template>
    <div class="toast-custom"></div>
</template>

<script>
import {useToast} from "vue-toastification";
import QueueToastComponent from "@/Components/QueueToastComponent.vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    setup() {
        const toast = useToast()
        return { toast }
    },
    data() {
        return {
            toastOption: {
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
            },
        }
    },
    mounted() {
        if (this.$page.props?.errors || this.$page.props?.flash) {
            this.fireToasts(this.$page.props)
        }
    },
    methods: {
        fireToasts(props) {
            if (props?.errors?.stock && props?.errors?.stock !== null) {
                this.toast.warning(props?.errors?.stock, this.toastOptions)
            }
            if (props?.errors?.error && props?.errors?.error !== null) {
                this.toast.error(props?.errors?.error, this.toastOptions)
            }
            if (props?.errors?.case && props?.errors?.case !== null) {
                this.toast.error(props?.errors?.case, this.toastOptions)
            }
            if (props?.errors?.default && props?.errors?.default !== null) {
                this.toast.error(props?.errors?.default, this.toastOptions)
            }
            if (props?.flash?.error && props?.flash?.error !== null) {
                this.toast.error(props?.flash?.error, this.toastOptions)
            }
            if (props?.flash?.success && props?.flash?.success !== null) {
                this.toast.success(props?.flash?.success, this.toastOptions)
            }
            if (props?.flash?.status && props?.flash?.status !== null) {
                this.toast.info(props?.flash?.status, this.toastOptions)
            }
            if (props?.flash?.message && props?.flash?.message !== null) {
                this.toast.info(props?.flash?.message, this.toastOptions)
            }
            if (props?.flash?.queue_added && props?.flash?.queue_added !== null) {
                this.toast({
                    component: QueueToastComponent,
                    props: { item: props?.flash?.queue_added }
                }, {
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
                    icon: false,
                    rtl: false
                });
            }
        }
    },
    watch: {
        '$page.props'(cur, prev) {
            this.fireToasts(cur);
        }
    }
}
</script>

<style lang="scss">
    @import "vue-toastification/dist/index.css";

    .Vue-Toastification__toast--default {
        background-color: #000;
        color: #fff;
    }
    .Vue-Toastification__toast--info {
        background-color: #000;
        color: #fff;
    }
    .Vue-Toastification__toast--success {
        background-color: #000;
        color: #fff;
    }
    .Vue-Toastification__toast--error {
        background-color: #000;
        color: #fff;
    }
    .Vue-Toastification__toast--warning {
        background-color: #000;
        color: #fff;
    }
    .Vue-Toastification__close-button{
        color: #000 !important;
        opacity: 1 !important;
    }
</style>
