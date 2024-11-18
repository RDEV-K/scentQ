<template>
    <section>
      <div class="capsule collection-section" v-if="collections.length">
        <div class="container">
          <div class="collection-section-heading">
            <h2>{{ title }}</h2>
            <p>{{ sub_title }}</p>
          </div>
          <div class="row gy-3" v-if="collections && collections.length">
            <div class="col-md-4" v-for="(collection, collectionIndex) in  collections" :key="collectionIndex">
              <div class="scentq-collection-card">
                <div class="img-thumbnail border-0 p-0">
                  <img
                      :src="collection.image"
                      class="img-fluid"
                      :alt="collection.name+' image'"
                  />
                </div>
                <h3>{{ collection.name }}</h3>
                <p>{{ excerpt(collection.desc) }}</p>
                <Link :href="route('collection', {type: collection.for, slug: collection.slug})" class="link text-capitalize simple-anchor simple-anchor-medium">
                  {{ __('Browse Collection') }}
                  <img src="../../../images/svg/Ico_carousel_Arrow_R-pink.svg" class="icon-right"/>
                </Link>
              </div>
            </div>
          </div>
          <Progress v-if="loading"/>
        </div>
      </div>
    </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import axios from "axios"
import Progress from "@/Libs/Components/ProgressBar.vue"

export default{
    components: {Link, Progress},
    props: {
        title: String,
        sub_title: String,
        gen: String,
        type: String,
        except: Object
    },
    data() {
        return {
            collections: [],
            loading: false
        }
    },
    beforeMount() {
        axios.get(this.route('section.data', 'getCollection'), {
            params: {
                for: this.gen,
                type: this.type,
                except: this.except
            }
        }).then(({ data }) => {
            this.collections = data
        }).catch(e => {
        }).finally(() => {
            this.loading = false
        })
    },
    methods: {
         excerpt(string, limit = 100) {
            if (!string) return;
            return string.replace(/<\/?[^>]+>/ig, " ").slice(0, limit) + '...';
        },
    },
}
</script>
