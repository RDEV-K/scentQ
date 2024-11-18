<template>
    <div class="row about-founder py-5">
        <div class="col-lg-9 m-auto">
            <blockquote class="blockquote">
                <div v-html="quote"></div>
            </blockquote>

            <div class="mt-5">
                <h4 class="gift-text">{{ quote_by }}</h4>
                <p class="text-secondary m-0">
                    <small>{{ designation }}</small>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        quote: String,
        quote_by: String,
        designation: String,
    },
};
</script>
