<template>
    <PublicLayout>
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center min-vh-75">

                    <!-- Left Side -->
                    <div class="col-lg-7">

                        <p class="text-primary fw-semibold mb-2">
                            HELLO, I'M
                        </p>

                        <h1 class="display-3 fw-bold mb-3">
                            Foysal Imtiaj
                        </h1>

                        <h2 class="h3 text-secondary mb-4">
                            Web Developer
                        </h2>

                        <p class="lead text-muted mb-4">
                            I build modern, scalable and user-friendly
                            web applications using Laravel, Vue.js,
                            React and other modern technologies.
                        </p>

                        <div class="d-flex gap-3 flex-wrap">

                            <router-link
                                to="/projects"
                                class="btn btn-primary btn-lg"
                            >
                                View My Work
                            </router-link>

                            <router-link
                                to="/contact"
                                class="btn btn-outline-dark btn-lg"
                            >
                                Contact Me
                            </router-link>

                        </div>

                    </div>

                    <!-- Right Side -->
                    <div class="col-lg-5 text-center mt-5 mt-lg-0">

                        <div class="profile-image-wrapper">

                            <img
                                src="https://via.placeholder.com/400"
                                alt="Foysal Imtiaj"
                                class="img-fluid rounded-circle profile-image"
                            >

                        </div>

                    </div>

                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<script setup>
import PublicLayout from '../../layouts/PublicLayout.vue';
</script>

<style scoped>
.hero-section {
    min-height: calc(100vh - 56px);
    display: flex;
    align-items: center;
}

.min-vh-75 {
    min-height: 75vh;
}

.profile-image {
    width: 350px;
    height: 350px;
    object-fit: cover;
}

.profile-image-wrapper {
    display: inline-block;
}
</style>

