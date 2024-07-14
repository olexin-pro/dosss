<script setup>
import {ref} from "vue";
import { onClickOutside } from '@vueuse/core'
const popup = ref(null)
const active = ref(false);
onClickOutside(popup, event =>active.value = false)
</script>

<template>
    <div class="relative ml-3">
        <div>
            <button class="px-3 pb-2 pt-2 text-4xl bg-blue-400 hover:bg-blue-500 rounded-xl text-white"
                    ref="popup"
                    @click="active = !active">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-white">
                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
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
        <div class="absolute left-0 z-10 mt-2 w-96 h-96 overflow-y-auto origin-top-left rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
             v-if="active"
             role="menu"
             aria-orientation="vertical"
             aria-labelledby="category-menu-button"
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
