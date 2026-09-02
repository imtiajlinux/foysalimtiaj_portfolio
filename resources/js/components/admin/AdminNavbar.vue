<template>

    <header class="admin-navbar">

        <div class="navbar-left">

            <!-- Sidebar Toggle -->
            <button class="sidebar-toggle" @click="$emit('toggle-sidebar')">
                <i class="bi bi-list"></i>
            </button>

            <div class="page-info d-none d-md-block">
                <h6>Dashboard</h6>
                <span>Welcome back, Foysal</span>
            </div>

        </div>


        <div class="navbar-right">

            <!-- Search -->
            <button class="nav-icon">
                <i class="bi bi-search"></i>
            </button>


            <!-- Notification -->
            <button class="nav-icon notification-btn">

                <i class="bi bi-bell"></i>

                <span class="notification-dot"></span>

            </button>


            <div class="navbar-divider"></div>


            <!-- Profile -->
            <div class="dropdown">

                <button class="navbar-profile border-0 bg-transparent" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <div class="profile-avatar">
                        FI
                    </div>

                    <div class="profile-info d-none d-sm-flex">

                        <strong>
                            Foysal Imtiaj
                        </strong>

                        <span>
                            Administrator
                        </span>

                    </div>

                    <i class="bi bi-chevron-down profile-arrow"></i>

                </button>


                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                    <li>

                        <router-link to="/admin/profile" class="dropdown-item">
                            <i class="bi bi-person me-2"></i>

                            Profile
                        </router-link>

                    </li>


                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    <li>

                        <button type="button" class="dropdown-item text-danger" @click="logout">

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </button>

                    </li>

                </ul>

            </div>

        </div>

    </header>

</template>


<script setup>
import { useRouter } from 'vue-router';
import { useAuth } from '../../stores/auth';

defineEmits([
    'toggle-sidebar'
]);

const router = useRouter();
const auth = useAuth();
const logout = async () => {
    const success = await auth.logout();
    if (success) {
        // Full browser navigation.
        // This causes Laravel to generate/load the fresh CSRF token.
        window.location.href = '/admin/login';
    }

};

</script>

<!-- <script setup>

defineEmits([
    'toggle-sidebar'
]);

</script> -->

<style scoped>
.admin-navbar {
    height: 75px;

    background: #ffffff;

    border-bottom: 1px solid #e9edf3;

    padding: 0 30px;

    display: flex;
    align-items: center;
    justify-content: space-between;
}


/* Left */

.navbar-left {
    display: flex;
    align-items: center;

    gap: 20px;
}

.sidebar-toggle {
    width: 40px;
    height: 40px;

    border: 1px solid #e6e9ef;

    background: #ffffff;

    border-radius: 8px;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #606a7a;

    font-size: 18px;

    transition: 0.2s;
}

.sidebar-toggle:hover {
    background: #f5f7fa;
}

.page-info h6 {
    margin: 0;

    font-size: 15px;

    color: #202733;
}

.page-info span {
    font-size: 11px;

    color: #9299a6;
}


/* Right */

.navbar-right {
    display: flex;
    align-items: center;

    gap: 8px;
}

.nav-icon {
    width: 40px;
    height: 40px;

    border: 0;

    background: transparent;

    border-radius: 8px;

    color: #687385;

    font-size: 17px;

    display: flex;
    align-items: center;
    justify-content: center;

    position: relative;
}

.nav-icon:hover {
    background: #f5f7fa;
}

.notification-dot {
    position: absolute;

    top: 8px;
    right: 8px;

    width: 7px;
    height: 7px;

    background: #dc3545;

    border-radius: 50%;

    border: 2px solid #ffffff;
}

.navbar-divider {
    width: 1px;
    height: 32px;

    background: #e9edf3;

    margin: 0 10px;
}


/* Profile */

.navbar-profile {
    display: flex;
    align-items: center;

    gap: 9px;

    padding-left: 5px;

    cursor: pointer;
}

.profile-avatar {
    width: 38px;
    height: 38px;

    border-radius: 50%;

    background: #212529;

    color: #ffffff;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 11px;
    font-weight: 700;
}

.profile-info {
    display: flex;
    flex-direction: column;
}

.profile-info strong {
    font-size: 12px;

    color: #343a40;
}

.profile-info span {
    font-size: 10px;

    color: #9299a6;
}

.profile-arrow {
    color: #8d95a3;

    font-size: 11px;

    margin-left: 4px;
}


@media (max-width: 575.98px) {

    .admin-navbar {
        padding: 0 15px;
    }

    .navbar-divider {
        display: none;
    }

}
</style>