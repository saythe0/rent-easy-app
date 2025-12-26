<template>
    <RouterLink
        :to="`/products/${product.slug}`"
        class="group flex h-full flex-col overflow-hidden rounded-3xl border border-ink/10 bg-white shadow-soft transition hover:-translate-y-1"
    >
        <div class="relative aspect-[4/3] overflow-hidden">
            <img
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                :src="imageUrl"
                :alt="product.name"
            />
            <div class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold">
                {{ product.condition }}
            </div>
        </div>
        <div class="flex flex-1 flex-col gap-2 p-5">
            <div class="text-lg font-semibold text-ink">{{ product.name }}</div>
            <div class="text-sm text-ink/70">{{ product.brand }} · {{ product.model }}</div>
            <div class="text-xs uppercase tracking-[0.2em] text-ink/50">{{ product.category?.name }}</div>
            <div class="mt-auto flex items-center justify-between">
                <div class="text-sm font-semibold">{{ product.price }} ₽/сутки</div>
                <div class="text-xs text-ink/50">{{ product.status }}</div>
            </div>
        </div>
    </RouterLink>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    product: { type: Object, required: true },
})

const imageUrl = computed(() => props.product?.first_image?.url || '/placeholder.svg')
</script>
