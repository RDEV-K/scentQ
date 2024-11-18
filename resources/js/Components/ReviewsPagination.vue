<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1" style="display: flex; justify-content: center; column-gap: 7px; margin-top: 20px;">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 text-sm leading-4 text-gray-400 pagination-page-link text-dark"
                     v-html="link.label"/>
                <inertia-link v-else
                              class="mr-1 mb-1 pagination-page-link text-decoration-none text-sm leading-4 hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                              :class="{ 'bg-blue-700 text-white pagination-page-link-active': link.active }" :href="link.url" v-html="link.label"/>
            </template>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        links: Array
    },
}
</script>
