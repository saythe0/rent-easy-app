<template>
    <div class="rounded-3xl border border-ink/10 bg-white p-5 shadow-soft">
        <div class="flex items-center justify-between">
            <div class="text-sm font-semibold text-ink">{{ review.user?.name || 'Аноним' }}</div>
            <div class="text-xs text-ink/50">{{ review.date }}</div>
        </div>
        <div class="mt-3 text-amber-400">
            <span v-for="star in 5" :key="star" :class="star <= review.rating ? '' : 'text-ink/20'">★</span>
        </div>
        <p class="mt-3 text-sm text-ink/80">{{ review.text }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    review: { type: Object, required: true },
})
</script>
