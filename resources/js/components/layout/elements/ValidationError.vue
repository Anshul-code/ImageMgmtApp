<template>
    <div>
        <span class="text-danger" v-if="errors[field]">{{ errors[field][0] }}</span>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'
    
defineProps({
    errors: [Object,Array],
    field: String,
});
</script>

<style scoped>

</style>