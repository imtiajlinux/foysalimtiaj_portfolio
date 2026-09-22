<template>
    <footer class="site-footer">
        <div class="footer-glow"></div>

        <div class="container">
            <div class="footer-intro">
                <div>
                    <span class="footer-label">HAVE AN IDEA?</span>
                    <h2>
                        Let's make the next
                        <span>thing worth building.</span>
                    </h2>
                </div>

                <router-link to="/contact" class="footer-contact">
                    <span>Start a conversation</span>
                    <i class="bi bi-arrow-up-right"></i>
                </router-link>
            </div>

            <div class="footer-main">
                <div class="footer-brand-area">
                    <router-link to="/" class="footer-brand">
                        <span class="footer-mark">FI</span>
                        <span>
                            <strong>Foysal Imtiaj</strong>
                            <small>Web Developer</small>
                        </span>
                    </router-link>

                    <p>
                        Building modern, scalable and thoughtful
                        digital experiences with code and creativity.
                    </p>
                </div>

                <div class="footer-navigation">
                    <span class="footer-heading">EXPLORE</span>
                    <router-link to="/">Home</router-link>
                    <a href="/#about">About</a>
                    <a href="/#experience">Experience</a>
                    <a href="/#projects">Work</a>
                    <router-link to="/gallery">Gallery</router-link>
                </div>

                <div class="footer-navigation">
                    <span class="footer-heading">CONNECT</span>
                    <router-link to="/contact">Contact</router-link>
                    <a href="mailto:hello@example.com">Email</a>
                    <a href="https://github.com" target="_blank" rel="noopener noreferrer">GitHub</a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-copy">
                    © 2026 Foysal Imtiaj
                </div>

                <div class="footer-stack">
                    <span>Laravel</span>
                    <span>Vue.js</span>
                    <span>React</span>
                </div>

                <a href="#top" class="back-top">
                    BACK TO TOP
                    <i class="bi bi-arrow-up-right"></i>
                </a>
            </div>
        </div>
    </footer>
</template>

<style scoped>
.site-footer {
    position: relative;
    overflow: hidden;
    padding: 105px 0 28px;
    background: #08080c;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
}

.footer-glow {
    position: absolute;
    width: 550px;
    height: 550px;
    right: -250px;
    bottom: -350px;
    border-radius: 50%;
    background: rgba(139, 108, 255, 0.09);
    filter: blur(110px);
    pointer-events: none;
}

.footer-intro {
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 50px;
    padding-bottom: 85px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
}

.footer-label {
    display: block;
    margin-bottom: 17px;
    color: #8b6cff;
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.2em;
}

.footer-intro h2 {
    max-width: 820px;
    margin: 0;
    color: #f4f4f6;
    font-size: clamp(2.7rem, 6vw, 5.8rem);
    line-height: 0.96;
    letter-spacing: -0.06em;
    font-weight: 600;
}

.footer-intro h2 span {
    display: block;
    color: #8b6cff;
}

.footer-contact {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 13px;
    padding: 13px 14px 13px 18px;
    border: 1px solid rgba(139, 108, 255, 0.25);
    border-radius: 9px;
    color: #fff;
    background: rgba(139, 108, 255, 0.08);
    text-decoration: none;
    font-size: 0.72rem;
    font-weight: 600;
    transition: 0.25s ease;
}

.footer-contact:hover {
    color: #fff;
    border-color: rgba(139, 108, 255, 0.5);
    background: rgba(139, 108, 255, 0.15);
    transform: translateY(-2px);
}

.footer-contact i {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background: #8b6cff;
    font-size: 0.7rem;
    transition: transform 0.25s ease;
}

.footer-contact:hover i {
    transform: translate(2px, -2px);
}

.footer-main {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 80px;
    padding: 62px 0;
}

.footer-brand {
    display: inline-flex;
    align-items: center;
    gap: 11px;
    color: #fff;
    text-decoration: none;
}

.footer-mark {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #8b6cff;
    color: #fff;
    font-size: 0.7rem;
    font-weight: 800;
}

.footer-brand span:last-child {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.footer-brand strong {
    color: #e8e8ec;
    font-size: 0.82rem;
    font-weight: 650;
}

.footer-brand small {
    color: #55555f;
    font-size: 0.52rem;
    font-weight: 600;
    letter-spacing: 0.15em;
    text-transform: uppercase;
}

.footer-brand-area p {
    max-width: 340px;
    margin: 19px 0 0;
    color: #62626d;
    font-size: 0.77rem;
    line-height: 1.85;
}

.footer-navigation {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
}

.footer-heading {
    margin-bottom: 7px;
    color: #45454f;
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.17em;
}

.footer-navigation a {
    color: #777781;
    text-decoration: none;
    font-size: 0.75rem;
    transition: color 0.2s ease, transform 0.2s ease;
}

.footer-navigation a:hover {
    color: #fff;
    transform: translateX(3px);
}

.footer-bottom {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    align-items: center;
    gap: 20px;
    padding-top: 22px;
    border-top: 1px solid rgba(255, 255, 255, 0.055);
}

.footer-copy {
    color: #44444d;
    font-size: 0.58rem;
}

.footer-stack {
    display: flex;
    justify-content: center;
    gap: 7px;
}

.footer-stack span {
    padding: 5px 8px;
    border: 1px solid rgba(255, 255, 255, 0.055);
    border-radius: 5px;
    color: #4e4e57;
    font-size: 0.53rem;
}

.back-top {
    display: inline-flex;
    justify-content: flex-end;
    align-items: center;
    gap: 7px;
    color: #55555f;
    text-decoration: none;
    font-size: 0.56rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    transition: color 0.2s ease;
}

.back-top:hover {
    color: #fff;
}

.back-top i {
    color: #8b6cff;
    font-size: 0.7rem;
}

@media (max-width: 767.98px) {
    .site-footer {
        padding-top: 75px;
    }

    .footer-intro {
        display: block;
        padding-bottom: 60px;
    }

    .footer-intro h2 {
        font-size: clamp(2.6rem, 13vw, 4rem);
    }

    .footer-contact {
        margin-top: 30px;
    }

    .footer-main {
        grid-template-columns: 1fr 1fr;
        gap: 45px 30px;
        padding: 50px 0;
    }

    .footer-brand-area {
        grid-column: 1 / -1;
    }

    .footer-bottom {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 15px;
    }

    .footer-stack {
        order: 2;
    }

    .back-top {
        justify-content: center;
        order: 3;
    }
}

@media (max-width: 450px) {
    .footer-main {
        grid-template-columns: 1fr;
    }

    .footer-brand-area {
        grid-column: auto;
    }
}
</style>