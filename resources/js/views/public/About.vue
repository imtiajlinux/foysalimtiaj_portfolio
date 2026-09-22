<template>
    <PublicLayout>
        <div class="about-page">

            <!-- HERO -->
            <section class="about-hero">
                <div class="about-container">
                    <div class="hero-grid">
                        <div class="hero-copy">
                            <span class="eyebrow">ABOUT ME</span>

                            <h1>
                                More than a
                                <span>developer.</span>
                            </h1>

                            <p class="hero-intro">
                                {{ profile.short_bio || 'I build modern, scalable and user-friendly web applications.' }}
                            </p>

                            <div class="hero-actions">
                                <a
                                    v-if="profile.cv"
                                    :href="getFileUrl(profile.cv)"
                                    target="_blank"
                                    class="primary-btn"
                                >
                                    <span>View My CV</span>
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>

                                <router-link to="/contact" class="secondary-btn">
                                    Let's Talk
                                    <i class="bi bi-arrow-right"></i>
                                </router-link>
                            </div>
                        </div>

                        <div class="hero-profile">
                            <div class="profile-frame">
                                <div class="frame-corner top-left"></div>
                                <div class="frame-corner top-right"></div>
                                <div class="frame-corner bottom-left"></div>
                                <div class="frame-corner bottom-right"></div>

                                <div class="profile-image" v-if="profileImage">
                                    <img :src="profileImage" :alt="profile.name">
                                </div>

                                <div v-else class="profile-placeholder">
                                    <span>{{ initials }}</span>
                                </div>

                                <div class="profile-status">
                                    <span></span>
                                    {{ profile.title || 'Web Developer' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- INTRODUCTION -->
            <section class="intro-section">
                <div class="about-container">
                    <div class="section-label">
                        <span>01</span>
                        WHO I AM
                    </div>

                    <div class="intro-grid">
                        <div>
                            <h2>
                                I turn ideas into
                                <span>digital experiences.</span>
                            </h2>
                        </div>

                        <div class="intro-content">
                            <p v-if="profile.about">
                                {{ profile.about }}
                            </p>

                            <p v-else-if="profile.short_bio">
                                {{ profile.short_bio }}
                            </p>

                            <p>
                                My focus is on building applications that are
                                not only visually polished, but also reliable,
                                scalable and easy to use.
                            </p>

                            <p>
                                I enjoy working across the full development
                                process — from planning and interface design
                                to backend architecture, database development
                                and bringing the final product to life.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STATS -->
            <section class="stats-section">
                <div class="about-container">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <strong>{{ projects.length }}</strong>
                            <span>Projects</span>
                        </div>

                        <div class="stat-card">
                            <strong>{{ skills.length }}</strong>
                            <span>Technologies</span>
                        </div>

                        <div class="stat-card">
                            <strong>{{ experiences.length }}</strong>
                            <span>Experiences</span>
                        </div>

                        <div class="stat-card">
                            <strong>100%</strong>
                            <span>Passion</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SKILLS -->
            <section class="skills-section">
                <div class="about-container">
                    <div class="section-label">
                        <span>02</span>
                        WHAT I WORK WITH
                    </div>

                    <div class="section-heading">
                        <h2>Tools of the <span>craft.</span></h2>
                        <p>
                            Technologies and tools I use to build modern web
                            applications.
                        </p>
                    </div>

                    <div v-if="skills.length" class="skills-grid">
                        <div
                            v-for="(skill, index) in skills"
                            :key="skill.id"
                            class="skill-card"
                        >
                            <div class="skill-number">
                                {{ String(index + 1).padStart(2, '0') }}
                            </div>

                            <div class="skill-main">
                                <h3>
                                    {{ skill.name || skill.skill_name }}
                                </h3>

                                <span v-if="skill.category">
                                    {{ skill.category }}
                                </span>
                            </div>

                            <i class="bi bi-arrow-up-right"></i>
                        </div>
                    </div>
                </div>
            </section>

            <!-- EXPERIENCE -->
            <section class="experience-section">
                <div class="about-container">
                    <div class="section-label">
                        <span>03</span>
                        EXPERIENCE
                    </div>

                    <div class="section-heading">
                        <h2>The journey <span>so far.</span></h2>
                        <p>
                            A timeline of my professional experience and
                            development journey.
                        </p>
                    </div>

                    <div v-if="experiences.length" class="timeline">
                        <article
                            v-for="experience in experiences"
                            :key="experience.id"
                            class="timeline-item"
                        >
                            <div class="timeline-marker"></div>

                            <div class="timeline-date">
                                {{ formatDate(experience.start_date) }}
                                —
                                {{ experience.currently_working ? 'Present' : formatDate(experience.end_date) }}
                            </div>

                            <div class="timeline-content">
                                <div
                                    v-if="experience.company_logo"
                                    class="company-logo"
                                >
                                    <img
                                        :src="getExperienceLogo(experience.company_logo)"
                                        :alt="experience.company"
                                    >
                                </div>

                                <div class="timeline-info">
                                    <span class="experience-type">
                                        {{ experience.employment_type }}
                                    </span>

                                    <h3>{{ experience.position }}</h3>

                                    <h4>
                                        {{ experience.company }}
                                        <span v-if="experience.location">
                                            · {{ experience.location }}
                                        </span>
                                    </h4>

                                    <p v-if="experience.description">
                                        {{ experience.description }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div v-else class="empty-state">
                        Experience information will be added soon.
                    </div>
                </div>
            </section>

            <!-- EDUCATION -->
            <section class="education-section">
                <div class="about-container">
                    <div class="section-label">
                        <span>04</span>
                        EDUCATION
                    </div>

                    <div class="section-heading">
                        <h2>Learning never <span>stops.</span></h2>
                    </div>

                    <div v-if="education.length" class="education-grid">
                        <article
                            v-for="item in education"
                            :key="item.id"
                            class="education-card"
                        >
                            <div class="education-year">
                                {{ formatYear(item.start_date) }}
                                <span>→</span>
                                {{ item.currently_studying ? 'Present' : formatYear(item.end_date) }}
                            </div>

                            <div class="education-content">
                                <h3>{{ item.degree }}</h3>

                                <h4>{{ item.institution }}</h4>

                                <span v-if="item.field_of_study">
                                    {{ item.field_of_study }}
                                </span>

                                <span v-if="item.location">
                                    {{ item.location }}
                                </span>

                                <p v-if="item.description">
                                    {{ item.description }}
                                </p>

                                <div v-if="item.grade" class="grade">
                                    Grade: {{ item.grade }}
                                </div>
                            </div>
                        </article>
                    </div>

                    <div v-else class="empty-state">
                        Education information will be added soon.
                    </div>
                </div>
            </section>

            <!-- PROJECTS -->
            <section class="work-section">
                <div class="about-container">
                    <div class="section-label">
                        <span>05</span>
                        SELECTED WORK
                    </div>

                    <div class="section-heading work-heading">
                        <div>
                            <h2>Things I've <span>built.</span></h2>
                            <p>
                                A few projects that represent my approach to
                                solving real-world problems.
                            </p>
                        </div>

                        <router-link to="/projects" class="view-all">
                            View all projects
                            <i class="bi bi-arrow-up-right"></i>
                        </router-link>
                    </div>

                    <div class="project-list">
                        <article
                            v-for="(project, index) in projects.slice(0, 4)"
                            :key="project.id"
                            class="project-row"
                        >
                            <div class="project-index">
                                {{ String(index + 1).padStart(2, '0') }}
                            </div>

                            <div class="project-info">
                                <span>{{ project.category || 'PROJECT' }}</span>
                                <h3>{{ project.title }}</h3>
                                <p>
                                    {{ project.short_description || project.description }}
                                </p>
                            </div>

                            <div class="project-arrow">
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <!-- CONTACT CTA -->
            <section class="about-cta">
                <div class="about-container">
                    <div class="cta-box">
                        <span class="eyebrow">HAVE AN IDEA?</span>

                        <h2>
                            Let's build something
                            <span>meaningful.</span>
                        </h2>

                        <p>
                            Whether you have a project in mind or simply want
                            to start a conversation, I'd love to hear from you.
                        </p>

                        <router-link to="/contact" class="cta-button">
                            Start a conversation
                            <i class="bi bi-arrow-up-right"></i>
                        </router-link>
                    </div>
                </div>
            </section>

        </div>
    </PublicLayout>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import axios from 'axios';
import PublicLayout from '../../layouts/PublicLayout.vue';

const profile = ref({});
const skills = ref([]);
const experiences = ref([]);
const education = ref([]);
const projects = ref([]);

const profileImage = computed(() => {
    if (!profile.value.profile_image) {
        return '';
    }

    if (profile.value.profile_image.startsWith('/')) {
        return profile.value.profile_image;
    }

    return `/uploads/profile/${profile.value.profile_image}`;
});

const initials = computed(() => {
    const name = profile.value.name || 'Foysal Imtiaj';

    return name
        .split(' ')
        .map(word => word.charAt(0))
        .join('')
        .substring(0, 2)
        .toUpperCase();
});

const getFileUrl = (file) => {
    if (!file) {
        return '#';
    }

    if (file.startsWith('/')) {
        return file;
    }

    return `/${file}`;
};

const getExperienceLogo = (logo) => {
    if (!logo) {
        return '';
    }

    if (logo.startsWith('/')) {
        return logo;
    }

    if (logo.startsWith('uploads/')) {
        return `/${logo}`;
    }

    return `/uploads/experience/${logo}`;
};

const formatDate = (date) => {
    if (!date) {
        return '—';
    }

    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        year: 'numeric'
    });
};

const formatYear = (date) => {
    if (!date) {
        return '—';
    }

    return new Date(date).getFullYear();
};

const loadAbout = async () => {
    try {
        const response = await axios.get('/data/about');

        profile.value = response.data.profile || {};
        skills.value = response.data.skills || [];
        experiences.value = response.data.experiences || [];
        education.value = response.data.education || [];
        projects.value = response.data.projects || [];
    } catch (error) {
        console.error('Failed to load about page:', error);
    }
};

onMounted(() => {
    loadAbout();
});
</script>

<style scoped>
.about-page {
    min-height: 100vh;
    background: #08080c;
    color: #fff;
}

.about-container {
    width: min(1280px, calc(100% - 80px));
    margin: 0 auto;
}

.about-hero {
    padding: 165px 0 120px;
    border-bottom: 1px solid rgba(255,255,255,.07);
}

.hero-grid {
    display: grid;
    grid-template-columns: 1.35fr .65fr;
    align-items: center;
    gap: 90px;
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #8b6cff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .22em;
}

.eyebrow::before {
    content: '';
    width: 28px;
    height: 1px;
    background: #8b6cff;
}

.hero-copy h1 {
    max-width: 850px;
    margin: 25px 0;
    font-size: clamp(58px, 8vw, 108px);
    line-height: .92;
    letter-spacing: -.06em;
}

.hero-copy h1 span,
.section-heading h2 span,
.intro-grid h2 span,
.about-cta h2 span {
    color: #8b6cff;
}

.hero-intro {
    max-width: 620px;
    color: rgba(255,255,255,.52);
    font-size: 18px;
    line-height: 1.8;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 34px;
}

.primary-btn,
.secondary-btn,
.cta-button {
    display: inline-flex;
    align-items: center;
    gap: 13px;
    padding: 14px 21px;
    border-radius: 3px;
    text-decoration: none;
    transition: .25s ease;
}

.primary-btn {
    background: #8b6cff;
    color: #fff;
}

.primary-btn:hover {
    background: #a18aff;
    color: #fff;
    transform: translateY(-2px);
}

.secondary-btn {
    border: 1px solid rgba(255,255,255,.13);
    color: #fff;
}

.secondary-btn:hover {
    border-color: #8b6cff;
    color: #fff;
}

.hero-profile {
    display: flex;
    justify-content: center;
}

.profile-frame {
    position: relative;
    width: min(390px, 100%);
    aspect-ratio: .82;
    padding: 15px;
    border: 1px solid rgba(255,255,255,.1);
}

.profile-image,
.profile-placeholder {
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: #111116;
}

.profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle, #29213f, #101015);
}

.profile-placeholder span {
    font-size: 80px;
    font-weight: 700;
    color: #8b6cff;
}

.frame-corner {
    position: absolute;
    z-index: 2;
    width: 25px;
    height: 25px;
    border-color: #8b6cff;
}

.top-left {
    top: -5px;
    left: -5px;
    border-top: 2px solid;
    border-left: 2px solid;
}

.top-right {
    top: -5px;
    right: -5px;
    border-top: 2px solid;
    border-right: 2px solid;
}

.bottom-left {
    bottom: -5px;
    left: -5px;
    border-bottom: 2px solid;
    border-left: 2px solid;
}

.bottom-right {
    right: -5px;
    bottom: -5px;
    border-right: 2px solid;
    border-bottom: 2px solid;
}

.profile-status {
    position: absolute;
    right: -25px;
    bottom: 25px;
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 10px 14px;
    border: 1px solid rgba(255,255,255,.1);
    background: rgba(8,8,12,.9);
    backdrop-filter: blur(10px);
    color: rgba(255,255,255,.7);
    font-size: 10px;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.profile-status span {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #8b6cff;
    box-shadow: 0 0 12px #8b6cff;
}

.intro-section,
.skills-section,
.experience-section,
.education-section,
.work-section {
    padding: 120px 0;
    border-bottom: 1px solid rgba(255,255,255,.07);
}

.section-label {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 55px;
    color: rgba(255,255,255,.3);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .2em;
}

.section-label span {
    color: #8b6cff;
}

.intro-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 100px;
}

.intro-grid h2,
.section-heading h2 {
    margin: 0;
    font-size: clamp(40px, 5vw, 70px);
    line-height: 1;
    letter-spacing: -.05em;
}

.intro-content {
    color: rgba(255,255,255,.5);
    font-size: 15px;
    line-height: 1.9;
}

.intro-content p {
    margin: 0 0 22px;
}

.stats-section {
    padding: 35px 0;
    border-bottom: 1px solid rgba(255,255,255,.07);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.stat-card {
    padding: 25px 30px;
    border-right: 1px solid rgba(255,255,255,.08);
}

.stat-card:last-child {
    border-right: 0;
}

.stat-card strong {
    display: block;
    font-size: 42px;
    letter-spacing: -.04em;
}

.stat-card span {
    display: block;
    margin-top: 5px;
    color: rgba(255,255,255,.35);
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: .15em;
}

.section-heading {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 50px;
    margin-bottom: 55px;
}

.section-heading p {
    max-width: 430px;
    margin: 0;
    color: rgba(255,255,255,.4);
    font-size: 14px;
    line-height: 1.8;
}

.skills-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    border-top: 1px solid rgba(255,255,255,.08);
    border-left: 1px solid rgba(255,255,255,.08);
}

.skill-card {
    display: flex;
    align-items: center;
    gap: 20px;
    min-height: 125px;
    padding: 25px;
    border-right: 1px solid rgba(255,255,255,.08);
    border-bottom: 1px solid rgba(255,255,255,.08);
    transition: .3s ease;
}

.skill-card:hover {
    background: rgba(139,108,255,.06);
}

.skill-number {
    color: #8b6cff;
    font-size: 10px;
}

.skill-main {
    flex: 1;
}

.skill-main h3 {
    margin: 0;
    font-size: 18px;
}

.skill-main span {
    display: block;
    margin-top: 5px;
    color: rgba(255,255,255,.3);
    font-size: 10px;
    text-transform: uppercase;
}

.skill-card > i {
    color: rgba(255,255,255,.2);
}

.timeline {
    position: relative;
    margin-left: 20px;
    border-left: 1px solid rgba(255,255,255,.1);
}

.timeline-item {
    position: relative;
    padding: 0 0 70px 55px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    top: 4px;
    left: -5px;
    width: 9px;
    height: 9px;
    border: 2px solid #8b6cff;
    border-radius: 50%;
    background: #08080c;
}

.timeline-date {
    margin-bottom: 18px;
    color: #8b6cff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .15em;
    text-transform: uppercase;
}

.timeline-content {
    display: flex;
    gap: 22px;
}

.company-logo {
    flex-shrink: 0;
    width: 55px;
    height: 55px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.1);
    background: #111116;
}

.company-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.timeline-info h3 {
    margin: 0;
    font-size: 28px;
    letter-spacing: -.03em;
}

.timeline-info h4 {
    margin: 7px 0 15px;
    color: rgba(255,255,255,.55);
    font-size: 14px;
    font-weight: 400;
}

.timeline-info h4 span {
    color: rgba(255,255,255,.3);
}

.experience-type {
    color: rgba(255,255,255,.3);
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .16em;
    text-transform: uppercase;
}

.timeline-info p {
    max-width: 750px;
    margin: 0;
    color: rgba(255,255,255,.42);
    font-size: 14px;
    line-height: 1.8;
}

.education-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
}

.education-card {
    min-height: 270px;
    padding: 30px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.015);
    transition: .3s ease;
}

.education-card:hover {
    border-color: rgba(139,108,255,.4);
    transform: translateY(-3px);
}

.education-year {
    display: flex;
    gap: 9px;
    color: #8b6cff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .12em;
}

.education-content {
    margin-top: 45px;
}

.education-content h3 {
    margin: 0;
    font-size: 26px;
}

.education-content h4 {
    margin: 9px 0;
    color: rgba(255,255,255,.55);
    font-size: 14px;
    font-weight: 400;
}

.education-content > span {
    display: block;
    margin-top: 5px;
    color: rgba(255,255,255,.3);
    font-size: 11px;
}

.education-content p {
    margin: 20px 0 0;
    color: rgba(255,255,255,.4);
    font-size: 13px;
    line-height: 1.7;
}

.grade {
    display: inline-block;
    margin-top: 20px;
    padding: 7px 11px;
    border: 1px solid rgba(139,108,255,.25);
    color: #a995ff;
    font-size: 10px;
}

.work-heading {
    margin-bottom: 35px;
}

.view-all {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #fff;
    font-size: 12px;
    text-decoration: none;
    white-space: nowrap;
}

.view-all:hover {
    color: #8b6cff;
}

.project-list {
    border-top: 1px solid rgba(255,255,255,.08);
}

.project-row {
    display: grid;
    grid-template-columns: 80px 1fr 60px;
    align-items: center;
    gap: 30px;
    min-height: 145px;
    border-bottom: 1px solid rgba(255,255,255,.08);
    transition: .3s ease;
}

.project-row:hover {
    padding-left: 10px;
}

.project-index {
    color: #8b6cff;
    font-size: 11px;
}

.project-info > span {
    color: rgba(255,255,255,.3);
    font-size: 9px;
    letter-spacing: .15em;
}

.project-info h3 {
    margin: 7px 0;
    font-size: 24px;
}

.project-info p {
    max-width: 650px;
    margin: 0;
    color: rgba(255,255,255,.38);
    font-size: 12px;
}

.project-arrow {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 42px;
    height: 42px;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 50%;
    color: rgba(255,255,255,.5);
}

.about-cta {
    padding: 120px 0;
}

.cta-box {
    position: relative;
    overflow: hidden;
    padding: 85px;
    border: 1px solid rgba(139,108,255,.25);
    background:
        radial-gradient(circle at 80% 20%, rgba(139,108,255,.16), transparent 35%),
        rgba(255,255,255,.015);
}

.cta-box h2 {
    max-width: 850px;
    margin: 25px 0;
    font-size: clamp(42px, 6vw, 78px);
    line-height: .95;
    letter-spacing: -.055em;
}

.cta-box p {
    max-width: 550px;
    color: rgba(255,255,255,.42);
    line-height: 1.8;
}

.cta-button {
    margin-top: 25px;
    background: #8b6cff;
    color: #fff;
}

.cta-button:hover {
    background: #a18aff;
    color: #fff;
}

.empty-state {
    padding: 50px;
    border: 1px dashed rgba(255,255,255,.1);
    color: rgba(255,255,255,.3);
    text-align: center;
}

@media (max-width: 900px) {
    .about-container {
        width: min(100% - 40px, 700px);
    }

    .hero-grid,
    .intro-grid {
        grid-template-columns: 1fr;
        gap: 60px;
    }

    .hero-profile {
        justify-content: flex-start;
    }

    .profile-frame {
        width: min(330px, 100%);
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .stat-card:nth-child(2) {
        border-right: 0;
    }

    .stat-card:nth-child(3),
    .stat-card:nth-child(4) {
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .skills-grid,
    .education-grid {
        grid-template-columns: 1fr;
    }

    .section-heading {
        display: block;
    }

    .section-heading p {
        margin-top: 20px;
    }

    .view-all {
        margin-top: 25px;
    }

    .cta-box {
        padding: 55px 35px;
    }
}

@media (max-width: 600px) {
    .about-container {
        width: min(100% - 30px, 560px);
    }

    .about-hero {
        padding: 125px 0 80px;
    }

    .hero-copy h1 {
        font-size: 54px;
    }

    .hero-intro {
        font-size: 15px;
    }

    .profile-status {
        right: -5px;
    }

    .intro-section,
    .skills-section,
    .experience-section,
    .education-section,
    .work-section,
    .about-cta {
        padding: 80px 0;
    }

    .intro-grid h2,
    .section-heading h2 {
        font-size: 42px;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }

    .stat-card {
        padding: 20px 15px;
    }

    .stat-card strong {
        font-size: 32px;
    }

    .timeline {
        margin-left: 8px;
    }

    .timeline-item {
        padding-left: 30px;
    }

    .timeline-content {
        display: block;
    }

    .company-logo {
        margin-bottom: 18px;
    }

    .timeline-info h3 {
        font-size: 23px;
    }

    .project-row {
        grid-template-columns: 35px 1fr 40px;
        gap: 12px;
        min-height: 125px;
    }

    .project-info h3 {
        font-size: 19px;
    }

    .project-info p {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .cta-box {
        padding: 45px 25px;
    }

    .cta-box h2 {
        font-size: 43px;
    }
}
</style>