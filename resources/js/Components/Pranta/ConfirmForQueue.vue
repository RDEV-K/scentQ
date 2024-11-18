<template>
    <transition name="fade">
        <div v-if="isVisible">
            <div class="tw-absolute tw-p-3 tw-flex tw-justify-center tw-items-center tw-w-full tw-h-full tw-text-center tw-bg-secondary tw-top-0 tw-left-0"
                id="confirm">
                <transition name="zoom">
                    <slot></slot>
                </transition>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'Confirm',
        data: () => ({
            isVisible: false,
        }),
        created() {
            const onEscape = (e) => {
                if (this.isVisible && e.keyCode === 27) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.close()
                }
            }

            document.addEventListener('keydown', onEscape)
        },
        methods: {
            open() {
                this.isVisible = true
            },

            close() {
                this.isVisible = false
            },
        },
        destroyed() {
            document.removeEventListener('keydown', onEscape)
        }
    }
</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.3s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }
</style>
