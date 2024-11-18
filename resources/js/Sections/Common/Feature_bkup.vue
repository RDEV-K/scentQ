<template>
    <!-- d-none d-md-block -->
    <section class="" :class="{'home-feature-section': slug}">
        <div class="container">
            <div class="feature-wrapper">
                <div class="row g-4" v-if="feature_iterator && feature_iterator.length">
                    <div class="col-md-6 col-lg-3" v-for="(feature, featureIndex) in feature_iterator" :key="featureIndex">
                        <div class="single-feature d-flex">
                            <div class="border-0 text-center">
                                <img
                                    :src="feature.image"
                                    class="img-fluid"
                                    :alt="feature.title"
                                />
                            </div>
                            <div class="feature-content">
                                <h4>{{ feature.title }}</h4>
                                <p>{{ feature.sub_title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default{
    props: {
        feature_iterator: Object,
        slug: String
    }
}
</script>
<style>
.home-feature-section {
    display:none; 
}
</style>