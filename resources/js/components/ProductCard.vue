<script setup>
const props = defineProps({
    product: {
        title: String,
        slug: String,
        description: String,
    }
})

const url = `/catalog/product/${props.product.slug}`;
</script>

<template>
    <div class="bg-white shadow hover:shadow-xl rounded-xl overflow-hidden transition duration-300 ease-in-out">
        <a :href="url" :title="product.title">
            <img
                class="w-full object-contain object-center bg-white"
                src="/assets/images/no-image.png"
                alt="image">
        </a>
        <a v-if="product.category" :href="url" :title="`Категория ${product.category}`">
            <h5 class="px-4 text-sm font-semibold text-gray-400">
                {{product.category}}
            </h5>
        </a>
        <a :href="url" :title="product.title">
            <h4 class="px-4 text-sm font-semibold">
                {{product.title}}
            </h4>
        </a>
        <div class="p-4 flex justify-between gap-x-4 items-center">
            <p class="text-sm font-light mt-1">
                {{product.price}} Тенге
            </p>
            <div>
                <a href="#" class="whitespace-nowrap text-sm bg-blue-300 hover:bg-blue-400 rounded-xl px-6 py-2.5 text-blue-900 transition duration-300 ease-in-out">
                    В корзину
                </a>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
