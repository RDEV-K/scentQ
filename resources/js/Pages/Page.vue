<template>
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="section-image">
                        <img :src="page.image" :alt="page.title+' image'" />
                    </div>

                    <h1 class="text-center">{{ page.title }}</h1>

                    <div class="content tw-px-5 tw-font-normal" v-html="page.content"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import UserPage from "../Layouts/UserPage.vue";

export default {
    layout: UserPage,
    props: {
        page: Object,
    },
};
</script>

<style lang="scss">
@import "../../scss/page.scss";
ul {
    list-style-type: disc;
}
ol {
    list-style-type: decimal;
}
</style>
