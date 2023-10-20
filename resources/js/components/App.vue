<template>
    <div>
        <Navbar />
        <div class="container mt-2">
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>
import Navbar from './layout/elements/Navbar.vue';


</script>

<style scoped>

</style>