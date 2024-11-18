<template>
    <main v-bind="$attrs" v-cloak>
        <slot></slot>
        <Teleport to="body" v-if="user">
            <div class="modal fade" id="duplicateProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0 p-0">
                            <h5 class="modal-title">Dear {{ user?.first_name }},</h5>
                            <button type="button" class="btn-close p-0" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <p>Sorry! You can’t add the same product twice. {{ config.app.name }} is a discovery platform to help you find new products.Please choose another product, try something new that will delight you! You can order the same product again every 6 months.</p>
                            <div class="text-center mt-5 mb-4">
                                <button href="#" class="btn btn-black btn-long btn-lg" data-bs-dismiss="modal"
                                    aria-label="Close">Finish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>
    </main>
    <ProgressBar class="progress-cloak" />
</template>

<script>
import ProgressBar from "@/Libs/Components/ProgressBar.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: { ProgressBar, Link },
    data(){
        return{
        }
    },
    mounted() {
        const successValue = this.$page?.props?.flash?.queue;
        if (successValue !== null &&  typeof successValue === 'string' && successValue.length >= 1) {
      
            this.showSweetAlert(this.$page?.props?.flash?.queue);
        }
    },

    computed: {
        user() {
            return this.user
        },
        sweetAlert() {
            let value = this.$page.props.flash.queue ? this.$page.props.flash.queue : null;
            return value;
        },
        subscribedAlert() {
            let value = this.$page.props.flash.subscribed ? this.$page.props.flash.subscribed : null;
            return value;
        },
        successAlert() {
            let value = this.$page.props.flash.success_alert ? this.$page.props.flash.success_alert : null;
            return value;
        },
        warningAlert() {
            let value = this.$page.props.flash.warning_alert ? this.$page.props.flash.warning_alert : null;
            return value;
        },
        newSubscriptionAlertComputed() {
            let value = this.$page.props.flash.new_subscription_alert ? this.$page.props.flash.new_subscription_alert : null;
            return value;
        },
    },
    watch: {
        '$page.props.flash.queue': {
            deep: true,
            handler(val, oldVal) {
                const successValue = this.$page?.props?.flash?.queue;
                if (successValue !== null &&  typeof successValue === 'string' && successValue.length >= 1) {
               
                    this.showSweetAlert(this.$page?.props?.flash?.queue);
                }
            },
        },
        sweetAlert: {
            deep: true,
            handler(val, oldVal) {
                if (val != undefined || val != null) {
                    this.showSweetAlert(val);
                }
            },
        },
        subscribedAlert: {
            deep: true,
            handler(val, oldVal) {
                if (val != undefined || val != null) {
                    this.showSubscribedAlert(val);
                }
            },
        },
        successAlert: {
            deep: true,
            handler(val, oldVal) {
                if (val != undefined || val != null) {
                    this.showSuccessAlert(val);
                }
            },
        },
        warningAlert: {
            deep: true,
            handler(val, oldVal) {
                if (val != undefined || val != null) {
                    this.showWarningAlert(val);
                }
            },
        },
        newSubscriptionAlertComputed: {
            deep: true,
            handler(val, oldVal) {
                if (val != undefined || val != null) {
                    this.newSubscriptionAlert(val);
                }
            },
        },
    },
    methods: {
        showSweetAlert(val) {
            this.$swal({
                title: 'Oops...',
                html: val,
                iconHtml: '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7.25C5 6.55964 5.55964 6 6.25 6H33.75C34.4404 6 35 6.55964 35 7.25V32.75C35 33.4404 34.4404 34 33.75 34H6.25C5.55964 34 5 33.4404 5 32.75V7.25Z" stroke="#FF4444" stroke-width="3"/><path d="M27 12H13" stroke="#FF4444" stroke-width="3" stroke-linecap="round"/><path d="M16 19L24 27" stroke="#FF4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 27L24 19" stroke="#FF4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                showCancelButton: true,
                showCloseButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Close',
                customClass: {
                    container: 'my-swal-container',
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    text: 'my-swal-text',
                    content: 'my-swal-content',
                    icon: 'my-swal-icon',
                    cancelButton: 'my-swal-cancel-button',
                    confirmButton: 'my-swal-confirm-button',
                    closeButton: 'my-swal-cross-button',
                },
            });
        },
        showSubscribedAlert(val) {
            this.$swal({
                title: 'Subscription Added!',
                html: val,
                iconHtml: '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7.25C5 6.55964 5.55964 6 6.25 6H33.75C34.4404 6 35 6.55964 35 7.25V32.75C35 33.4404 34.4404 34 33.75 34H6.25C5.55964 34 5 33.4404 5 32.75V7.25Z" stroke="#21923A" stroke-width="3"/><path d="M27 28H13" stroke="#21923A" stroke-width="3" stroke-linecap="round"/><path d="M16 17L18.6667 21L24 13" stroke="#21923A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                showCancelButton: true,
                showCloseButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Okay',
                customClass: {
                    container: 'my-swal-container',
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    text: 'my-swal-text',
                    content: 'my-swal-content',
                    icon: 'my-swal-icon',
                    cancelButton: 'my-swal-cancel-button',
                    confirmButton: 'my-swal-confirm-button',
                    closeButton: 'my-swal-cross-button',
                },
            });
        },
        showSuccessAlert(val) {
            this.$swal({
                title: 'Success!',
                html: val,
                iconHtml: '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7.25C5 6.55964 5.55964 6 6.25 6H33.75C34.4404 6 35 6.55964 35 7.25V32.75C35 33.4404 34.4404 34 33.75 34H6.25C5.55964 34 5 33.4404 5 32.75V7.25Z" stroke="#21923A" stroke-width="3"/><path d="M27 28H13" stroke="#21923A" stroke-width="3" stroke-linecap="round"/><path d="M16 17L18.6667 21L24 13" stroke="#21923A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                showCancelButton: true,
                showCloseButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Okay',
                customClass: {
                    container: 'my-swal-container',
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    text: 'my-swal-text',
                    content: 'my-swal-content',
                    icon: 'my-swal-icon',
                    cancelButton: 'my-swal-cancel-button',
                    confirmButton: 'my-swal-confirm-button',
                    closeButton: 'my-swal-cross-button',
                },
            });
        },
        showWarningAlert(val) {
            this.$swal({
                title: 'Oops...',
                html: val,
                iconHtml: '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7.25C5 6.55964 5.55964 6 6.25 6H33.75C34.4404 6 35 6.55964 35 7.25V32.75C35 33.4404 34.4404 34 33.75 34H6.25C5.55964 34 5 33.4404 5 32.75V7.25Z" stroke="#FF4444" stroke-width="3"/><path d="M27 12H13" stroke="#FF4444" stroke-width="3" stroke-linecap="round"/><path d="M16 19L24 27" stroke="#FF4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 27L24 19" stroke="#FF4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                showCancelButton: true,
                showConfirmButton: false,
                showCloseButton: true,
                cancelButtonText: 'Close',
                customClass: {
                    container: 'my-swal-container',
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    text: 'my-swal-text',
                    content: 'my-swal-content',
                    icon: 'my-swal-icon',
                    cancelButton: 'my-swal-cancel-button',
                    confirmButton: 'my-swal-confirm-button',
                    closeButton: 'my-swal-cross-button',
                },
            });
        }
    }
}
</script>
<style>
.swal2-popup.my-swal-popup {
        padding: 24px !important;
        border-radius: 0px !important;
    }

    .swal2-icon.my-swal-icon {
        border: none !important;
        width: 40px !important;
        height: 40px !important;
        margin-top: 0px !important;
        margin-bottom: 16px !important;
    }

    .swal2-title.my-swal-title {
        padding-top: 0px !important;
        font-family: 'TT Norms Pro' sans-serif !important;
        font-style: normal !important;
        font-weight: 700 !important;
        font-size: 20px !important;
        line-height: 28px !important;
        text-align: center !important;
        color: #000000 !important;
    }

    .swal2-html-container {
        font-family: 'TT Norms Pro', sans-serif !important;
        font-style: normal !important;
        font-weight: 400 !important;
        font-size: 16px !important;
        line-height: 24px !important;
        text-align: center !important;
        color: #525252 !important;
        margin-top: 8px !important;
        margin-bottom: 24px !important;
    }

    .swal2-actions {
        width: 100% !important;
        margin-top: 0px !important;
        justify-content: space-between !important;
        flex-direction: row-reverse !important;
    }

    .my-swal-cancel-button,
    .my-swal-confirm-button {
        margin: 0px !important;
    }

    .my-swal-cancel-button {
        font-family: 'TT Norms Pro', sans-serif !important;
        font-style: normal !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        line-height: 20px !important;
        text-transform: uppercase !important;
        color: #1F1F1F !important;
        border-radius: 0px !important;
        padding: 10px 24px !important;
        background: transparent !important;
        border: 2px solid #1F1F1F !important;
    }

    .my-swal-confirm-button {
        padding: 12px 24px !important;
        font-family: 'TT Norms Pro', sans-serif !important;
        font-style: normal !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        line-height: 20px !important;
        text-transform: uppercase !important;
        color: #FFFFFF !important;
        background: #1F1F1F !important;
        border-radius: 0px !important;
    }
    .my-swal-confirm-button:focus {
        box-shadow: none !important;
    }
    .my-swal-cross-button{
        z-index: 2 !important;
        align-items: center !important;
        justify-content: center !important;
        width: 1.2em !important;
        height: 1.2em !important;
        margin-top: 0 !important;
        margin-inline-end: 0 !important;
        margin-bottom: -1.2em !important;
        padding: 0 !important;
        overflow: hidden !important;
        transition: color .1s,box-shadow .1s !important;
        border: none !important;
        border-radius: 0px !important;
        background: rgba(0,0,0,0) !important;
        color: black !important;
        font-family: 'TT Norms Pro', sans-serif !important;
        font-size: 2.5em !important;
        cursor: pointer !important;
        justify-self: end !important;
        margin-top: -22px !important;
        margin-inline-end: -22px !important
    }
    .my-swal-cross-button:hover {
        color: rgba(0,0,0,0) !important;
    }
</style>
