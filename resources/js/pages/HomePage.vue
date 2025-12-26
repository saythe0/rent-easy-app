<template>
    <section class="relative overflow-hidden rounded-[32px] bg-linen p-10 shadow-soft">
        <div class="absolute inset-0 hero-grid opacity-40"></div>
        <div class="relative grid gap-10 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="space-y-6">
                <p class="text-xs uppercase tracking-[0.4em] text-ink/50">Платформа аренды</p>
                <h1 class="text-balance text-4xl font-semibold leading-tight md:text-5xl">
                    RentEase — аренда вещей, к которым приятно возвращаться
                </h1>
                <p class="text-lg text-ink/70">
                    Соберите набор для проекта за вечер, бронируйте технику без лишних звонков
                    и возвращайте вещи в удобное время.
                </p>
                <div class="flex flex-wrap gap-4">
                    <RouterLink
                        to="/catalog"
                        class="rounded-full bg-ink px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5"
                    >
                        Открыть каталог
                    </RouterLink>
                    <RouterLink
                        to="/about"
                        class="rounded-full border border-ink/20 px-6 py-3 text-sm font-semibold transition hover:-translate-y-0.5"
                    >
                        Как мы работаем
                    </RouterLink>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl bg-white/90 p-4 text-sm shadow-soft">
                        <div class="text-lg font-semibold">1200+</div>
                        <div class="text-ink/60">предметов в аренду</div>
                    </div>
                    <div class="rounded-2xl bg-white/90 p-4 text-sm shadow-soft">
                        <div class="text-lg font-semibold">24 часа</div>
                        <div class="text-ink/60">среднее время сделки</div>
                    </div>
                    <div class="rounded-2xl bg-white/90 p-4 text-sm shadow-soft">
                        <div class="text-lg font-semibold">4.9</div>
                        <div class="text-ink/60">средний рейтинг</div>
                    </div>
                </div>
            </div>
            <Swiper
                :modules="[Pagination]"
                :pagination="{ clickable: true }"
                class="h-full w-full overflow-hidden rounded-[28px]"
            >
                <SwiperSlide v-for="slide in slides" :key="slide.title">
                    <div class="relative h-full min-h-[360px]">
                        <img
                            :src="slide.image"
                            :alt="slide.title"
                            class="h-full w-full rounded-[28px] object-cover"
                        />
                        <div class="absolute bottom-6 left-6 max-w-[70%] rounded-2xl bg-white/90 p-4 text-sm shadow-soft">
                            <div class="font-semibold">{{ slide.title }}</div>
                            <div class="text-ink/60">{{ slide.subtitle }}</div>
                        </div>
                    </div>
                </SwiperSlide>
            </Swiper>
        </div>
    </section>

    <section class="mt-16 grid gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-ink/10 bg-white p-6 shadow-soft">
            <h3 class="text-lg font-semibold">Почему выбирают нас</h3>
            <p class="mt-2 text-sm text-ink/70">Каждый предмет проходит проверку и получает рейтинг состояния.</p>
        </div>
        <div class="rounded-3xl border border-ink/10 bg-white p-6 shadow-soft">
            <h3 class="text-lg font-semibold">Гибкие условия</h3>
            <p class="mt-2 text-sm text-ink/70">Гибкая аренда по дням и поддержку личного менеджера.</p>
        </div>
        <div class="rounded-3xl border border-ink/10 bg-white p-6 shadow-soft">
            <h3 class="text-lg font-semibold">Доверие</h3>
            <p class="mt-2 text-sm text-ink/70">Отзывы реальных арендаторов и страховой депозит.</p>
        </div>
    </section>

    <section class="mt-16 grid gap-8 rounded-[32px] bg-white p-10 shadow-soft lg:grid-cols-[1fr_1.1fr]">
        <div>
            <h2 class="text-3xl font-semibold">Как это работает</h2>
            <p class="mt-3 text-sm text-ink/70">
                Мы соединяем владельцев и арендаторов, чтобы вещи не простаивали, а проекты не стояли.
            </p>
            <ul class="mt-6 space-y-4 text-sm">
                <li class="flex items-start gap-3">
                    <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-ink text-xs font-semibold text-white">1</span>
                    Выберите предмет в каталоге и отправьте заявку с удобными датами.
                </li>
                <li class="flex items-start gap-3">
                    <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-ink text-xs font-semibold text-white">2</span>
                    Получите подтверждение и инструкцию по получению.
                </li>
                <li class="flex items-start gap-3">
                    <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-ink text-xs font-semibold text-white">3</span>
                    Верните вещь и поделитесь отзывом.
                </li>
            </ul>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl bg-linen p-5">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Поддержка</div>
                <div class="mt-2 text-lg font-semibold">24/7 в чате</div>
            </div>
            <div class="rounded-2xl bg-linen p-5">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Доставка</div>
                <div class="mt-2 text-lg font-semibold">По городу за 2 часа</div>
            </div>
            <div class="rounded-2xl bg-linen p-5">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Страхование</div>
                <div class="mt-2 text-lg font-semibold">До 300 000 ₽</div>
            </div>
            <div class="rounded-2xl bg-linen p-5">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Оплата</div>
                <div class="mt-2 text-lg font-semibold">Картой и переводом</div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination } from 'swiper/modules'

const slides = [
    {
        title: 'Техника для творчества',
        subtitle: 'Фотоаппараты, звук, свет и аксессуары.',
        image: '/hero-1.svg',
    },
    {
        title: 'Инструменты для проекта',
        subtitle: 'Дрели, шлифовальные, лазерные уровни.',
        image: '/hero-2.svg',
    },
    {
        title: 'Умный дом и гаджеты',
        subtitle: 'Устройства для экспериментов и тестов.',
        image: '/hero-3.svg',
    },
]
</script>
