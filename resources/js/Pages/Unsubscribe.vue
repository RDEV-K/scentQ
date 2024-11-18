<template>
    <div class="container py-5 text-center">
        <p class="bold">{{ __('Unsubscribed successfully. Email: %s', email) }}</p>
    </div>
</template>

<script>
import BasicLayout from "@/Layouts/BasicLayout.vue";

export default {
    props: ["email"],
    layout: BasicLayout
}
</script>
