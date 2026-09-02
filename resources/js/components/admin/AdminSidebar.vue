<template>
    <aside
        class="admin-sidebar"
        :class="{
            'sidebar-open': sidebarOpen,
            'sidebar-closed': !sidebarOpen
        }"
    >

        <!-- Header -->
        <div class="sidebar-header">

            <div class="brand">

                <div class="brand-logo">
                    FI
                </div>

                <div class="brand-text">
                    <strong>Foysal Imtiaj</strong>
                    <small>Admin Panel</small>
                </div>

            </div>

            <!-- Mobile Close -->
            <button
                type="button"
                class="close-sidebar d-lg-none"
                @click="closeSidebar"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        <!-- Navigation -->
        <div class="sidebar-body">

            <div class="menu-title">
                MAIN
            </div>

            <nav class="sidebar-nav">

                <!-- Dashboard -->
                <router-link
                    to="/admin/dashboard"
                    class="sidebar-link"
                    active-class="active"
                >
                    <span class="icon">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </span>

                    <span class="link-text">
                        Dashboard
                    </span>
                </router-link>


                <div class="menu-title mt-4">
                    PORTFOLIO
                </div>


                <!-- Projects -->
                <router-link
                    to="/admin/projects"
                    class="sidebar-link"
                    active-class="active"
                >
                    <span class="icon">
                        <i class="bi bi-folder-fill"></i>
                    </span>

                    <span class="link-text">
                        Projects
                    </span>
                </router-link>


                <!-- Skills -->
                <router-link
                    to="/admin/skills"
                    class="sidebar-link"
                    active-class="active"
                >
                    <span class="icon">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </span>

                    <span class="link-text">
                        Skills
                    </span>
                </router-link>


                <!-- Experience -->
                <router-link
                    to="/admin/experience"
                    class="sidebar-link"
                    active-class="active"
                >
                    <span class="icon">
                        <i class="bi bi-briefcase-fill"></i>
                    </span>

                    <span class="link-text">
                        Experience
                    </span>
                </router-link>


                <!-- Education -->
                <router-link
                    to="/admin/education"
                    class="sidebar-link"
                    active-class="active"
                >
                    <span class="icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </span>

                    <span class="link-text">
                        Education
                    </span>
                </router-link>


                <div class="menu-title mt-4">
                    COMMUNICATION
                </div>


                <!-- Messages -->
                <router-link
                    to="/admin/messages"
                    class="sidebar-link"
                    active-class="active"
                >
                    <span class="icon">
                        <i class="bi bi-envelope-fill"></i>
                    </span>

                    <span class="link-text">
                        Messages
                    </span>

                    <span class="badge bg-danger ms-auto">
                        3
                    </span>
                </router-link>


                <div class="menu-title mt-4">
                    SYSTEM
                </div>


                <!-- Profile -->
                <router-link
                    to="/admin/profile"
                    class="sidebar-link"
                    active-class="active"
                >
                    <span class="icon">
                        <i class="bi bi-person-fill"></i>
                    </span>

                    <span class="link-text">
                        Profile
                    </span>
                </router-link>


                <!-- Settings -->
                <router-link
                    to="/admin/settings"
                    class="sidebar-link"
                    active-class="active"
                >
                    <span class="icon">
                        <i class="bi bi-gear-fill"></i>
                    </span>

                    <span class="link-text">
                        Settings
                    </span>
                </router-link>

            </nav>

        </div>


        <!-- Footer -->
        <div class="sidebar-footer">

            <div class="admin-user">

                <div class="user-avatar">
                    FI
                </div>

                <div class="user-info">
                    <strong>Foysal Imtiaj</strong>
                    <small>Administrator</small>
                </div>

                <button
                    type="button"
                    class="user-menu"
                >
                    <i class="bi bi-three-dots-vertical"></i>
                </button>

            </div>

        </div>

    </aside>
</template>


<script setup>

const props = defineProps({
    sidebarOpen: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits([
    'close-sidebar'
]);

const closeSidebar = () => {
    emit('close-sidebar');
};

</script>


<style scoped>

/*
|--------------------------------------------------------------------------
| Sidebar
|--------------------------------------------------------------------------
*/

.admin-sidebar {
    width: 260px;
    height: 100vh;

    position: fixed;
    top: 0;
    left: 0;

    background: #ffffff;

    border-right: 1px solid #e9edf3;

    display: flex;
    flex-direction: column;

    z-index: 1050;

    transform: translateX(0);

    transition:
        transform 0.3s ease,
        width 0.3s ease;
}


/*
|--------------------------------------------------------------------------
| Desktop Sidebar Closed
|--------------------------------------------------------------------------
*/

@media (min-width: 992px) {

    .admin-sidebar.sidebar-closed {
        transform: translateX(-100%);
    }

}


/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

.sidebar-header {
    height: 75px;

    padding: 0 20px;

    display: flex;
    align-items: center;

    border-bottom: 1px solid #edf0f5;

    flex-shrink: 0;
}

.brand {
    display: flex;
    align-items: center;

    gap: 12px;
}

.brand-logo {
    width: 40px;
    height: 40px;

    border-radius: 10px;

    background: #212529;
    color: #ffffff;

    display: flex;
    align-items: center;
    justify-content: center;

    font-weight: 700;
    font-size: 15px;
}

.brand-text {
    display: flex;
    flex-direction: column;
}

.brand-text strong {
    font-size: 14px;
    color: #1f2937;
}

.brand-text small {
    color: #8b95a7;
    font-size: 11px;

    margin-top: 2px;
}


/*
|--------------------------------------------------------------------------
| Body
|--------------------------------------------------------------------------
*/

.sidebar-body {
    flex: 1;

    padding: 22px 14px;

    overflow-y: auto;
}

.menu-title {
    font-size: 10px;

    font-weight: 700;

    letter-spacing: 1px;

    color: #a0a8b8;

    padding: 0 12px 8px;
}


/*
|--------------------------------------------------------------------------
| Navigation
|--------------------------------------------------------------------------
*/

.sidebar-nav {
    display: flex;
    flex-direction: column;

    gap: 4px;
}

.sidebar-link {
    min-height: 44px;

    display: flex;
    align-items: center;

    gap: 12px;

    padding: 0 12px;

    border-radius: 8px;

    color: #697386;

    text-decoration: none;

    font-size: 14px;

    font-weight: 500;

    transition:
        background 0.2s ease,
        color 0.2s ease;
}

.sidebar-link:hover {
    background: #f5f7fa;
    color: #212529;
}

.sidebar-link.active {
    background: #212529;
    color: #ffffff;
}

.sidebar-link .icon {
    width: 22px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 15px;
}


/*
|--------------------------------------------------------------------------
| Footer
|--------------------------------------------------------------------------
*/

.sidebar-footer {
    padding: 15px;

    border-top: 1px solid #edf0f5;

    flex-shrink: 0;
}

.admin-user {
    display: flex;
    align-items: center;

    gap: 10px;
}

.user-avatar {
    width: 38px;
    height: 38px;

    flex-shrink: 0;

    border-radius: 50%;

    background: #e9ecef;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 12px;
    font-weight: 700;
}

.user-info {
    display: flex;
    flex-direction: column;

    min-width: 0;
}

.user-info strong {
    font-size: 12px;

    color: #343a40;

    white-space: nowrap;
}

.user-info small {
    font-size: 10px;

    color: #9299a6;
}

.user-menu {
    border: 0;

    background: transparent;

    color: #8991a0;

    margin-left: auto;
}


/*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
*/

.close-sidebar {
    border: 0;

    background: transparent;

    margin-left: auto;

    color: #6c757d;

    width: 36px;
    height: 36px;

    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 991.98px) {

    .admin-sidebar {
        transform: translateX(-100%);
    }

    .admin-sidebar.sidebar-open {
        transform: translateX(0);
    }

    .admin-sidebar.sidebar-closed {
        transform: translateX(-100%);
    }

}

</style>