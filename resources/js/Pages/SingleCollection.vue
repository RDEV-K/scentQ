<template>
    <section class="recomendation-section">
        <div class="container">
            <div class="row g-3 g-lg-5 mb-5">
                <div class="col-md-6">
                    <img
                        class="img-fluid w-100"
                        :src="collection.image"
                        :alt="collection.name"
                    />
                </div>

                <div class="col-md-6 header-info">
                    <h4 class="profile-text">{{ collection.name }}</h4>
                    <p>{{ excerpt(collection.desc, 1000) }}</p>
                </div>
            </div>
            <Products :filter="{ collections: [collection.id], paginate: true }"/>
            <Collection type="capsule" :gen="gen" :except="[ collection.id ]"/>
            <Collection type="curated" :gen="gen" :except="[ collection.id ]"/>
        </div>
    </section>
</template>

<script>
import UserPage from "../Layouts/UserPage.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Collection from "@/Sections/Common/Collection.vue";
import Products from "@/Libs/Components/Products.vue";

export default {
    props: {
        collection: Object,
        gen: String
    },
    methods: {
        excerpt(string, limit = 100) {
            if (!string) return;
            return string.replace(/<\/?[^>]+>/ig, " ").slice(0, limit) + '...';
        }
    },
    components: {Products, Collection, Link},
    layout: UserPage
}
</script>

<style lang="scss">
@import "../../scss/recomendation.scss";
</style>
