<template>
    <p class="text-xs text-rose-600">
        {{ message }}
    </p>
</template>

<script setup>
const props = defineProps({
    message: { type: String, default: '' },
})
</script>
