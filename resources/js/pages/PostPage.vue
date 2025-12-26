<template>
    <div v-if="post" class="space-y-10">
        <header class="space-y-4">
            <div class="text-xs uppercase tracking-[0.3em] text-ink/50">{{ post.category?.name }}</div>
            <h1 class="text-3xl font-semibold md:text-4xl">{{ post.title }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-ink/60">
                <div>Автор: {{ post.author?.name }}</div>
                <div>Роль: {{ post.author?.role }}</div>
                <div>{{ post.created_at }}</div>
            </div>
        </header>

        <img
            class="h-[320px] w-full rounded-[32px] object-cover shadow-soft"
            :src="post.image_url || '/placeholder.svg'"
            :alt="post.title"
        />

        <article
            class="article-content rounded-[32px] bg-white p-8 shadow-soft"
            v-html="post.content"
        />
    </div>

    <div v-else class="rounded-3xl bg-white p-8 text-sm text-ink/60 shadow-soft">
        Загружаем пост...
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import http from '@/api/http'

const route = useRoute()
const post = ref(null)

const fetchPost = async () => {
    const { data } = await http.get(`/posts/${route.params.slug}`)
    post.value = data?.data ?? data
}

onMounted(fetchPost)

watch(
    () => route.params.slug,
    async () => {
        await fetchPost()
    }
)
</script>
