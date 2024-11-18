<template>
    <span>
        {{timer.days}}:{{timer.hours}}:{{timer.minutes}}:{{timer.seconds}}
    </span>
</template>

<script>
import { defineComponent, watchEffect, onMounted } from "vue";
import { useTimer } from 'vue-timer-hook';
export default defineComponent({
    name: "Timer",
    props: {
        date: String
    },
    setup(props) {
        const time = new Date(props.date);
        console.log(props)
        const timer = useTimer(time);
        onMounted(() => {
            watchEffect(async () => {
                if(timer.isExpired.value) {
                    console.warn('IsExpired')
                }
            })
        })
        return {
            timer
        };
    },
});
</script>
