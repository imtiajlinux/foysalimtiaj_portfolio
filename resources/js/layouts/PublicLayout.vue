<script setup>
import Navbar from '../components/public/Navbar.vue';
import Footer from '../components/public/Footer.vue';
</script>

<template>
    <div class="public-layout">

        <Navbar />

        <main class="page-background">
            <router-view />
        </main>

        <Footer />

    </div>
</template>