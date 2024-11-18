<template>
    <div class="d-flex align-items-center">
        <img v-if="item['image_url']" :src="item['image_url']" style="width: 60px;margin-right: 20px;"
            alt="image">
        <div>
            <h5 class="tw-font-bold tw-text-sm sm:tw-text-xl tw-mb-1" style="color: black;">
                {{ item['title'] ?? '' }}
            </h5>
            <div>
                <div class="!tw-text-black tw-text-xs sm:tw-text-base">
                    <strong>
                        Added to your queue
                    </strong>
                </div>
                <div class="!tw-text-black !tw-text-xs sm:tw-text-sm">
                    {{ item['month_name'] ?? '' }} in {{ item['year'] ?? '' }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
            default: null
        },
    },
    // computed: {
    //     monthName() {
    //         const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    //         return months[this.month - 1]
    //     }
    // }
}
</script>
<style>
    @media (max-width: 640px) {
        .Vue-Toastification__toast {
            padding: 8px 20px !important;
        }
        .Vue-Toastification__toast img {
            max-width: 32px !important;
        }
    }
</style>
