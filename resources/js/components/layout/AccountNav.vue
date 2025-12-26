<template>
    <nav class="flex flex-wrap gap-3">
        <RouterLink
            v-for="item in items"
            :key="item.to"
            :to="item.to"
            class="rounded-full border px-4 py-2 text-sm font-semibold transition"
            :class="route.path === item.to ? 'border-ink bg-ink text-white' : 'border-ink/20 hover:border-ink/40'"
        >
            {{ item.label }}
        </RouterLink>
    </nav>
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()

const items = [
    { to: '/account', label: 'Профиль' },
    { to: '/account/applications', label: 'Заявки' },
    { to: '/account/reviews', label: 'Отзывы' },
]
</script>
