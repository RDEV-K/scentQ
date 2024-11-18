<template>
    <component :is="as" v-bind="$attrs" class="trigger-menu">
        <slot></slot>
    </component>
</template>

<script>
export default {
    props: {
        as: {
            type: String,
            default: 'div'
        }
    },
    data() {
        return {
            body: null,
            lastScroll: 0,
            scrollUp: 'scroll-up',
            scrollDown: 'scroll-down',
        }
    },
    mounted() {
        this.body = document.body
        window.addEventListener('scroll', this.onScroll)
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.onScroll)
    },
    methods: {
        onScroll() {
            if (this.$el?.classList?.contains('product-list-hover-nav')) {
                if (this.isInViewport(document.querySelector('.products-list-row'))) {
                    this.$el?.classList.add('d-md-flex')
                    this.body.classList.remove(this.scrollDown)
                    this.body.classList.add(this.scrollUp)
                } else {
                    this.body.classList.add(this.scrollDown)
                    this.body.classList.remove(this.scrollUp)
                    this.$el?.classList.remove('d-md-flex')
                }
            } else {
                const currentScroll = window.pageYOffset;
                if (currentScroll <= 0) {
                    this.body.classList.remove(this.scrollUp);
                    return;
                }

                if (currentScroll > this.lastScroll && !this.body.classList.contains(this.scrollDown)) {
                    // down
                    this.body.classList.remove(this.scrollUp);
                    this.body.classList.add(this.scrollDown);
                } else if (
                    currentScroll < this.lastScroll &&
                    this.body.classList.contains(this.scrollDown)
                ) {
                    // up
                    this.body.classList.remove(this.scrollDown);
                    this.body.classList.add(this.scrollUp);
                }
                this.lastScroll = currentScroll;
            }
        },
        isInViewport(ele) {
            if (!ele) return false
            const rect = ele.getBoundingClientRect()
            const elementTop = rect.top + window.scrollY;
            const elementBottom = elementTop + rect.height
            const viewportTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            const viewportBottom = viewportTop + document.querySelector('html').clientHeight;
            return elementBottom > viewportTop && elementTop < viewportBottom;
        }
    }
}
</script>

<style lang="scss">
.trigger-menu {
    transition: transform 0.4s;
}

/* .scroll-down .trigger-menu {
    transform: translate3d(0, -100%, 0);
} */

.scroll-up .trigger-menu {
    transform: none;
}
</style>
