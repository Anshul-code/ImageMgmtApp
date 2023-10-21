<template>
    <div>
        <div class="row">
            <div class="col-lg-3 border p-2">
                <nav class="nav nav-pills flex-column">
                    <router-link active-class="active" class="nav-link" :to="{ name: 'CreateImage' }">Upload Image</router-link>
                    <router-link active-class="active" class="nav-link" :to="{ name: 'ImagesReport' }">Download Report</router-link>
                </nav>
            </div>
            
            <div class="col-lg-9">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { onMounted } from 'vue';
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();
const router = useRouter();


</script>

<style scoped>

</style>