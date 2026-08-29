<template>
    <header class="site-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">

                <router-link
                    to="/"
                    class="navbar-brand"
                >
                    <span class="brand-mark">F</span>

                    <span class="brand-name">
                        Portfolio
                    </span>
                </router-link>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNavigation"
                    aria-controls="mainNavigation"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div
                    id="mainNavigation"
                    class="collapse navbar-collapse"
                >
                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <router-link
                                to="/"
                                class="nav-link"
                            >
                                Home
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link
                                to="/projects"
                                class="nav-link"
                            >
                                Projects
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link
                                to="/gallery"
                                class="nav-link"
                            >
                                Gallery
                            </router-link>
                        </li>

                    </ul>

                    <router-link
                        to="/contact"
                        class="nav-contact"
                    >
                        Let's Talk
                        <span>↗</span>
                    </router-link>
                </div>

            </div>
        </nav>
    </header>
</template>

<style scoped>
.site-header {
    position: sticky;
    top: 0;
    z-index: 1000;

    background: rgba(10, 10, 15, 0.78);
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);

    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
}

.navbar {
    min-height: 76px;
}

.navbar-brand {
    display: inline-flex;
    align-items: center;
    gap: 10px;

    font-family: var(--font-heading);
    font-weight: 700;
    color: var(--text);
}

.brand-mark {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 36px;
    height: 36px;

    border-radius: 10px;

    background: var(--primary);
    color: white;

    font-size: 0.95rem;
}

.brand-name {
    font-size: 1rem;
    letter-spacing: -0.02em;
}

.navbar-nav {
    gap: 8px;
}

.nav-link {
    position: relative;

    padding: 8px 14px !important;

    color: var(--text-muted) !important;

    font-size: 0.88rem;
    font-weight: 500;

    transition:
        color var(--transition);
}

.nav-link:hover,
.nav-link.router-link-exact-active {
    color: var(--white) !important;
}

.nav-link.router-link-exact-active::after {
    content: '';

    position: absolute;
    left: 14px;
    right: 14px;
    bottom: 2px;

    height: 2px;

    background: var(--primary);
    border-radius: 10px;
}

.nav-contact {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 10px 17px;

    border: 1px solid var(--border);
    border-radius: 9px;

    color: var(--text);
    font-size: 0.85rem;
    font-weight: 600;

    transition:
        background var(--transition),
        border-color var(--transition),
        transform var(--transition);
}

.nav-contact:hover {
    color: var(--white);
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(167, 139, 250, 0.3);
    transform: translateY(-1px);
}

.nav-contact span {
    color: var(--primary-light);
}

.navbar-toggler {
    border-color: var(--border);
}

.navbar-toggler:focus {
    box-shadow: none;
}

@media (max-width: 991.98px) {
    .navbar-collapse {
        padding: 20px 0;
    }

    .navbar-nav {
        gap: 2px;
    }

    .nav-contact {
        margin-top: 15px;
    }
}
</style>