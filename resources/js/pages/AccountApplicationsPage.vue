<template>
    <section class="rounded-[32px] bg-white p-10 shadow-soft">
        <div class="space-y-2">
            <h1 class="text-3xl font-semibold">Мои заявки</h1>
            <p class="text-sm text-ink/70">Все заявки на аренду, которые вы отправили.</p>
        </div>

        <div class="mt-6">
            <AccountNav />
        </div>

        <div v-if="loading" class="mt-6 text-sm text-ink/60">Загружаем заявки...</div>
        <div v-else-if="error" class="mt-6 text-sm text-rose-600">{{ error }}</div>
        <div v-else-if="applications.length" class="mt-6 grid gap-4">
            <article
                v-for="application in applications"
                :key="application.id"
                class="rounded-3xl border border-ink/10 bg-linen p-5"
            >
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="text-xs uppercase tracking-[0.2em] text-ink/50">
                            {{ application.product?.category?.name || 'Категория' }}
                        </div>
                        <RouterLink
                            v-if="application.product?.slug"
                            :to="`/products/${application.product.slug}`"
                            class="mt-2 block text-lg font-semibold text-ink"
                        >
                            {{ application.product?.name }}
                        </RouterLink>
                        <div v-else class="mt-2 text-lg font-semibold text-ink">{{ application.product?.name }}</div>
                        <p class="mt-1 text-sm text-ink/60">{{ application.comment }}</p>
                    </div>
                    <div class="text-right text-sm">
                        <div class="rounded-full bg-white px-4 py-2 text-xs font-semibold">
                            {{ application.status }}
                        </div>
                        <div class="mt-2 text-ink/60">
                            {{ application.rental_start_date }} — {{ application.rental_end_date }}
                        </div>
                        <div class="mt-1 font-semibold">{{ application.amount }} ₽</div>
                    </div>
                </div>
            </article>
        </div>
        <div v-else class="mt-6 text-sm text-ink/60">Пока заявок нет.</div>
    </section>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import http from '@/api/http'
import AccountNav from '@/components/layout/AccountNav.vue'

const applications = ref([])
const loading = ref(false)
const error = ref('')

const fetchApplications = async () => {
    loading.value = true
    error.value = ''

    try {
        const { data } = await http.get('/account/applications')
        applications.value = data?.data ?? data
    } catch (err) {
        error.value = 'Не удалось загрузить заявки.'
    } finally {
        loading.value = false
    }
}

onMounted(fetchApplications)
</script>
