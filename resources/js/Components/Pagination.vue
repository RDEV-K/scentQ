<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1" style="display: flex;">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                     v-html="link.label"/>
                <inertia-link v-else
                              class="mr-1 mb-1 px-4 py-3 text-decoration-none text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                              :class="{ 'bg-blue-700 text-dark': link.active }" :href="link.url" v-html="link.label" style="color:#000;"/>
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
