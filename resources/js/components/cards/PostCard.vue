<template>
    <RouterLink
        :to="`/blog/${post.slug}`"
        class="group flex h-full flex-col overflow-hidden rounded-3xl border border-ink/10 bg-white shadow-soft transition hover:-translate-y-1"
    >
        <div class="relative aspect-[5/3] overflow-hidden">
            <img
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                :src="post.image_url || '/placeholder.svg'"
                :alt="post.short_title"
            />
        </div>
        <div class="flex flex-1 flex-col gap-3 p-5">
            <div class="text-xs uppercase tracking-[0.2em] text-ink/50">{{ post.category?.name }}</div>
            <div class="text-lg font-semibold text-ink">{{ post.short_title }}</div>
            <p class="text-sm text-ink/70">{{ post.excerpt }}</p>
            <div class="mt-auto text-xs text-ink/50">{{ post.created_at }}</div>
        </div>
    </RouterLink>
</template>

<script setup>
const props = defineProps({
    post: { type: Object, required: true },
})
</script>
