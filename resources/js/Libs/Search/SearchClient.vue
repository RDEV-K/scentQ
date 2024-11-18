<template>
    <ais-instant-search :search-client="searchClient" :index-name="cIndex">
        <slot></slot>
    </ais-instant-search>
</template>

<script>
import algoliasearch from "algoliasearch/lite";
import {
    AisInstantSearch,
} from 'vue-instantsearch/vue3/es';
export default {
    components: {
        AisInstantSearch,
    },
    props: {
        index: {
            type: String,
            default: 'products'
        },
        callContext: {
            type: String,
            default: 'searchBox'
        }
    },
    data() {
        return {
            algoliaClient: algoliasearch(
                this.$page.props.config.scout.id,
                this.$page.props.config.scout.key
            )
        }
    },
    computed: {
        cIndex() {
            return this.$page.props.config.scout.prefix + 'products'
        },
        searchClient() {
            const _algoliaClient = this.algoliaClient
            const _callContext = this.callContext

            return {
                ..._algoliaClient,
                search(requests) {
                    if (_callContext === 'searchBox' && requests.every(({ params }) => !params.query)) {
                        return Promise.resolve({
                            results: requests.map(() => ({
                                hits: [],
                                nbHits: 0,
                                nbPages: 0,
                                page: 0,
                                processingTimeMS: 0,
                            })),
                        });
                    }

                    return _algoliaClient.search(requests);
                },
            }
        }
    }
}
</script>
