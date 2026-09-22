<template>
    <header class="site-header">
        <nav class="navbar">
            <div class="container navbar-container">
                <router-link to="/" class="navbar-brand">
                    <span class="brand-mark">FI</span>
                    <span class="brand-info">
                        <strong>Foysal Imtiaj</strong>
                        <small>Web Developer</small>
                    </span>
                </router-link>

                <div class="desktop-nav">
                    <router-link to="/" class="nav-link">
                        <span>01</span>
                        Home
                    </router-link>
                    <a href="/#about" class="nav-link">
                        <span>02</span>
                        About
                    </a>
                    <a href="/#experience" class="nav-link">
                        <span>03</span>
                        Experience
                    </a>
                    <a href="/#projects" class="nav-link">
                        <span>04</span>
                        Work
                    </a>
                    <a href="/#gallery" class="nav-link">
                        <span>05</span>
                        Gallery
                    </a>
                </div>

                <a href="/#contact" class="talk-button">
                    <span>Let's Talk</span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>

                <button class="mobile-toggle" type="button" @click="menuOpen = !menuOpen" :aria-expanded="menuOpen">
                    <span></span>
                    <span></span>
                </button>
            </div>

            <transition name="menu">
                <div v-if="menuOpen" class="mobile-menu">
                    <div class="container">
                        <div class="mobile-menu-header">
                            <span>NAVIGATION</span>
                            <button type="button" @click="menuOpen = false">
                                CLOSE
                            </button>
                        </div>

                        <div class="mobile-links">
                            <a href="/#home" @click="closeMenu">
                                <span>01</span>
                                Home
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                            <a href="/#about" @click="closeMenu">
                                <span>02</span>
                                About
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                            <a href="/#experience" @click="closeMenu">
                                <span>03</span>
                                Experience
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                            <a href="/#projects" @click="closeMenu">
                                <span>04</span>
                                Work
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                            <a href="/#gallery" @click="closeMenu">
                                <span>05</span>
                                Gallery
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                            <a href="/#contact" @click="closeMenu" class="mobile-contact">
                                <span>06</span>
                                Let's Talk
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </div>

                        <div class="mobile-menu-footer">
                            <span>FOYSAL IMTIAJ</span>
                            <span>WEB DEVELOPER</span>
                        </div>
                    </div>
                </div>
            </transition>
        </nav>
    </header>
</template>

<script setup>
import { ref } from 'vue';

const menuOpen = ref(false);

const closeMenu = () => {
    menuOpen.value = false;
};
</script>

<style scoped>
.site-header {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(8, 8, 12, 0.78);
    border-bottom: 1px solid rgba(255, 255, 255, 0.055);
    backdrop-filter: blur(22px);
    -webkit-backdrop-filter: blur(22px);
}

.navbar {
    position: relative;
    min-height: 82px;
}

.navbar-container {
    min-height: 82px;
    display: flex;
    align-items: center;
}

.navbar-brand {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: #fff;
    text-decoration: none;
}

.brand-mark {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(139, 108, 255, 0.4);
    border-radius: 11px;
    background: linear-gradient(135deg, #8b6cff, #6247d8);
    box-shadow: 0 10px 30px rgba(139, 108, 255, 0.2);
    color: #fff;
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: -0.05em;
}

.brand-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.brand-info strong {
    color: #f5f5f7;
    font-size: 0.83rem;
    font-weight: 650;
    letter-spacing: -0.025em;
}

.brand-info small {
    color: #62626d;
    font-size: 0.54rem;
    font-weight: 600;
    letter-spacing: 0.16em;
    text-transform: uppercase;
}

.desktop-nav {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 4px;
}

.nav-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 11px;
    color: #72727e;
    text-decoration: none;
    font-size: 0.72rem;
    font-weight: 500;
    transition: color 0.25s ease;
}

.nav-link span {
    color: #44444e;
    font-size: 0.51rem;
    font-weight: 600;
    transition: color 0.25s ease;
}

.nav-link::after {
    content: '';
    position: absolute;
    left: 11px;
    right: 11px;
    bottom: 1px;
    height: 1px;
    border-radius: 10px;
    background: #8b6cff;
    transform: scaleX(0);
    transition: transform 0.25s ease;
}

.nav-link:hover {
    color: #fff;
}

.nav-link:hover span {
    color: #8b6cff;
}

.nav-link:hover::after {
    transform: scaleX(1);
}

.talk-button {
    margin-left: auto;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 7px 8px 7px 15px;
    border: 1px solid rgba(255, 255, 255, 0.09);
    border-radius: 9px;
    color: #e8e8ed;
    background: rgba(255, 255, 255, 0.025);
    text-decoration: none;
    font-size: 0.7rem;
    font-weight: 600;
    transition: 0.25s ease;
}

.talk-button:hover {
    color: #fff;
    border-color: rgba(139, 108, 255, 0.35);
    background: rgba(139, 108, 255, 0.08);
    transform: translateY(-1px);
}

.talk-button i {
    width: 27px;
    height: 27px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background: #8b6cff;
    color: #fff;
    font-size: 0.7rem;
    transition: transform 0.25s ease;
}

.talk-button:hover i {
    transform: translate(2px, -2px);
}

.mobile-toggle {
    display: none;
    width: 42px;
    height: 38px;
    margin-left: auto;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 6px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 9px;
    background: rgba(255, 255, 255, 0.03);
}

.mobile-toggle span {
    width: 17px;
    height: 1px;
    background: #aaaab4;
}

.mobile-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    min-height: calc(100vh - 82px);
    padding: 30px 0 25px;
    background: rgba(8, 8, 12, 0.98);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.mobile-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
}

.mobile-menu-header span,
.mobile-menu-header button {
    color: #555560;
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.15em;
}

.mobile-menu-header button {
    padding: 0;
    border: 0;
    background: none;
    color: #8b6cff;
}

.mobile-links {
    display: flex;
    flex-direction: column;
}

.mobile-links a {
    display: grid;
    grid-template-columns: 35px 1fr auto;
    align-items: center;
    gap: 10px;
    padding: 18px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.055);
    color: #d7d7dd;
    text-decoration: none;
    font-size: clamp(1.4rem, 6vw, 2.2rem);
    font-weight: 500;
    letter-spacing: -0.04em;
}

.mobile-links a span {
    color: #555560;
    font-size: 0.58rem;
    letter-spacing: 0;
}

.mobile-links a i {
    color: #8b6cff;
    font-size: 0.9rem;
}

.mobile-links a:hover {
    color: #fff;
}

.mobile-links .mobile-contact {
    color: #8b6cff;
}

.mobile-menu-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
    color: #45454f;
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.15em;
}

.menu-enter-active,
.menu-leave-active {
    transition: opacity 0.25s ease, transform 0.25s ease;
}

.menu-enter-from,
.menu-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

@media (max-width: 1100px) {
    .desktop-nav {
        gap: 0;
    }

    .nav-link {
        padding-left: 8px;
        padding-right: 8px;
    }

    .nav-link::after {
        left: 8px;
        right: 8px;
    }
}

@media (max-width: 991.98px) {
    .navbar,
    .navbar-container {
        min-height: 72px;
    }

    .desktop-nav,
    .talk-button {
        display: none;
    }

    .mobile-toggle {
        display: flex;
    }

    .mobile-menu {
        min-height: calc(100vh - 72px);
    }
}

@media (max-width: 400px) {
    .brand-info {
        display: none;
    }
}
</style>