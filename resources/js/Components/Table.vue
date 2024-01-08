<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import ModalDelete from '@/Components/ModalDelete.vue'
import { ref } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import TextInput from '@/Components/TextInput.vue';
import Table from '@/Components/Table.vue';
import { useForm, usePage } from '@inertiajs/vue3';

defineProps({
    items: {
        type: Object,
    },
    columns: {
        type: Array,
    },
    query: {
        type: Object
    },
    routeBase: {
        type: String
    }
});

const openDeleteModal = (item) => {
    itemSelected.value = item.id;
    isOpen.value = true;
}

const success = () => {
    router.reload();
}

const form = useForm({
    name: usePage().props?.query.name ?? "",
});

const isOpen = ref(false);
const itemSelected = ref(null);

</script>

<template>
    <form class="flex" @submit.prevent="form.get(route(routeBase + '.index'))">
        <TextInput id="current_password" ref="currentPasswordInput" v-model="form.name" type="text"
            class="mt-1 md:w-60 w-full" placeholder="Name" />
        <div class="flex-row-reverse">
            <button type="submit" class="ml-3 mr-3 mt-3"><font-awesome-icon :icon="['fas', 'magnifying-glass']" /></button>
        </div>
        <div class="ml-auto mt-2">
            <Link v-if="route().has(routeBase + '.create')" :href="route(routeBase + '.create')">
                <PrimaryButton>Create</PrimaryButton>
            </Link>
        </div>
    </form>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th v-for="column in columns" :key="column.key" scope="col" class="px-6 py-3">{{
                        column.name }}</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items.data" :key="item.id"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td v-for="column in columns" :key="column.key" class="px-6 py-4"
                        :class="{ 'font-medium text-gray-900 whitespace-nowrap dark:text-white': column.key == 'id' }">
                        {{ item[column.key] }}</td>
                    <td class="px-6 py-4">
                        <Link v-if="route().has(routeBase + '.edit', item.id)" :href="route(routeBase + '.edit', item.id)">
                        <SecondaryButton>Edit</SecondaryButton>
                        </Link>
                        <DangerButton v-if="route().has(routeBase + '.destroy', item.id)" class="ms-0 sm:ms-3" @click="openDeleteModal(item)">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Pagination :pagination="items.meta" />

    <ModalDelete v-if="isOpen" @success="success()" @close="isOpen = false" :id="itemSelected"
        :url="routeBase + '.destroy'" />
</template>
