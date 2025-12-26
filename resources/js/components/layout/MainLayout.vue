<template>
    <div class="relative min-h-screen overflow-hidden bg-sand text-ink">
        <div class="pointer-events-none absolute -left-40 -top-40 h-[420px] w-[420px] rounded-full bg-sunset blur-[120px]"></div>
        <div class="pointer-events-none absolute -right-32 top-1/3 h-[360px] w-[360px] rounded-full bg-lagoon blur-[120px]"></div>
        <SiteHeader />
        <main class="relative mx-auto w-full max-w-6xl px-6 pb-20 pt-10">
            <slot />
        </main>
        <SiteFooter />
    </div>
</template>

<script setup>
import SiteHeader from '@/components/layout/SiteHeader.vue'
import SiteFooter from '@/components/layout/SiteFooter.vue'
</script>
