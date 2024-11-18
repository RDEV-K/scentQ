<template>
    <div class="col-lg-9 m-auto heading">
        <div v-html="heading_desc"></div>
    </div>
</template>

<script>
export default {
    props: {
        heading_desc: String,
    },
};
</script>
