<template>
    <Confirm ref="popup">
        <div class="tw-z-10">
            <p class="tw-mb-1 sm:tw-text-lg tw-text-sm">{{ message }}</p>

            <div class="flex tw-justify-center tw-items-center tw-space-x-4 tw-space-y-4">
                <button @click="_cancel"
                    class="tw-uppercase tw-border tw-bg-transparent tw-border-black tw-font-normal sm:tw-px-[38px] tw-text-lg tw-px-3 tw-py-1 hover:tw-shadow-xl">
                    {{ cancelButton }}
                </button>
                <button @click="_confirm"
                    class="tw-uppercase tw-bg-black tw-border-2 tw-border-black tw-text-white tw-font-normal sm:tw-px-[38px] tw-text-lg tw-px-3 tw-py-1 tw-hover:shadow hover:tw-shadow-xl">
                    {{ okButton }}
                </button>
            </div>
        </div>
    </Confirm>
</template>

<script>
import Confirm from "./Confirm.vue";
export default {
    name: 'ConfirmDialog',

    components: { Confirm },

    data: () => ({
        message: undefined, // Main text content
        okButton: 'Yes, Remove it!', // Text for confirm button; leave it empty because we don't know what we're using it for
        cancelButton: 'No, Keep it', // text for cancel button

        // Private variables
        resolvePromise: undefined,
        rejectPromise: undefined,
    }),

    methods: {
        show(opts = {}) {
            this.message = opts.message
            if (opts.okButton) {
                this.okButton = opts.okButton
            }

            if (opts.cancelButton) {
                this.cancelButton = opts.cancelButton
            }
            // Once we set our config, we tell the popup modal to open
            this.$refs.popup.open()
            // Return promise so the caller can get results
            return new Promise((resolve, reject) => {
                this.resolvePromise = resolve
                this.rejectPromise = reject
            })
        },

        _confirm() {
            this.$refs.popup.close()
            this.resolvePromise(true)
        },

        _cancel() {
            this.$refs.popup.close()
            this.resolvePromise(false)
        },
    },
}
</script>
