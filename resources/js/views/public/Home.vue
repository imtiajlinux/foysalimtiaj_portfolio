<template>
    <PublicLayout>

        <!-- Hero -->
        <section class="hero-section" id="home">
            <div class="hero-grid"></div>

            <div class="container position-relative">

                <div class="row align-items-center">

                    <div class="col-lg-7">

                        <div class="hero-badge">
                            <span class="status-dot"></span>
                            Available for opportunities
                        </div>

                        <p class="hero-intro">
                            HELLO, I'M
                        </p>

                        <h1 class="hero-title">
                            {{ profile.name || 'Foysal Imtiaj' }}
                        </h1>

                        <div class="hero-role">
                            {{ profile.title || 'Web Developer' }}
                        </div>

                        <p class="hero-description">
                            {{ profile.short_bio || 'I build modern, scalable and user-friendly web applications using Laravel, Vue.js, React and other modern technologies.' }}
                        </p>

                        <div class="hero-actions">

                            <a href="#projects" class="btn-primary-custom">
                                View My Work
                                <i class="bi bi-arrow-up-right"></i>
                            </a>

                            <a href="#contact" class="btn-outline-custom">
                                Let's Talk
                            </a>

                        </div>

                        <div class="hero-tech">

                            <span>Laravel</span>
                            <span>Vue.js</span>
                            <span>React</span>
                            <span>PHP</span>

                        </div>

                    </div>


                    <!-- Hero Visual -->
                    <div class="col-lg-5">

                        <div class="hero-visual">

                            <div class="visual-glow"></div>

                            <div class="visual-card">

                                <div class="visual-top">
                                    <span>PORTFOLIO</span>

                                    <span class="visual-number">
                                        01
                                    </span>
                                </div>

                                <div class="profile-frame">

                                    <img
                                        v-if="profile.profile_photo"
                                        :src="profile.profile_photo"
                                        :alt="profile.name"
                                    >

                                    <div
                                        v-else
                                        class="profile-placeholder"
                                    >
                                        FI
                                    </div>

                                </div>

                                <div class="visual-bottom">

                                    <div>
                                        <small>BASED IN</small>
                                        <strong>Bangladesh</strong>
                                    </div>

                                    <div>
                                        <small>FOCUS</small>
                                        <strong>Web Development</strong>
                                    </div>

                                </div>

                            </div>

                            <div class="floating-card floating-card-one">
                                <i class="bi bi-code-slash"></i>
                                <span>Clean Code</span>
                            </div>

                            <div class="floating-card floating-card-two">
                                <i class="bi bi-lightning-charge"></i>
                                <span>Modern UI</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="scroll-indicator">
                <span>SCROLL TO EXPLORE</span>
                <i class="bi bi-arrow-down"></i>
            </div>

        </section>


        <!-- Stats -->
        <section class="stats-section">

            <div class="container">

                <div class="stats-grid">

                    <div class="stat-item">
                        <strong>{{ projects.length }}+</strong>
                        <span>Projects</span>
                    </div>

                    <div class="stat-item">
                        <strong>{{ skills.length }}+</strong>
                        <span>Technologies</span>
                    </div>

                    <div class="stat-item">
                        <strong>{{ experiences.length }}+</strong>
                        <span>Experiences</span>
                    </div>

                    <div class="stat-item">
                        <strong>100%</strong>
                        <span>Passion</span>
                    </div>

                </div>

            </div>

        </section>


        <!-- About -->
        <section class="section about-section" id="about">

            <div class="container">

                <div class="section-heading">

                    <span class="section-label">
                        ABOUT ME
                    </span>

                    <h2>
                        Turning ideas into
                        <span>digital experiences.</span>
                    </h2>

                </div>

                <div class="row g-5 align-items-center">

                    <div class="col-lg-5">

                        <div class="about-number">
                            01
                        </div>

                        <p class="about-highlight">
                            I don't just build websites.
                            I build experiences that people
                            remember.
                        </p>

                    </div>

                    <div class="col-lg-7">

                        <p class="about-text">
                            {{ profile.about || profile.short_bio || 'I am a passionate web developer focused on creating modern, scalable and user-friendly digital experiences.' }}
                        </p>

                        <div class="about-details">

                            <div>
                                <span>NAME</span>
                                <strong>{{ profile.name || 'Foysal Imtiaj' }}</strong>
                            </div>

                            <div>
                                <span>ROLE</span>
                                <strong>{{ profile.title || 'Web Developer' }}</strong>
                            </div>

                            <div v-if="profile.email">
                                <span>EMAIL</span>
                                <strong>{{ profile.email }}</strong>
                            </div>

                            <div v-if="profile.website">
                                <span>WEBSITE</span>
                                <strong>{{ profile.website }}</strong>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- Skills -->
        <section class="section skills-section" id="skills">

            <div class="container">

                <div class="section-heading">

                    <span class="section-label">
                        EXPERTISE
                    </span>

                    <h2>
                        Tools I use to
                        <span>build.</span>
                    </h2>

                </div>

                <div class="skills-grid">

                    <div
                        v-for="skill in skills"
                        :key="skill.id"
                        class="skill-card"
                    >

                        <div class="skill-icon">

                            <i
                                v-if="skill.icon"
                                :class="skill.icon"
                            ></i>

                            <span v-else>
                                {{ skill.name.charAt(0) }}
                            </span>

                        </div>

                        <div class="skill-info">

                            <div class="skill-header">
                                <strong>{{ skill.name }}</strong>
                                <span>{{ skill.percentage }}%</span>
                            </div>

                            <div class="skill-bar">
                                <span :style="{ width: `${skill.percentage}%` }"></span>
                            </div>

                            <small>
                                {{ skill.category || 'Technology' }}
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- Experience -->
        <section class="section experience-section" id="experience">

            <div class="container">

                <div class="section-heading">

                    <span class="section-label">
                        EXPERIENCE
                    </span>

                    <h2>
                        Where I've
                        <span>worked.</span>
                    </h2>

                </div>

                <div class="experience-list">

                    <div
                        v-for="experience in experiences"
                        :key="experience.id"
                        class="experience-item"
                    >

                        <div class="experience-year">

                            <span>
                                {{ formatDate(experience.start_date) }}
                            </span>

                            <span>
                                —
                            </span>

                            <span v-if="experience.currently_working">
                                Present
                            </span>

                            <span v-else>
                                {{ formatDate(experience.end_date) }}
                            </span>

                        </div>

                        <div class="experience-content">

                            <div class="experience-company">
                                {{ experience.company }}
                            </div>

                            <h3>
                                {{ experience.position }}
                            </h3>

                            <div class="experience-meta">

                                <span>
                                    {{ experience.employment_type }}
                                </span>

                                <span v-if="experience.location">
                                    {{ experience.location }}
                                </span>

                            </div>

                            <p>
                                {{ experience.description }}
                            </p>

                        </div>

                        <div class="experience-arrow">
                            <i class="bi bi-arrow-up-right"></i>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- Projects -->
        <section class="section projects-section" id="projects">

            <div class="container">

                <div class="section-heading heading-row">

                    <div>

                        <span class="section-label">
                            SELECTED WORK
                        </span>

                        <h2>
                            Things I've
                            <span>built.</span>
                        </h2>

                    </div>

                    <router-link
                        to="/projects"
                        class="section-link"
                    >
                        View all projects
                        <i class="bi bi-arrow-up-right"></i>
                    </router-link>

                </div>


                <div class="projects-grid">

                    <article
                        v-for="(project, index) in projects"
                        :key="project.id"
                        class="project-card"
                    >

                        <div class="project-image">

                            <img
                                v-if="project.image"
                                :src="getProjectImage(project.image)"
                                :alt="project.title"
                            >

                            <div
                                v-else
                                class="project-placeholder"
                            >
                                {{ project.title?.charAt(0) }}
                            </div>

                            <div class="project-overlay">
                                <span>
                                    {{ String(index + 1).padStart(2, '0') }}
                                </span>

                                <i class="bi bi-arrow-up-right"></i>
                            </div>

                        </div>

                        <div class="project-content">

                            <div class="project-category">
                                {{ project.category || 'Web Development' }}
                            </div>

                            <h3>
                                {{ project.title }}
                            </h3>

                            <p>
                                {{ project.short_description }}
                            </p>

                            <div class="project-tags">

                                <span
                                    v-for="technology in parseTechnologies(project.technologies)"
                                    :key="technology"
                                >
                                    {{ technology }}
                                </span>

                            </div>

                        </div>

                    </article>

                </div>

            </div>

        </section>


        <!-- Gallery -->
        <section class="section gallery-section" id="gallery">

            <div class="container">

                <div class="section-heading heading-row">

                    <div>

                        <span class="section-label">
                            VISUAL STORIES
                        </span>

                        <h2>
                            Moments worth
                            <span>remembering.</span>
                        </h2>

                    </div>

                    <router-link
                        to="/gallery"
                        class="section-link"
                    >
                        Explore gallery
                        <i class="bi bi-arrow-up-right"></i>
                    </router-link>

                </div>


                <div
                    v-for="category in galleryCategories"
                    :key="category.id"
                    class="gallery-category"
                >

                    <div class="category-title">

                        <span>
                            {{ category.name }}
                        </span>

                        <small>
                            {{ category.images?.length || 0 }} moments
                        </small>

                    </div>

                    <div class="gallery-grid">

                        <div
                            v-for="image in category.images"
                            :key="image.id"
                            class="gallery-item"
                        >

                            <img
                                :src="getGalleryImage(image.image)"
                                :alt="image.title"
                            >

                            <div class="gallery-overlay">

                                <span>
                                    {{ image.title }}
                                </span>

                                <small>
                                    {{ image.short_description }}
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- Contact CTA -->
        <section class="contact-section" id="contact">

            <div class="container">

                <div class="contact-box">

                    <div class="contact-number">
                        04
                    </div>

                    <span class="section-label">
                        HAVE A PROJECT?
                    </span>

                    <h2>
                        Let's create something
                        <span>great together.</span>
                    </h2>

                    <p>
                        Have an idea, project or opportunity?
                        I'd love to hear about it.
                    </p>

                    <router-link
                        to="/contact"
                        class="contact-button"
                    >
                        Start a conversation
                        <i class="bi bi-arrow-up-right"></i>
                    </router-link>

                </div>

            </div>

        </section>

    </PublicLayout>
</template>


<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import PublicLayout from '../../layouts/PublicLayout.vue';

const profile = ref({});
const skills = ref([]);
const experiences = ref([]);
const projects = ref([]);
const galleryCategories = ref([]);

const loadHomeData = async () => {
    try {
        const response = await axios.get('/data/home');

        const data = response.data;

        profile.value = data.profile || {};
        skills.value = data.skills || [];
        experiences.value = data.experiences || [];
        projects.value = data.projects || [];
        galleryCategories.value = data.gallery_categories || [];

    } catch (error) {
        console.error('Error loading home data:', error);
    }
};

const formatDate = date => {
    if (!date) {
        return 'Present';
    }

    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        year: 'numeric'
    });
};

const parseTechnologies = technologies => {
    if (!technologies) {
        return [];
    }

    if (Array.isArray(technologies)) {
        return technologies;
    }

    return technologies
        .split(',')
        .map(item => item.trim())
        .filter(Boolean);
};

const getProfileImage = image => {
    if (!image) {
        return '';
    }

    if (image.startsWith('http')) {
        return image;
    }

    return `/uploads/profile/${image}`;
};

const getProjectImage = image => {
    if (!image) {
        return '';
    }

    if (image.startsWith('http')) {
        return image;
    }

    return `/uploads/projects/${image}`;
};

const getGalleryImage = image => {
    if (!image) {
        return '';
    }

    if (image.startsWith('http')) {
        return image;
    }

    return `/uploads/gallery/${image}`;
};

onMounted(() => {
    loadHomeData();
});
</script>


<style scoped>
.hero-section {
    position: relative;
    min-height: calc(100vh - 76px);
    display: flex;
    align-items: center;
    overflow: hidden;
    padding: 100px 0;
    background: #08080c;
}

.hero-grid {
    position: absolute;
    inset: 0;
    opacity: 0.35;
    background-image:
        linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
    background-size: 70px 70px;
    mask-image: linear-gradient(to bottom, black, transparent);
}

.hero-section::before {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    top: -250px;
    left: -200px;
    border-radius: 50%;
    background: rgba(124, 92, 255, 0.12);
    filter: blur(100px);
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 13px;
    margin-bottom: 28px;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 50px;
    color: #9b9ba8;
    font-size: .72rem;
    letter-spacing: .04em;
    background: rgba(255,255,255,.025);
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #65d68a;
    box-shadow: 0 0 12px rgba(101,214,138,.8);
}

.hero-intro {
    margin-bottom: 8px;
    color: #9d83ff;
    font-size: .8rem;
    font-weight: 700;
    letter-spacing: .2em;
}

.hero-title {
    margin: 0;
    color: #fff;
    font-size: clamp(3.5rem, 8vw, 7.5rem);
    line-height: .92;
    letter-spacing: -.065em;
    font-weight: 800;
}

.hero-role {
    margin-top: 22px;
    color: #d1d1d9;
    font-size: clamp(1.3rem, 2vw, 1.8rem);
    font-weight: 500;
}

.hero-description {
    max-width: 600px;
    margin: 24px 0 0;
    color: #8e8e9b;
    font-size: 1rem;
    line-height: 1.8;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 34px;
}

.btn-primary-custom,
.btn-outline-custom,
.contact-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 13px 20px;
    border-radius: 9px;
    text-decoration: none;
    font-size: .84rem;
    font-weight: 600;
    transition: .25s ease;
}

.btn-primary-custom {
    color: #fff;
    background: #8b6cff;
}

.btn-primary-custom:hover {
    color: #fff;
    transform: translateY(-2px);
    background: #7655ef;
}

.btn-outline-custom {
    color: #fff;
    border: 1px solid rgba(255,255,255,.12);
}

.btn-outline-custom:hover {
    color: #fff;
    background: rgba(255,255,255,.05);
}

.hero-tech {
    display: flex;
    flex-wrap: wrap;
    gap: 22px;
    margin-top: 50px;
}

.hero-tech span {
    color: #666673;
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .1em;
}

.hero-visual {
    position: relative;
    max-width: 410px;
    margin: auto;
}

.visual-glow {
    position: absolute;
    inset: 10% -10%;
    border-radius: 50%;
    background: rgba(139,108,255,.16);
    filter: blur(80px);
}

.visual-card {
    position: relative;
    padding: 18px;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 20px;
    background: rgba(255,255,255,.035);
    backdrop-filter: blur(20px);
    box-shadow: 0 30px 80px rgba(0,0,0,.4);
}

.visual-top,
.visual-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.visual-top {
    padding: 4px 5px 18px;
    color: #686873;
    font-size: .65rem;
    letter-spacing: .15em;
}

.visual-number {
    color: #8b6cff;
}

.profile-frame {
    overflow: hidden;
    aspect-ratio: 1 / 1.15;
    border-radius: 14px;
    background: #111117;
}

.profile-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #18151f, #0d0d12);
}

.visual-bottom {
    padding: 18px 5px 2px;
}

.visual-bottom div {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.visual-bottom small {
    color: #62626e;
    font-size: .6rem;
    letter-spacing: .1em;
}

.visual-bottom strong {
    color: #d5d5dd;
    font-size: .72rem;
    font-weight: 500;
}

.floating-card {
    position: absolute;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 13px;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 10px;
    color: #d7d7df;
    background: rgba(15,15,20,.9);
    box-shadow: 0 15px 40px rgba(0,0,0,.35);
    font-size: .7rem;
}

.floating-card i {
    color: #9d83ff;
}

.floating-card-one {
    top: 25%;
    left: -45px;
}

.floating-card-two {
    right: -35px;
    bottom: 24%;
}

.scroll-indicator {
    position: absolute;
    bottom: 25px;
    left: 50%;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #555560;
    font-size: .6rem;
    letter-spacing: .12em;
    transform: translateX(-50%);
}

.stats-section {
    background: #0d0d12;
    border-top: 1px solid rgba(255,255,255,.06);
    border-bottom: 1px solid rgba(255,255,255,.06);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.stat-item {
    padding: 30px;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,.06);
}

.stat-item:last-child {
    border-right: 0;
}

.stat-item strong {
    display: block;
    color: #fff;
    font-size: 1.7rem;
    font-weight: 700;
}

.stat-item span {
    color: #666673;
    font-size: .7rem;
    text-transform: uppercase;
    letter-spacing: .1em;
}

.section {
    padding: 130px 0;
    background: #08080c;
}

.section-heading {
    max-width: 750px;
    margin-bottom: 65px;
}

.section-heading h2 {
    margin: 12px 0 0;
    color: #fff;
    font-size: clamp(2.2rem, 5vw, 4rem);
    line-height: 1;
    letter-spacing: -.045em;
}

.section-heading h2 span {
    color: #8b6cff;
}

.section-label {
    color: #8b6cff;
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .2em;
}

.heading-row {
    max-width: none;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 30px;
}

.section-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #a9a9b5;
    text-decoration: none;
    font-size: .78rem;
    transition: .2s ease;
}

.section-link:hover {
    color: #fff;
}

.about-number {
    color: rgba(255,255,255,.07);
    font-size: 9rem;
    line-height: .8;
    font-weight: 800;
    letter-spacing: -.08em;
}

.about-highlight {
    max-width: 380px;
    margin-top: -20px;
    color: #fff;
    font-size: 1.5rem;
    line-height: 1.4;
}

.about-text {
    color: #8b8b98;
    font-size: 1rem;
    line-height: 1.9;
}

.about-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    margin-top: 35px;
    padding-top: 25px;
    border-top: 1px solid rgba(255,255,255,.08);
}

.about-details div {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.about-details span {
    color: #555560;
    font-size: .6rem;
    letter-spacing: .1em;
}

.about-details strong {
    color: #d4d4dc;
    font-size: .8rem;
    font-weight: 500;
}

.skills-section {
    background: #0d0d12;
}

.skills-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

.skill-card {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 20px;
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 12px;
    background: rgba(255,255,255,.02);
    transition: .25s ease;
}

.skill-card:hover {
    transform: translateY(-3px);
    border-color: rgba(139,108,255,.3);
}

.skill-icon {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    color: #9d83ff;
    background: rgba(139,108,255,.1);
    font-size: 1rem;
}

.skill-info {
    flex: 1;
}

.skill-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 9px;
}

.skill-header strong {
    color: #dddde5;
    font-size: .8rem;
}

.skill-header span {
    color: #777783;
    font-size: .7rem;
}

.skill-bar {
    height: 3px;
    overflow: hidden;
    border-radius: 10px;
    background: rgba(255,255,255,.07);
}

.skill-bar span {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: #8b6cff;
}

.skill-info small {
    display: block;
    margin-top: 7px;
    color: #555560;
    font-size: .6rem;
}

.experience-list {
    border-top: 1px solid rgba(255,255,255,.08);
}

.experience-item {
    display: grid;
    grid-template-columns: 180px 1fr 50px;
    gap: 35px;
    padding: 35px 10px;
    border-bottom: 1px solid rgba(255,255,255,.08);
    transition: .25s ease;
}

.experience-item:hover {
    padding-left: 20px;
    background: rgba(255,255,255,.015);
}

.experience-year {
    display: flex;
    flex-direction: column;
    gap: 3px;
    color: #666673;
    font-size: .7rem;
}

.experience-company {
    color: #8b6cff;
    font-size: .72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.experience-content h3 {
    margin: 7px 0 10px;
    color: #fff;
    font-size: 1.25rem;
}

.experience-meta {
    display: flex;
    gap: 15px;
    color: #666673;
    font-size: .7rem;
}

.experience-content p {
    max-width: 700px;
    margin: 15px 0 0;
    color: #858592;
    font-size: .85rem;
    line-height: 1.8;
}

.experience-arrow {
    color: #555560;
    font-size: 1rem;
}

.projects-section {
    background: #0d0d12;
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
}

.project-card {
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 14px;
    background: #111117;
    transition: .3s ease;
}

.project-card:hover {
    transform: translateY(-5px);
    border-color: rgba(139,108,255,.3);
}

.project-image {
    position: relative;
    height: 310px;
    overflow: hidden;
    background: #17171e;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .4s ease;
}

.project-card:hover .project-image img {
    transform: scale(1.04);
}

.project-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #252532;
    font-size: 8rem;
    font-weight: 800;
}

.project-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 20px;
    background: linear-gradient(to bottom, rgba(0,0,0,.45), transparent 40%);
    color: #fff;
}

.project-overlay span {
    font-size: .7rem;
}

.project-overlay i {
    font-size: 1rem;
}

.project-content {
    padding: 25px;
}

.project-category {
    color: #8b6cff;
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .12em;
}

.project-content h3 {
    margin: 8px 0;
    color: #fff;
    font-size: 1.35rem;
}

.project-content p {
    min-height: 45px;
    margin: 0;
    color: #777783;
    font-size: .8rem;
    line-height: 1.7;
}

.project-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 18px;
}

.project-tags span {
    padding: 5px 8px;
    border-radius: 5px;
    color: #898995;
    background: rgba(255,255,255,.05);
    font-size: .6rem;
}

.gallery-section {
    background: #08080c;
}

.gallery-category {
    margin-bottom: 45px;
}

.category-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
}

.category-title span {
    color: #dddde5;
    font-size: .85rem;
    font-weight: 600;
}

.category-title small {
    color: #555560;
    font-size: .65rem;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.gallery-item {
    position: relative;
    height: 250px;
    overflow: hidden;
    border-radius: 10px;
    background: #111117;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .4s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.gallery-overlay {
    position: absolute;
    inset: auto 0 0;
    padding: 30px 15px 15px;
    background: linear-gradient(transparent, rgba(0,0,0,.85));
}

.gallery-overlay span {
    display: block;
    color: #fff;
    font-size: .75rem;
    font-weight: 600;
}

.gallery-overlay small {
    display: block;
    margin-top: 3px;
    color: #aaaab5;
    font-size: .6rem;
}

.contact-section {
    padding: 100px 0;
    background: #0d0d12;
}

.contact-box {
    position: relative;
    overflow: hidden;
    padding: 80px;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px;
    background: linear-gradient(135deg, #15121f, #0e0e13);
}

.contact-box::after {
    content: '';
    position: absolute;
    width: 350px;
    height: 350px;
    right: -100px;
    bottom: -180px;
    border-radius: 50%;
    background: rgba(139,108,255,.2);
    filter: blur(80px);
}

.contact-number {
    position: absolute;
    top: 20px;
    right: 35px;
    color: rgba(255,255,255,.05);
    font-size: 8rem;
    font-weight: 800;
}

.contact-box h2 {
    position: relative;
    z-index: 1;
    max-width: 700px;
    margin: 15px 0;
    color: #fff;
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    line-height: 1;
    letter-spacing: -.05em;
}

.contact-box h2 span {
    color: #8b6cff;
}

.contact-box p {
    position: relative;
    z-index: 1;
    max-width: 550px;
    color: #888894;
    line-height: 1.8;
}

.contact-button {
    position: relative;
    z-index: 1;
    margin-top: 20px;
    color: #fff;
    background: #8b6cff;
}

.contact-button:hover {
    color: #fff;
    transform: translateY(-2px);
    background: #7655ef;
}

@media (max-width: 991.98px) {
    .hero-section {
        padding: 80px 0;
    }

    .hero-visual {
        margin-top: 70px;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .stat-item:nth-child(2) {
        border-right: 0;
    }

    .about-number {
        font-size: 6rem;
    }

    .experience-item {
        grid-template-columns: 130px 1fr 30px;
        gap: 20px;
    }
}

@media (max-width: 767.98px) {
    .hero-section {
        min-height: auto;
        padding: 70px 0;
    }

    .hero-title {
        font-size: 3.7rem;
    }

    .hero-description {
        font-size: .9rem;
    }

    .floating-card-one {
        left: -10px;
    }

    .floating-card-two {
        right: -10px;
    }

    .scroll-indicator {
        display: none;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .stat-item {
        padding: 22px 10px;
    }

    .section {
        padding: 85px 0;
    }

    .heading-row {
        display: block;
    }

    .section-link {
        margin-top: 20px;
    }

    .skills-grid,
    .projects-grid {
        grid-template-columns: 1fr;
    }

    .experience-item {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .experience-arrow {
        display: none;
    }

    .about-details {
        grid-template-columns: 1fr;
    }

    .gallery-grid {
        grid-template-columns: 1fr 1fr;
    }

    .gallery-item {
        height: 180px;
    }

    .contact-box {
        padding: 50px 25px;
    }
}

@media (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }

    .gallery-item {
        height: 240px;
    }
}
</style>