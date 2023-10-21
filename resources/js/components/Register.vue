<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Register</h4>
                
                <!-- Register Form Start -->
                <form method="post" @submit.prevent="handleRegister()">
                    <div class="mb-3">
                        <label for="register_name" class="form-label">Name:</label>
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="register_name"
                            maxlength="255"
                            v-model="form.name"
                            required
                        >
                        <ValidationError :errors="errors" :field="'name'"/>
                    </div>
                    <div class="mb-3">
                        <label for="register_email" class="form-label">Email:</label>
                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            id="register_email"
                            maxlength="255"
                            v-model="form.email"
                            required
                        >
                        <ValidationError :errors="errors" :field="'email'"/>
                    </div>
                    <div class="mb-3">
                        <label for="register_password" class="form-label">Password:</label>
                        <input
                            type="password"
                            class="form-control"
                            name="password"
                            id="register_password"
                            minlength="8"
                            maxlength="255"
                            v-model="form.password"
                            required
                        >
                        <ValidationError :errors="errors" :field="'password'"/>
                    </div>

                    <div class="mb-3">
                        <div class="form-check" :value="item.id" v-for="(item, index) in roles" :key="index">
                          <input class="form-check-input" type="radio" name="role_id" :id="'register_role_id'+item.id" :value="item.id" v-model="form.role_id">
                          <label class="form-check-label" :for="'register_role_id'+item.id">
                            {{ item.name }}
                          </label>
                        </div>
                        <ValidationError :errors="errors" :field="'role_id'"/>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <!-- Register Form End -->

            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import ValidationError from './layout/elements/ValidationError.vue';

const authStore = useAuthStore();
const router = useRouter();

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role_id: '',
});

const roles = ref([]); 
const errors = ref([]); 

onMounted(() => {
    getRoles();  
})

const handleRegister = async() => { // Handle User Registeration on submit
    errors.value = [];

    try{
        const response = await axios.post('/register', form);
       
        if(response) {
            if(response.data.success) {
                authStore.setToken(response.data.token);
                authStore.setUser(response.data.user);
                toastr.success(response.data.message);

                // redirect to dashboard
                router.push({name: 'Dashboard'});
            } else {
                toastr.error(response.data.message);
            }
        }
    } catch (error) {
        console.log(error);
        if(error) {
            if(error.response?.status == 422) {
                errors.value = error.response.data.errors;
            }
        }
    }
};

const getRoles = async() => { // Get Roles list from api
    try{
        const response = await axios.get('/get-roles');
       
        if(response) {
            if(response.data.success) {
                roles.value = response.data.data;
            }
        }
    } catch (error) {
        console.log(error);
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