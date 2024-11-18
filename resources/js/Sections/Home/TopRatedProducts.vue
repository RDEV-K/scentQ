<template>
        <section class="home collection-section top-rated-products recommended-product">
        <div class="container">
            <div class="row">
                <h2>{{ title }}</h2>
            </div>
            <div class="row" v-if="topRatedProduct && topRatedProduct.length">
                <div class="col-md-6 col-lg-3" v-for="(product, productIndex) in topRatedProduct" :key="productIndex">
                    <TopRatedProductCard :product="product"/>
                </div>
            </div>
            <div class="row" v-if="loading">
                <Progress/>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios'
import Progress from "@/Libs/Components/ProgressBar.vue";
import TopRatedProductCard from '../../Libs/Components/Products/TopRatedProductCard.vue'

export default{
    components: { Progress, TopRatedProductCard },
    props: {
        title: String,
    },

    data() {
        return {
            topRatedProduct: [],
            loading: false
        }
    },

    beforeMount() {
        this.loading = true
        axios.get(this.route('filter.data'), {
            params: {
                topRated:true,
                limit: 4,
                with: ['badges']
            }
        }).then(({ data }) => {
            this.topRatedProduct = data
        }).catch(e => {
        }).finally(() => {
            this.loading = false
        })
    }
}
</script>
