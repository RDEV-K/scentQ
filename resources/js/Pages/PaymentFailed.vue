<template>
    <div style="height: 50vh;" class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <h1 class="text-success text-center">{{ message }}</h1>
        </div>
    </div>
</template>

<script>
import UserPage from "@/Layouts/UserPage.vue";

export default {
    props: {
        message: String
    },
    layout: UserPage
}
</script>
