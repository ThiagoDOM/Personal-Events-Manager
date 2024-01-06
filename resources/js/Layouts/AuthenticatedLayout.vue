<script setup>
import UserLayout from './UserLayout.vue';
import AdminLayout from './AdminLayout.vue';

</script>
<template>
    <UserLayout v-if="$page.props.auth.user.role == 'user'">
        <slot></slot>
    </UserLayout>
    <AdminLayout v-if="$page.props.auth.user.role == 'admin'">
        <slot></slot>
    </AdminLayout>
</template>
