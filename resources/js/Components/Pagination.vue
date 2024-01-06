<template>

    <nav class="relative flex justify-center mt-3">
        <template v-for="link in pagination.links" :key="link.label">
            <Link
            preserve-scroll
            preserve-state
            v-if="link.url || link.label == '...'"
            :href="link.url || ''"
            v-html="link.label"
            class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-gray-700 dark:text-gray-200"
            :class="{ 'bg-gray-300 dark:bg-gray-700': link.active, '!text-gray-400 dark:text-gray-500': !link.url }"
            />
        </template>
    </nav>

</template>
<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    pagination: Object
})
</script>
