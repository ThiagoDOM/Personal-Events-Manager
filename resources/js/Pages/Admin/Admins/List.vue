<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import ModalDelete from '@/Components/ModalDelete.vue'
import { ref } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
    admins: {
        type: Object,
    }
});

const openDeleteModal = (admin) => {
    adminSelected.value = admin.id;
    isOpen.value = true;
}

const success = () => {
    router.reload();
}

const isOpen = ref(false);
const adminSelected = ref(null);

</script>


<template>
    <Head title="Admins List" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Admins List</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">ID</th>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">Email</th>
                                        <th scope="col" class="px-6 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="admin in admins.data" :key="admin.id"
                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <td scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                                admin.id }}</td>
                                        <td class="px-6 py-4">{{ admin.name }}</td>
                                        <td class="px-6 py-4">{{ admin.email }}</td>
                                        <td class="px-6 py-4">
                                            <Link :href="route('admin.admins.edit', admin.id)">
                                                <SecondaryButton>Edit</SecondaryButton>
                                            </Link>
                                                <DangerButton class="ms-3"
                                                @click="openDeleteModal(admin)">Delete</DangerButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :pagination="admins.meta" />
                    </div>


                </div>
            </div>
        </div>
        <ModalDelete v-if="isOpen" @success="success()" @close="isOpen = false" :id="adminSelected"
            :url="'admin.admins.destroy'" />
    </AdminLayout>
</template>
