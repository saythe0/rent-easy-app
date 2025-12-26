<template>
    <div class="space-y-10">
        <header class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold">Каталог</h1>
                <p class="mt-2 text-sm text-ink/70">Фильтры помогают быстро найти нужную вещь.</p>
            </div>
            <div class="rounded-full bg-white px-5 py-2 text-sm shadow-soft">
                {{ products.length }} товаров
            </div>
        </header>

        <section class="grid gap-8 lg:grid-cols-[280px_1fr] items-start">
            <form class="glass-panel rounded-[28px] p-6" @submit.prevent="applyFilters">
                <div class="space-y-5">
                    <BaseSelect
                        v-model="filters.category"
                        label="Категория"
                        :options="categoryOptions"
                    />
                    <div class="grid gap-4">
                        <BaseInput
                            v-model="filters.priceFrom"
                            type="number"
                            label="Цена от"
                            :placeholder="pricePlaceholder.from"
                        />
                        <BaseInput
                            v-model="filters.priceTo"
                            type="number"
                            label="Цена до"
                            :placeholder="pricePlaceholder.to"
                        />
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <BaseButton type="submit">Применить</BaseButton>
                        <button
                            type="button"
                            class="rounded-full border border-ink/20 px-5 py-3 text-sm font-semibold"
                            @click="resetFilters"
                        >
                            Сбросить
                        </button>
                    </div>
                </div>
            </form>

            <div>
                <div v-if="loading" class="rounded-3xl bg-white p-8 text-sm text-ink/60">
                    Загружаем каталог...
                </div>
                <div v-else-if="error" class="rounded-3xl bg-white p-8 text-sm text-rose-600">
                    {{ error }}
                </div>
                <div v-else class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <ProductCard v-for="product in products" :key="product.id" :product="product" />
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import http from '@/api/http'
import BaseSelect from '@/components/ui/BaseSelect.vue'
import BaseInput from '@/components/ui/BaseInput.vue'
import BaseButton from '@/components/ui/BaseButton.vue'
import ProductCard from '@/components/cards/ProductCard.vue'

const filters = ref({
    category: 'all',
    priceFrom: '',
    priceTo: '',
})

const categories = ref([])
const priceRange = ref({ min_price: null, max_price: null })
const products = ref([])
const loading = ref(false)
const error = ref('')

const categoryOptions = computed(() => [
    { value: 'all', label: 'Все категории' },
    ...categories.value.map((category) => ({ value: category.id, label: category.name })),
])

const pricePlaceholder = computed(() => ({
    from: priceRange.value.min_price ? `от ${priceRange.value.min_price} ₽` : 'от 0 ₽',
    to: priceRange.value.max_price ? `до ${priceRange.value.max_price} ₽` : 'до 0 ₽',
}))

const fetchFilters = async () => {
    try {
        const { data } = await http.get('/products/filters')
        categories.value = data?.categories?.data ?? data.categories ?? []
        priceRange.value = data?.priceRange ?? { min_price: null, max_price: null }
    } catch (err) {
        error.value = 'Не удалось загрузить фильтры.'
    }
}

const fetchProducts = async () => {
    loading.value = true
    error.value = ''

    try {
        const params = {}
        if (filters.value.category !== 'all') {
            params.category = filters.value.category
        }
        if (filters.value.priceFrom) {
            params.priceFrom = filters.value.priceFrom
        }
        if (filters.value.priceTo) {
            params.priceTo = filters.value.priceTo
        }

        const { data } = await http.get('/products', { params })
        products.value = data?.data ?? data
    } catch (err) {
        error.value = 'Не удалось загрузить каталог.'
    } finally {
        loading.value = false
    }
}

const applyFilters = async () => {
    await fetchProducts()
}

const resetFilters = async () => {
    filters.value = { category: 'all', priceFrom: '', priceTo: '' }
    await fetchProducts()
}

onMounted(async () => {
    await fetchFilters()
    await fetchProducts()
})
</script>
