<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Login</h4>
                

                <!-- Login Form Start -->
                <form method="post" @submit.prevent="handleLogin()">
                    <div class="mb-3">
                        <label for="login_email" class="form-label">Email:</label>
                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            id="login_email"
                            maxlength="255"
                            v-model="form.email"
                            required
                        >
                    </div>
                    <div class="mb-3">
                        <label for="login_password" class="form-label">Password:</label>
                        <input
                            type="password"
                            class="form-control"
                            name="password"
                            id="login_password"
                            maxlength="255"
                            v-model="form.password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <!-- Login Form End -->
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();
const router = useRouter();

// data
const form = reactive({
    email: '',
    password: '',
});

const errors = ref([]);

// methods
const handleLogin = async() => { // Handle User Login on submit
    try{
        errors.value = [];

        const response = await axios.post('/login', form);
       
        if(response) {
            if(response.data.success) {
                authStore.setToken(response.data.token);
                authStore.setUser(response.data.user);
                toastr.success(response.data.message);

                // Redirect to dashboard
                router.push({name: 'Dashboard'});
            } else {
                toastr.error(response.data.message);
            }
        }
    } catch (error) {
        console.error(error);

        if(error) {
            if(error.response?.status == 422) {
                errors.value = error.response.data.errors;
            }
        }
    }
};


</script>

<style scoped>

</style>