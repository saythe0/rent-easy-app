<template>
    <div class="space-y-10">
        <header class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold">Блог</h1>
                <p class="mt-2 text-sm text-ink/70">Новости и советы от команды RentEase.</p>
            </div>
            <div class="rounded-full bg-white px-5 py-2 text-sm shadow-soft">
                {{ posts.length }} материалов
            </div>
        </header>

        <div v-if="loading" class="rounded-3xl bg-white p-8 text-sm text-ink/60 shadow-soft">
            Загружаем блог...
        </div>
        <div v-else-if="error" class="rounded-3xl bg-white p-8 text-sm text-rose-600 shadow-soft">
            {{ error }}
        </div>
        <div v-else class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <PostCard v-for="post in posts" :key="post.id" :post="post" />
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import http from '@/api/http'
import PostCard from '@/components/cards/PostCard.vue'

const posts = ref([])
const loading = ref(false)
const error = ref('')

const fetchPosts = async () => {
    loading.value = true
    error.value = ''
    try {
        const { data } = await http.get('/posts')
        posts.value = data?.data ?? data
    } catch (err) {
        error.value = 'Не удалось загрузить блог.'
    } finally {
        loading.value = false
    }
}

onMounted(fetchPosts)
</script>
