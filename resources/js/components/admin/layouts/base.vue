<script setup>
import Header from './header.vue';
import Sidebar from './sidebar.vue';
import { useRouter } from "vue-router";
const router = useRouter();
const logout = () => {
    localStorage.removeItem('token');
    router.push('/');
}
</script>

<template>
    <div class="base">
        <Header />
        <Sidebar />
    </div>
</template>
<style>
@import './base.css';
</style>
