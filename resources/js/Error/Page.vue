<script setup lang="ts">
defineProps<{
  status: number
  message: string
}>()
</script>

<template>
  <div>
    <h1>Error {{ status }}</h1>

    <p>{{ message }}</p>
  </div>
</template>
