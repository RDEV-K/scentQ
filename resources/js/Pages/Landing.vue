<template>
    <component
        v-for="(section, sectionIndex) in sections"
        :key="'section-' + sectionIndex"
        :is="section.component"
        v-bind="section.props"
    ></component>
</template>

<script>
import Offer from "../Sections/Landing/Offer.vue";
import Slider from "@/Sections/Landing/Slider.vue";

import Partners from "@/Sections/Common/new_design_Partners.vue";
import Process from "@/Sections/Common/Process.vue";
//import Partners from "@/Sections/Common/Partners.vue";
import CallToAction from "@/Sections/Landing/CallToAction.vue";
import BestSellingProducts from "@/Sections/Landing/BestSellingProducts.vue";
import ParallaxCallToAction from "@/Sections/Common/ParallaxCallToAction.vue";
import UserPage from "@/Layouts/UserPage.vue";

export default {
    props: {
        sections: Array,
    },
    components: {
        Offer,
        Slider,
        Partners,
        Process,
        CallToAction,
        BestSellingProducts,
        ParallaxCallToAction,
    },
    layout: UserPage,

    mounted() {
        this.sections.forEach(element => {
            console.log(element.component)
        });
    },
    
};
</script>
