import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => {
        return {
            token: localStorage.getItem('token') || null,
            user: JSON.parse(localStorage.getItem('user')) || null,
        };
    },
    actions: {
        // Token Actions
        setToken(token) {
            localStorage.setItem('token', token);
            this.token = token;
        },
        setUser(user) {
            localStorage.setItem('user', JSON.stringify(user));
            this.user = user;
        },
        // Users Actions
        removeToken() {
            localStorage.removeItem('token');
            this.token = null;
        },
        removeUser() {
            localStorage.removeItem('user');
            this.user = null;
        }
    }
});