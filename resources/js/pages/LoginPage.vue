<template>
    <section class="mx-auto max-w-xl rounded-[32px] bg-white p-10 shadow-soft">
        <h1 class="text-3xl font-semibold">Вход</h1>
        <p class="mt-2 text-sm text-ink/70">Введите данные, чтобы продолжить.</p>

        <form class="mt-6 space-y-4" @submit.prevent="submit">
            <BaseInput
                v-model="form.email"
                type="email"
                label="Почта"
                placeholder="name@mail.ru"
                autocomplete="email"
                :error="errors.email?.[0]"
            />
            <BaseInput
                v-model="form.password"
                type="password"
                label="Пароль"
                autocomplete="current-password"
                :error="errors.password?.[0]"
            />
            <div v-if="message" class="rounded-2xl bg-sand px-4 py-3 text-sm">{{ message }}</div>
            <BaseButton type="submit" :disabled="submitting">Войти</BaseButton>
        </form>

        <div class="mt-6 text-sm text-ink/70">
            Нет аккаунта?
            <RouterLink class="font-semibold text-ink" to="/register">Зарегистрироваться</RouterLink>
        </div>
    </section>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import BaseInput from '@/components/ui/BaseInput.vue'
import BaseButton from '@/components/ui/BaseButton.vue'

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({
    email: '',
    password: '',
})

const errors = ref({})
const message = ref('')
const submitting = ref(false)

const submit = async () => {
    submitting.value = true
    errors.value = {}
    message.value = ''

    try {
        await authStore.login(form)
        await router.push({ name: 'account' })
    } catch (error) {
        if (error?.response?.status === 422) {
            errors.value = error.response.data.errors || {}
        } else {
            message.value = error?.response?.data?.message || 'Не удалось выполнить вход.'
        }
    } finally {
        submitting.value = false
    }
}
</script>
