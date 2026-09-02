<template>
    <div class="admin-wrapper">

        <!-- Sidebar -->
        <AdminSidebar
            :sidebarOpen="sidebarOpen"
            @close-sidebar="sidebarOpen = false"
        />

        <!-- Main Content -->
        <div
            class="admin-main"
            :class="{ 'sidebar-collapsed': !sidebarOpen }"
        >

            <!-- Navbar -->
            <AdminNavbar
                @toggle-sidebar="toggleSidebar"
            />

            <!-- Page Content -->
            <main class="admin-content">
                <slot />
            </main>

        </div>

        <!-- Mobile Overlay -->
        <div
            v-if="sidebarOpen"
            class="sidebar-overlay d-lg-none"
            @click="sidebarOpen = false"
        ></div>

    </div>
</template>

<script setup>
import { ref } from 'vue';

import AdminSidebar from '../components/admin/AdminSidebar.vue';
import AdminNavbar from '../components/admin/AdminNavbar.vue';

const sidebarOpen = ref(true);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};
</script>

<style scoped>
.admin-wrapper {
    min-height: 100vh;
    background: #f5f7fb;
}

/*
|--------------------------------------------------------------------------
| Main Content
|--------------------------------------------------------------------------
*/

.admin-main {
    margin-left: 260px;
    min-height: 100vh;

    transition: margin-left 0.3s ease;
}

.admin-main.sidebar-collapsed {
    margin-left: 0;
}

.admin-content {
    padding: 30px;
}


/*
|--------------------------------------------------------------------------
| Mobile Overlay
|--------------------------------------------------------------------------
*/

.sidebar-overlay {
    position: fixed;
    inset: 0;

    background: rgba(0, 0, 0, 0.45);

    z-index: 1040;
}


/*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
*/

@media (max-width: 991.98px) {

    .admin-main {
        margin-left: 0 !important;
    }

    .admin-content {
        padding: 20px 15px;
    }

}
</style>