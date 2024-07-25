<script setup>
import {ref} from "vue";
import TypesenseInstantSearchAdapter from "typesense-instantsearch-adapter";
import { AisInstantSearch, AisSearchBox, AisHits } from 'vue-instantsearch/vue3/es';
import 'instantsearch.css/themes/reset-min.css';
import ProductCard from "./ProductCard.vue";

const props = defineProps({
    searchHost: {type: String, default: 'localhost'},
    searchProtocol: {type: String, default: 'http'},
    searchPort: {type: String, default: '8108'},
    apiKey: {type: String, default: 'abc'},
    defaultValue: {
        type: String,
        default: ''
    },
})

const typesenseInstantsearchAdapter = new TypesenseInstantSearchAdapter({
    server: {
        apiKey: props.apiKey,
        nodes: [
            {
                host: props.searchHost,
                port: props.searchPort,
                protocol: props.searchProtocol,
            },
        ],
        cacheSearchResultsForSeconds: 2 * 60, // Cache search results from server. Defaults to 2 minutes. Set to 0 to disable caching.
    },
    additionalSearchParameters: {
        query_by: "title,description,category,search_keys",
    },
});
</script>

<template>
    <div class="search-container">

        <ais-instant-search
            :search-client="typesenseInstantsearchAdapter.searchClient"
            index-name="products"
        >
            <div class="left-panel">
<!--                <ais-clear-refinements />-->
                <ais-refinement-list
                    attribute="category"
                    searchable-placeholder="Поиск категорий..."
                    searchable />
                <ais-configure :hitsPerPage="16" />
            </div>
            <div class="right-panel">
                <ais-search-box />
                <ais-hits>
                    <template v-slot:item="{ item }">
                        <product-card :product="item" />
<!--                        <a :href="`/catalog/product/${item.slug}`" class="search-item">-->
<!--                            <h2 class="title">{{ item.title }}</h2>-->
<!--                            <p class="description">{{item.description}}</p>-->
<!--                        </a>-->
                    </template>
                </ais-hits>
                <ais-pagination />
            </div>
        </ais-instant-search>
<!--            <ais-search-box />-->
<!--            <ais-hits>-->

<!--                <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-4">-->

<!--                    <div class="hidden md:block md:col-span-4 lg:col-span-2">-->
<!--                        <div class="card-body">-->
<!--                            Категории-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="col-span-full md:col-span-8 lg:col-span-10">-->

<!--                        <div class="grid grid-cols-4 gap-4">-->
<!--                            <template v-slot:item="{ item }">-->
<!--                                <a :href="`/catalog/product/${item.slug}`" class="search-item">-->
<!--                                    <h2>{{ item.title }}</h2>-->
<!--                                </a>-->
<!--                            </template>-->
<!--                        </div>-->

<!--                    </div>-->

<!--                </div>-->
<!--            </ais-hits>-->

<!--        </ais-instant-search>-->

    </div>
</template>

<style lang="scss" scoped>
.search-container{

}

.ais-Hits-list {
    margin-top: 0;
    margin-bottom: 1em;

    .ais-Hits-item{
        padding: 0 !important;
        border: none !important;
    }
}

.ais-InstantSearch {
    display: grid;
    grid-template-columns: 1fr 4fr;
    grid-gap: 1em;
}

.ais-Pagination{
    @apply mt-4;
}

.search-item{
    .title{
        @apply font-bold;
    }
    .description{
        @apply text-sm;
    }
}


</style>
