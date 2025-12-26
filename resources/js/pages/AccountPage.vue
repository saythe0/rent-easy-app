<template>
    <section class="rounded-[32px] bg-white p-10 shadow-soft">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold">Личный кабинет</h1>
                <p class="mt-2 text-sm text-ink/70">Ваши данные профиля и статус.</p>
            </div>
            <button
                type="button"
                class="rounded-full border border-ink/20 px-5 py-2 text-sm font-semibold"
                @click="logout"
            >
                Выйти
            </button>
        </div>

        <div class="mt-6">
            <AccountNav />
        </div>

        <div v-if="loading" class="mt-6 text-sm text-ink/60">Загружаем профиль...</div>
        <div v-else-if="user" class="mt-6 grid gap-4 md:grid-cols-2">
            <div class="rounded-2xl bg-linen p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">ID</div>
                <div class="mt-2 text-sm font-semibold">{{ user.id }}</div>
            </div>
            <div class="rounded-2xl bg-linen p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Почта</div>
                <div class="mt-2 text-sm font-semibold">{{ user.email }}</div>
            </div>
            <div class="rounded-2xl bg-linen p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">ФИО</div>
                <div class="mt-2 text-sm font-semibold">{{ user.name }}</div>
            </div>
            <div class="rounded-2xl bg-linen p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Телефон</div>
                <div class="mt-2 text-sm font-semibold">{{ user.phone }}</div>
            </div>
            <div class="rounded-2xl bg-linen p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Роль</div>
                <div class="mt-2 text-sm font-semibold">{{ user.role }}</div>
            </div>
            <div class="rounded-2xl bg-linen p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Дата регистрации</div>
                <div class="mt-2 text-sm font-semibold">{{ user.created_at }}</div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import AccountNav from '@/components/layout/AccountNav.vue'

const authStore = useAuthStore()
const router = useRouter()

const loading = ref(false)
const user = computed(() => authStore.user)

const loadProfile = async () => {
    if (authStore.user) return
    loading.value = true
    try {
        await authStore.fetchMe()
    } finally {
        loading.value = false
    }
}

const logout = async () => {
    await authStore.logout()
    await router.push({ name: 'login' })
}

onMounted(loadProfile)
</script>
