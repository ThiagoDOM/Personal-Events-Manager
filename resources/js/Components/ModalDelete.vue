<template>
    <Modal :show="true" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <font-awesome-icon icon="triangle-exclamation" class="text-red-600" /> Delete
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to delete this item? This action cannot be undone.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    :html="{ '...': form.processing }" @click="deleteUser(id, url)">
                    Delete Item
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import { defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
// import 'vue-toast-notification/dist/theme-default.css';

defineProps({
    id: {
        type: Number
    },
    url: {
        type: String
    },
});

const emit = defineEmits(['close', 'error', 'success']);
const form = useForm({});
const $toast = useToast();
const options = {
    position: 'top-right',
    duration: 5000
};

const deleteUser = (id, url) => {
    axios.delete(route(url, id))
        .then(() => {
            successModal();
        })
        .catch((err) => {
            errorModal(err?.response.status);
        });
};
const closeModal = () => {
    emit('close');
}
const successModal = () => {
    $toast.success("Item deleted with success!", options);
    emit('success');
    closeModal();
}

const errorModal = (status) => {
    if(status == 404)
        $toast.error("Item don't found!", options);
    else if(status == 401)
        $toast.error("No permission to delete!", options);
    else
        $toast.error("Oops, an error occurred!", options);

    console.log('erro!');
    emit('error');
}

</script>
