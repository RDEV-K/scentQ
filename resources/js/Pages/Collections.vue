<template>
    <div>
        <component v-for="(section, sectionIndex) in sections" :key="'section-' + sectionIndex" :is="section.component" v-bind="{...section.props, gen}"></component>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import UserPage from "../Layouts/UserPage.vue";
import Collection from "@/Sections/Common/Collection.vue";

export default {
    props: {
        sections: Object,
        gen: String
    },
    components: {Link, Collection},
    layout: UserPage
}
</script>

