<template>
    <footer class="site-footer">

        <div class="container">

            <div class="footer-main">

                <div>
                    <router-link
                        to="/"
                        class="footer-brand"
                    >
                        Portfolio.
                    </router-link>

                    <p class="footer-description">
                        Building thoughtful digital experiences
                        with modern web technologies.
                    </p>
                </div>

                <div class="footer-links">

                    <router-link to="/">
                        Home
                    </router-link>

                    <router-link to="/projects">
                        Projects
                    </router-link>

                    <router-link to="/gallery">
                        Gallery
                    </router-link>

                    <router-link to="/contact">
                        Contact
                    </router-link>

                </div>

            </div>

            <div class="footer-bottom">

                <span>
                    © 2026 Portfolio. All rights reserved.
                </span>

                <span>
                    Designed & built with Laravel + Vue
                </span>

            </div>

        </div>

    </footer>
</template>

<style scoped>
.site-footer {
    margin-top: 80px;
    padding: 60px 0 25px;

    background: #08080c;
    border-top: 1px solid var(--border);
}

.footer-main {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 40px;

    padding-bottom: 45px;
}

.footer-brand {
    display: inline-block;

    margin-bottom: 12px;

    font-family: var(--font-heading);
    font-size: 1.5rem;
    font-weight: 700;
}

.footer-description {
    max-width: 330px;

    margin: 0;

    color: var(--text-muted);
    font-size: 0.9rem;
}

.footer-links {
    display: flex;
    gap: 28px;
}

.footer-links a {
    color: var(--text-muted);
    font-size: 0.85rem;

    transition: color var(--transition);
}

.footer-links a:hover {
    color: var(--white);
}

.footer-bottom {
    display: flex;
    justify-content: space-between;

    padding-top: 22px;

    border-top: 1px solid var(--border);

    color: #686873;
    font-size: 0.75rem;
}

@media (max-width: 767.98px) {
    .footer-main {
        flex-direction: column;
    }

    .footer-links {
        flex-wrap: wrap;
        gap: 15px 25px;
    }

    .footer-bottom {
        flex-direction: column;
        gap: 8px;
    }
}
</style>