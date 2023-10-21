import { defineStore } from "pinia";
import router from "../router";

export const useAuthStore = defineStore("auth", {
    state: () => {
        return {
            token: localStorage.getItem('token') || null,
            user: JSON.parse(localStorage.getItem('user')) || null,
        };
    },
    getters: {
        isGuest() {
            return this.token == null;
        }
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
        },
        async logout() {
            this.removeToken();
            this.removeUser();

            try{
                const response = await axios.post('/logout');
               
                if(response) {
                    if(response.data.success) {
                        // Redirect to Home
                        router.push({name: 'Home'});
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }
    }
});