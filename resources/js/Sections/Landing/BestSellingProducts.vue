<template>
    <section class="landing section-padding products-list tw-bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="ll-products-list-title">{{ __(title) }}</h3>
                </div>
            </div>

            <Products :filter="{ bestSelling: true }" :load-more="load_more" />
        </div>
    </section>
</template>

<script>
import Products from "@/Libs/Components/Products.vue";
export default {
    props: {
        title: String,
        load_more: String,
    },
    components: { Products },
};
</script>
<style>
.ll-products-list-title{
    font-family: "TT Norms Pro", sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 40px;
    line-height: 48px;
    color: #000000;
    margin-bottom: 50px;
}

@media (max-width: 525px) {
    .ll-products-list-title{
        font-size: 24px;
        line-height: 32px;
        margin-bottom: 32px;
    }
}
</style>
