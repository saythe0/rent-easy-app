<template>
    <div class="flex items-center gap-1">
        <button
            v-for="star in 5"
            :key="star"
            type="button"
            class="text-2xl transition"
            :class="star <= modelValue ? 'text-amber-400' : 'text-ink/20'"
            @click="$emit('update:modelValue', star)"
            :aria-label="`Оценка ${star}`"
        >
            ★
        </button>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: { type: Number, default: 0 },
})

defineEmits(['update:modelValue'])
</script>
