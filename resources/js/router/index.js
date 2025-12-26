import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

import HomePage from '@/pages/HomePage.vue'
import AboutPage from '@/pages/AboutPage.vue'
import CatalogPage from '@/pages/CatalogPage.vue'
import ProductPage from '@/pages/ProductPage.vue'
import BlogPage from '@/pages/BlogPage.vue'
import PostPage from '@/pages/PostPage.vue'
import LoginPage from '@/pages/LoginPage.vue'
import RegisterPage from '@/pages/RegisterPage.vue'
import AccountPage from '@/pages/AccountPage.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: HomePage,
            name: 'home',
        },
        {
            path: '/about',
            component: AboutPage,
            name: 'about',
        },
        {
            path: '/catalog',
            component: CatalogPage,
            name: 'catalog',
        },
        {
            path: '/products/:slug',
            component: ProductPage,
            name: 'product.show',
        },
        {
            path: '/blog',
            component: BlogPage,
            name: 'blog',
        },
        {
            path: '/blog/:slug',
            component: PostPage,
            name: 'blog.show',
        },
        {
            path: '/login',
            component: LoginPage,
            name: 'login',
            meta: { guestOnly: true },
        },
        {
            path: '/register',
            component: RegisterPage,
            name: 'register',
            meta: { guestOnly: true },
        },
        {
            path: '/account',
            component: AccountPage,
            name: 'account',
            meta: { requiresAuth: true },
        },
    ],
    scrollBehavior() {
        return {top: 0}
    }
})

router.beforeEach(async (to) => {
    const authStore = useAuthStore()
    await authStore.initialize()

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        return { name: 'login' }
    }

    if (to.meta.guestOnly && authStore.isAuthenticated) {
        return { name: 'account' }
    }
})

export default router
