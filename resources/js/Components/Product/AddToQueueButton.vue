<template>
    <component :is="as" @click.prevent="addToQueue">
        <slot v-if="added" name="added">
            {{ __('Added') }}
        </slot>
        <slot v-else></slot>
    </component>
</template>

<script>
import {useToast} from "vue-toastification";

export default {
    props: {
        product: Object,
        as: {
            type: String,
            default: 'button'
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                productId: this.product.id
            }),
            added: false
        }
    },
    setup() {
        const toast = useToast()
        return { toast }
    },
    methods: {
        addToQueue() {
            // if (!this.user) {
            //     this.toast.info("Please login to continue.", {
            //       position: "top-right",
            //       timeout: 5000,
            //       closeOnClick: true,
            //       pauseOnFocusLoss: true,
            //       pauseOnHover: true,
            //       draggable: true,
            //       draggablePercent: 0.6,
            //       showCloseButtonOnHover: false,
            //       hideProgressBar: true,
            //       closeButton: "button",
            //       icon: true,
            //       rtl: false
            //     });

            //     return setTimeout(() => {
            //         this.$inertia.get(this.route('login', { queue: this.form.productId }));
            //     }, 500);
            // }

            const _app = this
            this.form.post(this.route('queue.push'), {
                preserveScroll: true,
                onError: (errors) => {
                    if (errors.exists) {
                        const modal = new window.bootstrap.Modal('#duplicateProductModal')
                        modal.show()
                    }
                },
                onSuccess: (data) => {
                    _app.added = true
                    setTimeout(() => {
                        _app.added = false
                    }, 3000)
                }
            })
        }
    },
    computed: {
        user() {
            return this.$page.props.user;
        },
    }
}
</script>
