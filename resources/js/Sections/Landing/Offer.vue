<template>
    <div v-if="text" class="discount-bar d-none d-lg-block" v-html="text"></div>
</template>

<script>
   export default{
        props: {
            text: String
        }
   }
</script>

<style>
.discount-bar p {
    margin-bottom: 0;
}
</style>
