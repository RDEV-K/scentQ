<template>
    <component
        v-for="(section, sectionIndex) in sections"
        :key="'section-' + sectionIndex"
        :is="section.component"
        v-bind="section.props"
    ></component>
</template>

<script>
import UserPage from "../Layouts/UserPage.vue";

export default {
    layout: UserPage,
    props: {
        sections: Array,
    },
};
</script>

<style lang="scss">
@import "../../scss/gifts.scss";
</style>
