<template>
    <footer class="border-t border-ink/10 bg-white/80">
        <div class="mx-auto grid w-full max-w-6xl gap-10 px-6 py-12 md:grid-cols-[1.4fr_1fr_1fr]">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="/logo.svg" alt="RentEase" class="h-9 object-left object-cover aspect-square w-auto" />
                    <div class="text-lg font-semibold">RentEase</div>
                </div>
                <p class="text-sm text-ink/70">
                    Платформа для аренды вещей с человеческим лицом: прозрачные условия,
                    удобные фильтры и живой контент от сообщества.
                </p>
            </div>
            <div class="space-y-2 text-sm">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Навигация</div>
                <RouterLink class="block hover:text-ink/60" to="/catalog">Каталог</RouterLink>
                <RouterLink class="block hover:text-ink/60" to="/about">О нас</RouterLink>
                <RouterLink class="block hover:text-ink/60" to="/blog">Блог</RouterLink>
            </div>
            <div class="space-y-2 text-sm">
                <div class="text-xs uppercase tracking-[0.2em] text-ink/50">Контакты</div>
                <div>Казань, ул. Брендовая, 12</div>
                <div>+7 (800) 555-80-11</div>
                <div class="flex gap-3">
                    <a class="hover:text-ink/60" href="https://t.me" target="_blank" rel="noreferrer">Telegram</a>
                    <a class="hover:text-ink/60" href="https://vk.com" target="_blank" rel="noreferrer">VK</a>
                    <a class="hover:text-ink/60" href="https://instagram.com" target="_blank" rel="noreferrer">Instagram</a>
                </div>
            </div>
        </div>
        <div class="border-t border-ink/10 py-4 text-center text-xs text-ink/50">
            RentEase © 2025. Арендуйте осмысленно.
        </div>
    </footer>
</template>

<script setup>
</script>
