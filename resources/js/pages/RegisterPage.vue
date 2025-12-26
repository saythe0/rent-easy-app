<template>
    <section class="mx-auto max-w-xl rounded-[32px] bg-white p-10 shadow-soft">
        <h1 class="text-3xl font-semibold">Регистрация</h1>
        <p class="mt-2 text-sm text-ink/70">Создайте аккаунт, чтобы арендовать вещи.</p>

        <form class="mt-6 space-y-4" @submit.prevent="submit">
            <BaseInput
                v-model="form.name"
                label="ФИО"
                placeholder="Иван Иванов"
                autocomplete="name"
                :error="errors.name?.[0]"
            />
            <BaseInput
                v-model="form.email"
                type="email"
                label="Почта"
                placeholder="name@mail.ru"
                autocomplete="email"
                :error="errors.email?.[0]"
            />
            <BaseInput
                v-model="form.phone"
                label="Телефон"
                placeholder="+7 999 000-00-00"
                autocomplete="tel"
                :error="errors.phone?.[0]"
            />
            <BaseInput
                v-model="form.password"
                type="password"
                label="Пароль"
                autocomplete="new-password"
                :error="errors.password?.[0]"
            />
            <BaseInput
                v-model="form.password_confirmation"
                type="password"
                label="Подтверждение пароля"
                autocomplete="new-password"
                :error="errors.password_confirmation?.[0]"
            />
            <div v-if="message" class="rounded-2xl bg-sand px-4 py-3 text-sm">{{ message }}</div>
            <BaseButton type="submit" :disabled="submitting">Создать аккаунт</BaseButton>
        </form>

        <div class="mt-6 text-sm text-ink/70">
            Уже есть аккаунт?
            <RouterLink class="font-semibold text-ink" to="/login">Войти</RouterLink>
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
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
})

const errors = ref({})
const message = ref('')
const submitting = ref(false)

const submit = async () => {
    submitting.value = true
    errors.value = {}
    message.value = ''

    try {
        await authStore.register(form)
        await router.push({ name: 'account' })
    } catch (error) {
        if (error?.response?.status === 422) {
            errors.value = error.response.data.errors || {}
        } else {
            message.value = error?.response?.data?.message || 'Не удалось создать аккаунт.'
        }
    } finally {
        submitting.value = false
    }
}
</script>
