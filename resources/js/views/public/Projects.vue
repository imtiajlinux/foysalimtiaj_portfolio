<template>
    <PublicLayout>
        <section class="projects-page">
            <div class="page-glow"></div>

            <div class="container">
                <header class="projects-header">
                    <div>
                        <span class="section-label">SELECTED WORK</span>
                        <h1 class="page-title">
                            Things I've
                            <span>built.</span>
                        </h1>
                    </div>

                    <div class="header-side">
                        <p>
                            A selection of projects, experiments and digital
                            products built with modern technologies.
                        </p>
                        <span class="project-count">
                            {{ projects.length.toString().padStart(2, '0') }}
                            PROJECTS
                        </span>
                    </div>
                </header>

                <div v-if="loading" class="loading-state">
                    <div class="loader"></div>
                    <span>Loading projects...</span>
                </div>

                <div v-else-if="error" class="error-state">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ error }}</span>
                </div>

                <div v-else-if="projects.length" class="projects-list">
                    <article
                        v-for="(project, index) in projects"
                        :key="project.id"
                        class="project-card"
                        :class="{ featured: project.is_featured }"
                    >
                        <div class="project-number">
                            {{ String(index + 1).padStart(2, '0') }}
                        </div>

                        <div class="project-image-wrap">
                            <img
                                v-if="project.image"
                                :src="getProjectImage(project.image)"
                                :alt="project.title"
                                class="project-image"
                            >

                            <div v-else class="project-image-placeholder">
                                <span>{{ getInitial(project.title) }}</span>
                            </div>

                            <div v-if="project.is_featured" class="featured-label">
                                FEATURED
                            </div>

                            <div class="image-overlay">
                                <span>VIEW PROJECT</span>
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                        </div>

                        <div class="project-content">
                            <div class="project-meta">
                                <span>{{ project.category || 'Web Development' }}</span>
                                <span v-if="project.is_featured">Featured</span>
                            </div>

                            <h2>{{ project.title }}</h2>

                            <p>
                                {{ project.short_description || project.description }}
                            </p>

                            <div
                                v-if="parseTechnologies(project.technologies).length"
                                class="technology-list"
                            >
                                <span
                                    v-for="technology in parseTechnologies(project.technologies)"
                                    :key="technology"
                                >
                                    {{ technology }}
                                </span>
                            </div>

                            <div class="project-actions">
                                <a
                                    v-if="project.project_url"
                                    :href="project.project_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="project-link primary"
                                >
                                    Live Project
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>

                                <a
                                    v-if="project.github_url"
                                    :href="project.github_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="project-link"
                                >
                                    GitHub
                                    <i class="bi bi-github"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                <div v-else class="empty-state">
                    <span class="empty-number">00</span>
                    <h2>Projects are coming soon.</h2>
                    <p>
                        I'm currently preparing some work to showcase here.
                    </p>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import PublicLayout from '../../layouts/PublicLayout.vue';

const projects = ref([]);
const loading = ref(true);
const error = ref('');

const getProjectImage = (image) => {
    return `/uploads/projects/${image}`;
};

const getInitial = (title) => {
    return title ? title.charAt(0).toUpperCase() : '?';
};

const parseTechnologies = (technologies) => {
    if (!technologies) return [];

    if (Array.isArray(technologies)) {
        return technologies;
    }

    try {
        const parsed = JSON.parse(technologies);

        if (Array.isArray(parsed)) {
            return parsed;
        }
    } catch (e) {
        // Continue with comma-separated values.
    }

    return technologies
        .split(',')
        .map(item => item.trim())
        .filter(Boolean);
};

const loadProjects = async () => {
    loading.value = true;
    error.value = '';

    try {
        const response = await axios.get('/data/projects');

        projects.value = response.data.projects || response.data.data || [];
    } catch (err) {
        console.error('Failed to load projects:', err);
        error.value = 'Unable to load projects right now.';
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    loadProjects();
});
</script>

<style scoped>
.projects-page {
    position: relative;
    overflow: hidden;
    min-height: calc(100vh - 82px);
    padding: 110px 0 120px;
    background: #08080c;
}

.page-glow {
    position: absolute;
    width: 600px;
    height: 600px;
    right: -300px;
    top: 40px;
    border-radius: 50%;
    background: rgba(139, 108, 255, 0.08);
    filter: blur(110px);
    pointer-events: none;
}

.projects-header {
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 60px;
    padding-bottom: 75px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
}

.section-label {
    display: block;
    margin-bottom: 18px;
    color: #8b6cff;
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.2em;
}

.page-title {
    max-width: 700px;
    margin: 0;
    color: #f5f5f7;
    font-size: clamp(3.5rem, 8vw, 7rem);
    line-height: 0.9;
    letter-spacing: -0.065em;
    font-weight: 600;
}

.page-title span {
    display: block;
    color: #8b6cff;
}

.header-side {
    max-width: 320px;
}

.header-side p {
    margin: 0 0 22px;
    color: #686873;
    font-size: 0.8rem;
    line-height: 1.85;
}

.project-count {
    color: #4d4d57;
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.14em;
}

.projects-list {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 1px;
    margin-top: 70px;
}

.project-card {
    position: relative;
    display: grid;
    grid-template-columns: 45px minmax(400px, 1.2fr) minmax(300px, 0.8fr);
    gap: 35px;
    align-items: center;
    padding: 35px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    transition: border-color 0.25s ease;
}

.project-card:hover {
    border-color: rgba(139, 108, 255, 0.3);
}

.project-number {
    align-self: flex-start;
    padding-top: 8px;
    color: #46464f;
    font-size: 0.6rem;
    font-weight: 600;
}

.project-image-wrap {
    position: relative;
    overflow: hidden;
    aspect-ratio: 16 / 10;
    border-radius: 10px;
    background: #101016;
}

.project-image {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.project-card:hover .project-image {
    transform: scale(1.035);
}

.project-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background:
        radial-gradient(circle at 50% 40%, rgba(139, 108, 255, 0.2), transparent 45%),
        #101016;
}

.project-image-placeholder span {
    color: #8b6cff;
    font-size: 5rem;
    font-weight: 700;
    letter-spacing: -0.08em;
}

.featured-label {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 6px 9px;
    border: 1px solid rgba(139, 108, 255, 0.35);
    border-radius: 5px;
    color: #c0b6ff;
    background: rgba(8, 8, 12, 0.75);
    backdrop-filter: blur(10px);
    font-size: 0.5rem;
    font-weight: 700;
    letter-spacing: 0.12em;
}

.image-overlay {
    position: absolute;
    inset: auto 15px 15px 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 11px 10px 13px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 7px;
    color: #fff;
    background: rgba(8, 8, 12, 0.72);
    backdrop-filter: blur(10px);
    opacity: 0;
    transform: translateY(8px);
    transition: 0.3s ease;
}

.project-card:hover .image-overlay {
    opacity: 1;
    transform: translateY(0);
}

.image-overlay span {
    font-size: 0.56rem;
    font-weight: 700;
    letter-spacing: 0.1em;
}

.image-overlay i {
    color: #8b6cff;
}

.project-content {
    padding-right: 20px;
}

.project-meta {
    display: flex;
    gap: 12px;
    margin-bottom: 15px;
}

.project-meta span {
    color: #656570;
    font-size: 0.57rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.project-meta span + span {
    color: #8b6cff;
}

.project-content h2 {
    margin: 0;
    color: #ededf0;
    font-size: clamp(1.5rem, 2.5vw, 2.2rem);
    line-height: 1.05;
    letter-spacing: -0.045em;
    font-weight: 600;
}

.project-content p {
    margin: 18px 0 22px;
    color: #686873;
    font-size: 0.77rem;
    line-height: 1.8;
}

.technology-list {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.technology-list span {
    padding: 5px 8px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 5px;
    color: #60606a;
    font-size: 0.52rem;
}

.project-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 25px;
}

.project-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 12px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 6px;
    color: #85858f;
    text-decoration: none;
    font-size: 0.61rem;
    font-weight: 600;
    transition: 0.25s ease;
}

.project-link:hover {
    color: #fff;
    border-color: rgba(139, 108, 255, 0.3);
    background: rgba(139, 108, 255, 0.06);
}

.project-link.primary {
    color: #fff;
    border-color: rgba(139, 108, 255, 0.35);
    background: #8b6cff;
}

.project-link.primary:hover {
    background: #7655ef;
    border-color: #7655ef;
}

.project-link i {
    font-size: 0.65rem;
}

.loading-state,
.error-state,
.empty-state {
    min-height: 350px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.loading-state {
    gap: 15px;
    color: #5e5e68;
    font-size: 0.7rem;
}

.loader {
    width: 28px;
    height: 28px;
    border: 2px solid rgba(139, 108, 255, 0.15);
    border-top-color: #8b6cff;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

.error-state {
    gap: 10px;
    color: #d98590;
    font-size: 0.7rem;
}

.empty-state {
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 12px;
    margin-top: 70px;
    background: rgba(255, 255, 255, 0.015);
}

.empty-number {
    color: #8b6cff;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.15em;
}

.empty-state h2 {
    margin: 15px 0 8px;
    color: #dddde2;
    font-size: 1.5rem;
    letter-spacing: -0.03em;
}

.empty-state p {
    margin: 0;
    color: #5e5e68;
    font-size: 0.72rem;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@media (max-width: 991.98px) {
    .projects-header {
        display: block;
    }

    .header-side {
        margin-top: 30px;
    }

    .project-card {
        grid-template-columns: 35px 1fr;
        gap: 20px;
    }

    .project-content {
        grid-column: 2;
        padding-right: 0;
    }
}

@media (max-width: 767.98px) {
    .projects-page {
        padding: 80px 0;
    }

    .projects-header {
        padding-bottom: 55px;
    }

    .page-title {
        font-size: clamp(3rem, 15vw, 5rem);
    }

    .projects-list {
        margin-top: 50px;
    }

    .project-card {
        grid-template-columns: 30px 1fr;
        gap: 15px;
        padding: 25px 0;
    }

    .project-image-wrap {
        aspect-ratio: 16 / 11;
    }

    .project-content {
        grid-column: 2;
    }

    .image-overlay {
        display: none;
    }
}

@media (max-width: 500px) {
    .project-card {
        grid-template-columns: 1fr;
    }

    .project-number {
        padding: 0;
    }

    .project-content {
        grid-column: auto;
    }
}
</style>