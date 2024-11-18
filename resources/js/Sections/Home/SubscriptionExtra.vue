<template>
    <!-- home blog section -->
    <section class="home blog-section collection-section">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-9 col-xl-9">
                    <h2>{{ title }}</h2>
                    <p class="sub-title">{{ sub_title }}</p>
                </div>

                <div class="col-md-3 col-xl-3 d-none d-lg-block">
                    <a href="#" class="btn btn-lg btn-long btn-black float-end">
                        View Suggestion
                        <!-- <img class="icon-right" src="/images/svg/ico-arrow-r-light.svg" /> -->
                    </a>
                </div>
            </div>
            <div class="row gy-0 gy-md-3 justify-content-center" v-if="cards && cards.length">
                <div class="col-md-6 col-lg-4" v-for="(card, cardIndex) in cards" :key="cardIndex">
                    <div class="single-blog">
                        <div class="blog-image img-thumbnail border-0">
                            <img
                                :src="card.image"
                                :alt="card.title+' image'"
                                class="img-fluid"
                            />
                        </div>
                        <div class="blog-content">
                            <h3>{{ card.title }}</h3>
                            <p>{{ card.desc }}</p>
                            <Link :href="card.button_link" class="simple-anchor">
                                {{ card.button_text }}
                                <img class="icon-right"
                                    src="../../../images/svg/Ico_carousel_Arrow_R-pink.svg"
                                />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <Link href="#" class="view-all btn btn-black d-block d-md-none">
                view all suggestion
            </Link>
        </div>
    </section>
    <!-- home blog section -->
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default{
    props: {
        title: String,
        sub_title: String,
        cards: Array
    },
    components: {Link}
}
</script>
