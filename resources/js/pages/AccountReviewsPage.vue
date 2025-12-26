<template>
    <section class="rounded-[32px] bg-white p-10 shadow-soft">
        <div class="space-y-2">
            <h1 class="text-3xl font-semibold">Мои отзывы</h1>
            <p class="text-sm text-ink/70">Все отзывы, которые вы оставили.</p>
        </div>

        <div class="mt-6">
            <AccountNav />
        </div>

        <div v-if="loading" class="mt-6 text-sm text-ink/60">Загружаем отзывы...</div>
        <div v-else-if="error" class="mt-6 text-sm text-rose-600">{{ error }}</div>
        <div v-else-if="reviews.length" class="mt-6 grid gap-4">
            <article
                v-for="review in reviews"
                :key="review.id"
                class="rounded-3xl border border-ink/10 bg-linen p-5"
            >
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="text-xs uppercase tracking-[0.2em] text-ink/50">
                            {{ review.product?.category?.name || 'Категория' }}
                        </div>
                        <RouterLink
                            v-if="review.product?.slug"
                            :to="`/products/${review.product.slug}`"
                            class="mt-2 block text-lg font-semibold text-ink"
                        >
                            {{ review.product?.name }}
                        </RouterLink>
                        <div v-else class="mt-2 text-lg font-semibold text-ink">{{ review.product?.name }}</div>
                        <p class="mt-2 text-sm text-ink/70">{{ review.text }}</p>
                    </div>
                    <div class="text-right text-sm">
                        <div class="text-amber-400">
                            <span v-for="star in 5" :key="star" :class="star <= review.rating ? '' : 'text-ink/20'">★</span>
                        </div>
                        <div class="mt-2 text-ink/60">{{ review.date }}</div>
                    </div>
                </div>
            </article>
        </div>
        <div v-else class="mt-6 text-sm text-ink/60">Пока отзывов нет.</div>
    </section>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import http from '@/api/http'
import AccountNav from '@/components/layout/AccountNav.vue'

const reviews = ref([])
const loading = ref(false)
const error = ref('')

const fetchReviews = async () => {
    loading.value = true
    error.value = ''

    try {
        const { data } = await http.get('/account/reviews')
        reviews.value = data?.data ?? data
    } catch (err) {
        error.value = 'Не удалось загрузить отзывы.'
    } finally {
        loading.value = false
    }
}

onMounted(fetchReviews)
</script>
