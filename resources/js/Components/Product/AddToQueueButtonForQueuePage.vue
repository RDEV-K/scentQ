<template>
    <component :is="as" @click.prevent="addToQueue">
        <slot v-if="added" name="added"></slot>
        <slot v-else></slot>
    </component>
</template>

<script>
import { useToast } from "vue-toastification";

export default {
    props: {
        product: Object,
        month: String,
        year: String,
        from: {
            type: String,
            default: null
        },
        as: {
            type: String,
            default: 'button'
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                productId: this.product.id,
                month: this.month,
                from: this.from,
                year: this.year,
            }),
            added: false
        }
    },
    watch: {
        month: {
            deep: true,
            handler(val, oldVal) {
                this.form.month = val;
            },
        },
        year: {
            deep: true,
            handler(val, oldVal) {
                this.form.year = val;
            },
        },
        product: {
            deep: true,
            handler(val, oldVal) {
                this.form.productId = this.product.id;
            },
        },
    },
    setup() {
        const toast = useToast()
        return { toast }
    },
    methods: {
        addToQueue() {
            if (!this.user) {
                this.toast.info("Please Signup to continue.", {
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
                    this.$inertia.get(this.route('register', { queue: this.form.productId }));
                }, 500);
            }

            const _app = this
            this.form.post(this.route('queue.push.custom'), {
                preserveScroll: true,
                onError: (errors) => {
                    if (errors.exists) {
                        const modal = new window.bootstrap.Modal('#duplicateProductModal')
                        modal.show()
                    }
                },
                onSuccess: (data) => {
                    console.log(data)
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
