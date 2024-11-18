<template>
    <section v-if="!$page.props.user" class="landing ll-mysterious-feeling">
        <div class="container">
            <div class="ll-mysterious-feeling-content">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="ll-mysterious-feeling-content-container">
                        <h3>{{ __(title)}}</h3>
                        <p>{{ __(sub_title)}}</p>
                        <Link :href="button_link" class="tw-whitespace-pre btn btn-lg btn-black">
                        <template v-if="$page.props.user?.quiz_answered">
                            {{ __('Edit quiz') }}
                        </template>
                        <template v-else>
                            {{ __(button_text) }}
                        </template>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: { Link },
    props: {
        title: String,
        sub_title: String,
        button_text: String,
        button_link: String,
        slides: Array
    },
};
</script>
<style>
.ll-mysterious-feeling-content {
    background-image: url('../../../images/bg/mystorias-feelling.webp');
    background-size: contain;
    background-position: center center;
    background-repeat: no-repeat;
    padding: 100px 0px;
    overflow: hidden;
}
@media (max-width: 1200px) {
    .ll-mysterious-feeling-content {
        background-size: cover;
    }
}
@media (min-width: 1024px) {
    .ll-mysterious-feeling-content-container {
        max-width: 524px;
        text-align: center;
    }
}


.ll-mysterious-feeling-content-container h3 {
    font-family: 'TT Norms Pro', sans-serif;
    font-weight: 600;
    font-size: 40px;
    line-height: 48px;
    color: #000000;
    margin-bottom: 24px;
}

.ll-mysterious-feeling-content-container p {
    font-family: 'TT Norms Pro', sans-serif;
    font-weight: 400;
    font-size: 20px;
    line-height: 28px;
    color: #000000;
    margin-bottom: 24px;
}

@media (max-width: 525px) {
    .ll-mysterious-feeling-content {
        padding: 40px 24px;
    }

    .ll-mysterious-feeling-content-container h3 {
        font-size: 24px;
        line-height: 32px;
    }
}
</style>
