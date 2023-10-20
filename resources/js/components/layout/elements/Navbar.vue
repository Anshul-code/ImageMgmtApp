<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
              <div class="container">
                <router-link to="/" class="navbar-brand">Images Management System</router-link>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavMainId" aria-controls="collapsibleNavMainId"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavMainId">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <router-link active-class="active" to="/" class="nav-link">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/register" class="nav-link" v-if="isGuest">Register</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/login" class="nav-link" v-if="isGuest">Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" :to="{name: 'Dashboard'}" class="nav-link" v-if="!isGuest">Dashboard</router-link>
                        </li>
                        <li class="nav-item dropdown" v-if="!isGuest">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="dropdownMainNav"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                            Anshul
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMainNav">
                                <a class="dropdown-item" href="#" @click="">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
          </div>
        </nav>
    </div>
</template>

<script setup>
import { ref } from 'vue'
const isGuest = ref(true);
</script>

<style  scoped>

</style>