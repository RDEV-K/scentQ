<template>
    <div class="progress-container !tw-w-screen !tw-h-screen !tw-fixed" :class="'progress-' + type">

    </div>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'data'
            }
        }
    }
</script>

<style scoped>
    .progress-container {
        z-index: 9 !important;
    }

    .progress-container svg {
        animation-name: spin;
        animation-duration: 2000ms;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>
