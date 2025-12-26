<template>
    <header class="relative z-10 border-b border-ink/10 bg-white/70 backdrop-blur">
        <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
            <RouterLink to="/" class="flex items-center gap-3">
                <img src="/logo.svg" alt="RentEase" class="h-10 object-left object-cover aspect-square w-auto" />
                <div class="leading-tight">
                    <div class="text-lg font-semibold tracking-wide">RentEase</div>
                    <div class="text-xs uppercase tracking-[0.2em] text-ink/60">Аренда с характером</div>
                </div>
            </RouterLink>

            <nav class="hidden items-center gap-6 text-sm font-medium md:flex">
                <RouterLink class="transition hover:text-ink/60" to="/catalog">Каталог</RouterLink>
                <RouterLink class="transition hover:text-ink/60" to="/about">О нас</RouterLink>
                <RouterLink class="transition hover:text-ink/60" to="/blog">Блог</RouterLink>
            </nav>

            <div class="flex items-center gap-3">
                <RouterLink
                    v-if="!isAuthenticated"
                    to="/login"
                    class="rounded-full border border-ink/20 px-4 py-2 text-sm font-semibold transition hover:-translate-y-0.5 hover:border-ink/40"
                >
                    Войти
                </RouterLink>
                <div v-else class="flex items-center gap-3">
                    <RouterLink
                        to="/account"
                        class="rounded-full border border-ink/20 px-4 py-2 text-sm font-semibold transition hover:-translate-y-0.5 hover:border-ink/40"
                    >
                        Кабинет
                    </RouterLink>
                    <button
                        type="button"
                        class="rounded-full bg-ink px-4 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5"
                        @click="handleLogout"
                    >
                        Выйти
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
const isAuthenticated = computed(() => authStore.isAuthenticated)

const handleLogout = async () => {
    await authStore.logout()
}
</script>
