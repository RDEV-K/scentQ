<template>
    <section class="bg-white pt-5">
        <div class="container">
            <div>
                <h4> New Arrivals </h4>
                <!--
                <div class="anchor-tab">
                    <Link :href="route('new.arrivals')" :class="{'active': isRoute('new.arrivals')}">{{
                            __('See All')
                        }}
                    </Link>
                    <Link :href="route('new.arrivals', 'fine-fragrance')"
                          :class="{'active': isRoute('new.arrivals', 'fine-fragrance')}">{{ __('Fragrances') }}
                    </Link>
                    <Link :href="route('new.arrivals', 'makeup')"
                          :class="{'active': isRoute('new.arrivals', 'makeup')}">{{ __('Makeup') }}
                    </Link>
                </div> -->
                <Products :filter="{ new: true}" :infinity="true"/>
            </div>
        </div>
    </section>
</template>

<script>
import UserPage from '../Layouts/UserPage.vue'
import { Link } from '@inertiajs/inertia-vue3'
import Products from "@/Libs/Components/Products.vue";

export default {
    props: {
        type: String
    },
    components: { Link, Products },
    layout: UserPage,
    mounted() {
        // Check if the page has been loaded before
        if (!localStorage.getItem('firstLoad')) {
            // Set the flag in localStorage
            localStorage.setItem('firstLoad', 'true');
            // Reload the page
            window.location.reload();
        }
    },
    methods: {
        isRoute(name, params) {
            return this.$page.props.ziggy.url === this.route(name, params)
        }
    },
    computed: {
        actualType() {
            if (this.type === 'fine-fragrance') return ['perfume', 'cologne']
            return this.type
        }
    }
}
</script>

<style>
.anchor-tab {
    margin-bottom: 20px;
}

@media (max-width: 425px) {
    .anchor-tab a {
        padding: 12px 20px;
        font-size: 14px;
    }
}
</style>
