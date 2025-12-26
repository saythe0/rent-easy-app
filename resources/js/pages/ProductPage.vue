<template>
    <div class="space-y-12" v-if="product">
        <section class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr]">
            <Swiper
                v-if="productImages.length"
                :modules="[Pagination]"
                :pagination="{ clickable: true }"
                class="overflow-hidden rounded-[28px]"
            >
                <SwiperSlide v-for="image in productImages" :key="image.url">
                    <img class="h-full w-full object-cover" :src="image.url" :alt="image.alt_text || product.name" />
                </SwiperSlide>
            </Swiper>
            <div v-else class="rounded-[28px] bg-white p-10 shadow-soft">
                <img src="/placeholder.svg" alt="Нет фото" class="h-full w-full object-cover" />
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.3em] text-ink/50">{{ product.category?.name }}</p>
                    <h1 class="text-3xl font-semibold">{{ product.name }}</h1>
                    <p class="text-sm text-ink/70">{{ product.brand }} · {{ product.model }}</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-soft">
                    <div class="flex items-center justify-between">
                        <div class="text-2xl font-semibold">{{ product.price }} ₽/сутки</div>
                        <div class="rounded-full bg-sand px-4 py-2 text-xs font-semibold">{{ product.status }}</div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3 text-xs text-ink/60">
                        <span class="rounded-full border border-ink/10 px-3 py-1">Состояние: {{ product.condition }}</span>
                        <span class="rounded-full border border-ink/10 px-3 py-1">Бренд: {{ product.brand }}</span>
                    </div>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-soft">
                    <h2 class="text-lg font-semibold">Описание</h2>
                    <p class="mt-3 text-sm text-ink/70">{{ product.description }}</p>
                </div>
            </div>
        </section>

        <section class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-soft">
                    <h2 class="text-xl font-semibold">Отзывы</h2>
                    <div v-if="reviewsLoading" class="mt-4 text-sm text-ink/60">Загружаем отзывы...</div>
                    <div v-else-if="reviews.length" class="mt-4 grid gap-4">
                        <ReviewCard v-for="review in reviews" :key="review.id" :review="review" />
                    </div>
                    <div v-else class="mt-4 text-sm text-ink/60">Пока нет отзывов.</div>
                </div>

                <div v-if="isAuthenticated" class="rounded-3xl bg-white p-6 shadow-soft">
                    <h3 class="text-lg font-semibold">Оставить отзыв</h3>
                    <p class="mt-2 text-sm text-ink/60" v-if="!canReview">
                        Отзыв можно оставить после активной или завершенной аренды.
                    </p>
                    <form v-else class="mt-4 space-y-4" @submit.prevent="submitReview">
                        <div>
                            <p class="text-sm font-medium text-ink/80">Рейтинг</p>
                            <StarRating v-model="reviewForm.rating" class="mt-2" />
                            <FormError v-if="reviewErrors.rating" :message="reviewErrors.rating?.[0]" class="mt-2" />
                        </div>
                        <BaseTextarea
                            v-model="reviewForm.comment"
                            label="Комментарий"
                            placeholder="Расскажите про опыт аренды"
                            :error="reviewErrors.comment?.[0]"
                        />
                        <div v-if="reviewMessage" class="rounded-2xl bg-sand px-4 py-3 text-sm">{{ reviewMessage }}</div>
                        <BaseButton type="submit" :disabled="reviewSubmitting">Отправить отзыв</BaseButton>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div v-if="isAuthenticated" class="rounded-3xl bg-white p-6 shadow-soft">
                    <h2 class="text-xl font-semibold">Аренда</h2>
                    <p class="mt-2 text-sm text-ink/70">Выберите даты и оставьте комментарий.</p>
                    <form class="mt-4 space-y-4" @submit.prevent="submitApplication">
                        <BaseInput
                            v-model="applicationForm.rental_start_date"
                            type="date"
                            label="Дата начала"
                            :error="applicationErrors.rental_start_date?.[0]"
                        />
                        <BaseInput
                            v-model="applicationForm.rental_end_date"
                            type="date"
                            label="Дата окончания"
                            :error="applicationErrors.rental_end_date?.[0]"
                        />
                        <BaseTextarea
                            v-model="applicationForm.comment"
                            label="Комментарий"
                            placeholder="Уточнения по получению"
                            :error="applicationErrors.comment?.[0]"
                        />
                        <div v-if="applicationMessage" class="rounded-2xl bg-sand px-4 py-3 text-sm">{{ applicationMessage }}</div>
                        <BaseButton type="submit" :disabled="applicationSubmitting">Отправить заявку</BaseButton>
                    </form>
                    <div v-if="application" class="mt-6 rounded-2xl border border-ink/10 bg-linen p-4 text-sm">
                        <div class="font-semibold">Текущая заявка</div>
                        <div class="mt-2 text-ink/60">Статус: {{ application.status }}</div>
                        <div class="text-ink/60">Даты: {{ application.rental_start_date }} — {{ application.rental_end_date }}</div>
                    </div>
                </div>
                <div v-else class="rounded-3xl bg-white p-6 text-sm text-ink/70 shadow-soft">
                    Чтобы отправить заявку или отзыв, войдите в аккаунт.
                </div>
            </div>
        </section>
    </div>

    <div v-else class="rounded-3xl bg-white p-8 text-sm text-ink/60 shadow-soft">
        Загружаем товар...
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination } from 'swiper/modules'
import http from '@/api/http'
import { useAuthStore } from '@/stores/auth'
import ReviewCard from '@/components/cards/ReviewCard.vue'
import BaseInput from '@/components/ui/BaseInput.vue'
import BaseTextarea from '@/components/ui/BaseTextarea.vue'
import BaseButton from '@/components/ui/BaseButton.vue'
import StarRating from '@/components/ui/StarRating.vue'
import FormError from '@/components/ui/FormError.vue'

const route = useRoute()
const authStore = useAuthStore()

const product = ref(null)
const reviews = ref([])
const reviewsLoading = ref(false)
const application = ref(null)
const applicationForm = ref({
    rental_start_date: '',
    rental_end_date: '',
    comment: '',
})
const applicationErrors = ref({})
const applicationMessage = ref('')
const applicationSubmitting = ref(false)

const reviewForm = ref({
    rating: 0,
    comment: '',
})
const reviewErrors = ref({})
const reviewMessage = ref('')
const reviewSubmitting = ref(false)

const isAuthenticated = computed(() => authStore.isAuthenticated)

const productImages = computed(() => {
    if (!product.value) return []
    const images = product.value.images ?? []
    if (images.length) return images
    if (product.value.first_image?.url) {
        return [product.value.first_image]
    }
    return []
})

const canReview = computed(() => {
    if (!application.value) return false
    return ['Возвращено', 'Активно'].includes(application.value.status)
})

const fetchProduct = async () => {
    const { data } = await http.get(`/products/${route.params.slug}`)
    product.value = data?.data ?? data
}

const fetchReviews = async () => {
    reviewsLoading.value = true
    try {
        const { data } = await http.get(`/products/${route.params.slug}/reviews`)
        reviews.value = data?.data ?? data
    } finally {
        reviewsLoading.value = false
    }
}

const fetchApplication = async () => {
    if (!authStore.isAuthenticated) return
    try {
        const { data } = await http.get(`/products/${route.params.slug}/application`)
        application.value = data?.data ?? data
    } catch (error) {
        application.value = null
    }
}

const submitApplication = async () => {
    applicationSubmitting.value = true
    applicationErrors.value = {}
    applicationMessage.value = ''

    try {
        const { data } = await http.post(`/products/${route.params.slug}/application`, applicationForm.value)
        application.value = data?.application?.data ?? data.application
        applicationMessage.value = data.message || 'Заявка отправлена.'
    } catch (error) {
        if (error?.response?.status === 422) {
            applicationErrors.value = error.response.data.errors || {}
        } else {
            applicationMessage.value = error?.response?.data?.message || 'Не удалось отправить заявку.'
        }
    } finally {
        applicationSubmitting.value = false
    }
}

const submitReview = async () => {
    reviewSubmitting.value = true
    reviewErrors.value = {}
    reviewMessage.value = ''

    try {
        const { data } = await http.post(`/products/${route.params.slug}/reviews`, reviewForm.value)
        reviewMessage.value = data.message || 'Отзыв отправлен.'
        reviewForm.value = { rating: 0, comment: '' }
        await fetchReviews()
    } catch (error) {
        if (error?.response?.status === 422) {
            reviewErrors.value = error.response.data.errors || {}
        } else {
            reviewMessage.value = error?.response?.data?.message || 'Не удалось отправить отзыв.'
        }
    } finally {
        reviewSubmitting.value = false
    }
}

const loadPage = async () => {
    await fetchProduct()
    await fetchReviews()
    await fetchApplication()
}

onMounted(loadPage)

watch(
    () => route.params.slug,
    async () => {
        await loadPage()
    }
)
</script>
