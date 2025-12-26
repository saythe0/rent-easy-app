import {createRouter, createWebHistory} from 'vue-router'

import HomePage from '@/pages/HomePage.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: HomePage,
            name: 'home',
        },
    ],
    scrollBehavior() {
        return {top: 0}
    }
})

export default router
