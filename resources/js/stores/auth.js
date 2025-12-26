import { defineStore } from 'pinia'
import http from '@/api/http'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('auth_token') || null,
        user: null,
        initialized: false,
        initPromise: null,
    }),
    getters: {
        isAuthenticated: (state) => Boolean(state.token),
    },
    actions: {
        async initialize() {
            if (this.initialized) return
            if (this.initPromise) return this.initPromise

            this.initPromise = (async () => {
                if (this.token) {
                    try {
                        const { data } = await http.get('/me')
                        this.user = data?.data ?? data
                    } catch (error) {
                        this.clearAuth()
                    }
                }
                this.initialized = true
            })()

            return this.initPromise
        },
        setToken(token) {
            this.token = token
            if (token) {
                localStorage.setItem('auth_token', token)
            } else {
                localStorage.removeItem('auth_token')
            }
        },
        clearAuth() {
            this.setToken(null)
            this.user = null
        },
        async fetchMe() {
            const { data } = await http.get('/me')
            this.user = data?.data ?? data
            return this.user
        },
        async login(payload) {
            const { data } = await http.post('/login', payload)
            this.setToken(data.token)
            this.user = data?.user?.data ?? data.user
            return data
        },
        async register(payload) {
            const { data } = await http.post('/register', payload)
            this.setToken(data.token)
            this.user = data?.user?.data ?? data.user
            return data
        },
        async logout() {
            try {
                await http.post('/logout')
            } catch (error) {
                // ignore network errors on logout
            }
            this.clearAuth()
        },
    },
})
