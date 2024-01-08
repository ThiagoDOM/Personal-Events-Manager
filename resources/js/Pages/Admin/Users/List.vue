<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';

defineProps({
    users: {
        type: Object,
    },
    query: {
        type: Object
    }
});

const columns = [
    {
        key: 'id',
        name: 'ID'
    },
    {
        key: 'name',
        name: 'Name'
    },
    {
        key: 'email',
        name: 'Email'
    },
];

</script>

<template>
    <Head title="Users List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users List</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Table :items="users" :columns="columns" :query="query" :routeBase="'admin.users'" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
