<script setup>
import {ref} from "vue";
import { onClickOutside } from '@vueuse/core'

const props = defineProps({
    title: {
        type: String,
        required: true
    }
})

const dropdown = ref(null)
const active = ref(false);
onClickOutside(dropdown, event =>active.value = false)
</script>

<template>
    <div class="relative ml-3">
        <div>
            <button type="button" ref="dropdown" @click="active = !active"
                    aria-expanded="false"
                    aria-haspopup="true">
                <span class="sr-only">Открыть меню</span>
                {{title}}
            </button>
        </div>

        <!--
          Dropdown menu, show/hide based on menu state.

          Entering: "transition ease-out duration-100"
            From: "transform opacity-0 scale-95"
            To: "transform opacity-100 scale-100"
          Leaving: "transition ease-in duration-75"
            From: "transform opacity-100 scale-100"
            To: "transform opacity-0 scale-95"
        -->
        <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
             v-if="active"
             role="menu"
             aria-orientation="vertical"
             aria-labelledby="user-menu-button"
             tabindex="-1">
            <slot/>
        </div>
    </div>
<!--<div class="relative">-->
<!--    <button class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-xl" @click="active = !active" ref="dropdown">-->
<!--        Dropdown-->
<!--    </button>-->

<!--    <div class="absolute right-0 bg-white rounded-xl shadow-xl grid grid-cols-1 gap-y-1 divide-y p-3"-->
<!--         v-if="active"-->
<!--         v-cloak>-->
<!--        <slot/>-->
<!--    </div>-->
<!--</div>-->
</template>

<style scoped>

</style>
