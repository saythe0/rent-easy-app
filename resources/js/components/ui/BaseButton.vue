<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center rounded-full bg-ink px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:opacity-60"
        v-bind="$attrs"
    >
        <slot />
    </button>
</template>

<script setup>
const props = defineProps({
    type: { type: String, default: 'button' },
})
</script>
