<template>
    <PublicLayout>
        <section class="gallery-page">
            <div class="gallery-container">

                <!-- Header -->
                <header class="gallery-header">
                    <div class="header-left">
                        <span class="eyebrow">VISUAL ARCHIVE</span>
                        <h1>A collection of <span>moments.</span></h1>
                        <p>
                            A curated collection of projects, experiences,
                            events and moments from my journey.
                        </p>
                    </div>

                    <div class="header-count">
                        <strong>{{ totalImages }}</strong>
                        <span>Images</span>
                    </div>
                </header>

                <!-- Category Filter -->
                <div v-if="categories.length" class="category-wrapper">
                    <div class="category-label">EXPLORE BY CATEGORY</div>

                    <div class="category-list">
                        <button
                            class="category-btn"
                            :class="{ active: activeCategory === 'all' }"
                            @click="activeCategory = 'all'"
                        >
                            <span>All</span>
                            <small>{{ totalImages }}</small>
                        </button>

                        <button
                            v-for="category in categories"
                            :key="category.id"
                            class="category-btn"
                            :class="{ active: activeCategory === category.id }"
                            @click="activeCategory = category.id"
                        >
                            <span>{{ category.name }}</span>
                            <small>{{ category.images.length }}</small>
                        </button>
                    </div>
                </div>

                <!-- Loading -->
                <div v-if="loading" class="gallery-loading">
                    <div class="loading-spinner"></div>
                    <span>Loading gallery...</span>
                </div>

                <!-- Error -->
                <div v-else-if="error" class="gallery-message error-message">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ error }}</span>
                    <button @click="loadGallery">Try Again</button>
                </div>

                <!-- Empty -->
                <div v-else-if="filteredImages.length === 0" class="gallery-message">
                    <i class="bi bi-images"></i>
                    <h3>No images found</h3>
                    <p>There are no images in this category yet.</p>
                </div>

                <!-- Gallery -->
                <div v-else class="gallery-grid">
                    <article
                        v-for="(item, index) in filteredImages"
                        :key="item.id"
                        class="gallery-card"
                        @click="openLightbox(item)"
                    >
                        <div class="gallery-image">
                            <img
                                :src="getImageUrl(item.image)"
                                :alt="item.title"
                                loading="lazy"
                            >

                            <div class="image-overlay">
                                <div class="overlay-top">
                                    <span class="image-number">
                                        {{ String(index + 1).padStart(2, '0') }}
                                    </span>

                                    <span class="view-icon">
                                        <i class="bi bi-arrows-fullscreen"></i>
                                    </span>
                                </div>

                                <div class="overlay-bottom">
                                    <span class="image-category">
                                        {{ item.category?.name || 'Gallery' }}
                                    </span>

                                    <h3>{{ item.title }}</h3>

                                    <p v-if="item.short_description">
                                        {{ item.short_description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

            </div>
        </section>

        <!-- Lightbox -->
        <Transition name="lightbox">
            <div
                v-if="selectedImage"
                class="lightbox"
                @click.self="closeLightbox"
            >
                <button class="lightbox-close" @click="closeLightbox">
                    <i class="bi bi-x-lg"></i>
                </button>

                <button
                    v-if="lightboxIndex > 0"
                    class="lightbox-nav lightbox-prev"
                    @click.stop="previousImage"
                >
                    <i class="bi bi-arrow-left"></i>
                </button>

                <div class="lightbox-content">
                    <img
                        :src="getImageUrl(selectedImage.image)"
                        :alt="selectedImage.title"
                    >

                    <div class="lightbox-info">
                        <div>
                            <span>
                                {{ selectedImage.category?.name || 'Gallery' }}
                            </span>
                            <h2>{{ selectedImage.title }}</h2>

                            <p v-if="selectedImage.long_description">
                                {{ selectedImage.long_description }}
                            </p>

                            <p
                                v-else-if="selectedImage.short_description"
                            >
                                {{ selectedImage.short_description }}
                            </p>
                        </div>

                        <div class="lightbox-counter">
                            {{ lightboxIndex + 1 }} / {{ filteredImages.length }}
                        </div>
                    </div>
                </div>

                <button
                    v-if="lightboxIndex < filteredImages.length - 1"
                    class="lightbox-nav lightbox-next"
                    @click.stop="nextImage"
                >
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </Transition>
    </PublicLayout>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import axios from 'axios';
import PublicLayout from '../../layouts/PublicLayout.vue';

const categories = ref([]);
const activeCategory = ref('all');
const selectedImage = ref(null);
const loading = ref(true);
const error = ref('');

const totalImages = computed(() => {
    return categories.value.reduce((total, category) => {
        return total + category.images.length;
    }, 0);
});

const filteredImages = computed(() => {
    if (activeCategory.value === 'all') {
        return categories.value.flatMap(category => category.images);
    }

    const category = categories.value.find(
        category => category.id === activeCategory.value
    );

    return category ? category.images : [];
});

const lightboxIndex = computed(() => {
    if (!selectedImage.value) {
        return -1;
    }

    return filteredImages.value.findIndex(
        image => image.id === selectedImage.value.id
    );
});

const getImageUrl = (image) => {
    if (!image) {
        return '';
    }

    if (image.startsWith('/')) {
        return image;
    }

    return `/uploads/gallery/${image}`;
};

const loadGallery = async () => {
    loading.value = true;
    error.value = '';

    try {
        const response = await axios.get('/data/gallery');

        categories.value = response.data.categories || [];
    } catch (err) {
        console.error(err);
        error.value = 'Unable to load the gallery right now.';
    } finally {
        loading.value = false;
    }
};

const openLightbox = (image) => {
    selectedImage.value = image;
    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    selectedImage.value = null;
    document.body.style.overflow = '';
};

const nextImage = () => {
    const nextIndex = lightboxIndex.value + 1;

    if (nextIndex < filteredImages.value.length) {
        selectedImage.value = filteredImages.value[nextIndex];
    }
};

const previousImage = () => {
    const previousIndex = lightboxIndex.value - 1;

    if (previousIndex >= 0) {
        selectedImage.value = filteredImages.value[previousIndex];
    }
};

onMounted(() => {
    loadGallery();
});
</script>

<style scoped>
.gallery-page {
    min-height: 100vh;
    background: #08080c;
    color: #fff;
    padding: 150px 0 110px;
}

.gallery-container {
    width: min(1400px, calc(100% - 80px));
    margin: 0 auto;
}

.gallery-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 40px;
    padding-bottom: 70px;
    border-bottom: 1px solid rgba(255,255,255,.08);
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #8b6cff;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .22em;
    margin-bottom: 22px;
}

.eyebrow::before {
    content: '';
    width: 28px;
    height: 1px;
    background: #8b6cff;
}

.gallery-header h1 {
    max-width: 800px;
    margin: 0;
    font-size: clamp(48px, 7vw, 96px);
    line-height: .95;
    letter-spacing: -.055em;
    font-weight: 700;
}

.gallery-header h1 span {
    color: #8b6cff;
}

.gallery-header p {
    max-width: 600px;
    margin: 28px 0 0;
    color: rgba(255,255,255,.48);
    font-size: 16px;
    line-height: 1.8;
}

.header-count {
    min-width: 130px;
    padding-left: 28px;
    border-left: 1px solid rgba(255,255,255,.12);
}

.header-count strong {
    display: block;
    font-size: 52px;
    line-height: 1;
    letter-spacing: -.05em;
}

.header-count span {
    display: block;
    margin-top: 8px;
    color: rgba(255,255,255,.4);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .18em;
}

.category-wrapper {
    padding: 38px 0 42px;
}

.category-label {
    margin-bottom: 17px;
    color: rgba(255,255,255,.3);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .18em;
}

.category-list {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
}

.category-btn {
    display: inline-flex;
    align-items: center;
    gap: 13px;
    padding: 11px 17px;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 999px;
    background: transparent;
    color: rgba(255,255,255,.55);
    cursor: pointer;
    transition: .25s ease;
}

.category-btn small {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.35);
    font-size: 9px;
}

.category-btn:hover {
    border-color: rgba(139,108,255,.5);
    color: #fff;
}

.category-btn.active {
    border-color: #8b6cff;
    background: #8b6cff;
    color: #fff;
}

.category-btn.active small {
    background: rgba(255,255,255,.18);
    color: #fff;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 18px;
}

.gallery-card {
    grid-column: span 4;
    cursor: pointer;
}

.gallery-card:nth-child(5n + 1),
.gallery-card:nth-child(5n + 4) {
    grid-column: span 5;
}

.gallery-card:nth-child(5n + 2),
.gallery-card:nth-child(5n + 3),
.gallery-card:nth-child(5n + 5) {
    grid-column: span 7;
}

.gallery-image {
    position: relative;
    overflow: hidden;
    aspect-ratio: 1.25 / 1;
    border: 1px solid rgba(255,255,255,.08);
    background: #101015;
}

.gallery-card:nth-child(5n + 1) .gallery-image,
.gallery-card:nth-child(5n + 4) .gallery-image {
    aspect-ratio: 1 / 1.08;
}

.gallery-card:nth-child(5n + 2) .gallery-image,
.gallery-card:nth-child(5n + 3) .gallery-image {
    aspect-ratio: 1.65 / 1;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .7s cubic-bezier(.2,.7,.2,1);
}

.gallery-card:hover .gallery-image img {
    transform: scale(1.06);
}

.image-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 22px;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,.45),
        transparent 35%,
        rgba(0,0,0,.9)
    );
    opacity: 0;
    transition: .35s ease;
}

.gallery-card:hover .image-overlay {
    opacity: 1;
}

.overlay-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.image-number {
    color: rgba(255,255,255,.75);
    font-size: 11px;
    letter-spacing: .12em;
}

.view-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 50%;
    background: rgba(0,0,0,.25);
    backdrop-filter: blur(8px);
}

.overlay-bottom {
    max-width: 90%;
}

.image-category {
    display: inline-block;
    margin-bottom: 9px;
    color: #a995ff;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
}

.overlay-bottom h3 {
    margin: 0;
    font-size: 23px;
    line-height: 1.15;
}

.overlay-bottom p {
    margin: 8px 0 0;
    color: rgba(255,255,255,.6);
    font-size: 12px;
    line-height: 1.5;
}

.gallery-loading {
    min-height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 16px;
    color: rgba(255,255,255,.4);
}

.loading-spinner {
    width: 34px;
    height: 34px;
    border: 2px solid rgba(255,255,255,.1);
    border-top-color: #8b6cff;
    border-radius: 50%;
    animation: spin .8s linear infinite;
}

.gallery-message {
    min-height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: rgba(255,255,255,.4);
}

.gallery-message > i {
    margin-bottom: 18px;
    color: #8b6cff;
    font-size: 38px;
}

.gallery-message h3 {
    margin: 0;
    color: #fff;
}

.gallery-message p {
    margin: 8px 0 20px;
}

.error-message button {
    padding: 9px 18px;
    border: 1px solid rgba(139,108,255,.5);
    border-radius: 30px;
    background: transparent;
    color: #fff;
    cursor: pointer;
}

.lightbox {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    background: rgba(3,3,6,.96);
    backdrop-filter: blur(20px);
}

.lightbox-content {
    width: min(1100px, 90vw);
    max-height: 90vh;
}

.lightbox-content > img {
    display: block;
    width: 100%;
    max-height: 72vh;
    object-fit: contain;
    background: #050507;
}

.lightbox-info {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    padding-top: 20px;
}

.lightbox-info > div:first-child > span {
    color: #8b6cff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
}

.lightbox-info h2 {
    margin: 6px 0;
    font-size: 25px;
}

.lightbox-info p {
    max-width: 700px;
    margin: 0;
    color: rgba(255,255,255,.45);
    font-size: 13px;
    line-height: 1.6;
}

.lightbox-counter {
    flex-shrink: 0;
    color: rgba(255,255,255,.35);
    font-size: 12px;
    padding-top: 10px;
}

.lightbox-close,
.lightbox-nav {
    position: absolute;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.04);
    color: #fff;
    cursor: pointer;
    transition: .25s ease;
}

.lightbox-close {
    top: 25px;
    right: 30px;
    width: 45px;
    height: 45px;
    border-radius: 50%;
}

.lightbox-nav {
    top: 50%;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    transform: translateY(-50%);
}

.lightbox-prev {
    left: 25px;
}

.lightbox-next {
    right: 25px;
}

.lightbox-close:hover,
.lightbox-nav:hover {
    border-color: #8b6cff;
    background: #8b6cff;
}

.lightbox-enter-active,
.lightbox-leave-active {
    transition: opacity .25s ease;
}

.lightbox-enter-from,
.lightbox-leave-to {
    opacity: 0;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@media (max-width: 992px) {
    .gallery-container {
        width: min(100% - 40px, 760px);
    }

    .gallery-header {
        align-items: flex-start;
    }

    .gallery-card,
    .gallery-card:nth-child(5n + 1),
    .gallery-card:nth-child(5n + 2),
    .gallery-card:nth-child(5n + 3),
    .gallery-card:nth-child(5n + 4),
    .gallery-card:nth-child(5n + 5) {
        grid-column: span 6;
    }

    .gallery-card:nth-child(3n) {
        grid-column: span 12;
    }
}

@media (max-width: 650px) {
    .gallery-page {
        padding: 120px 0 80px;
    }

    .gallery-container {
        width: min(100% - 30px, 560px);
    }

    .gallery-header {
        display: block;
        padding-bottom: 45px;
    }

    .gallery-header h1 {
        font-size: 48px;
    }

    .gallery-header p {
        font-size: 14px;
    }

    .header-count {
        display: inline-block;
        margin-top: 30px;
        padding-left: 18px;
    }

    .header-count strong {
        font-size: 38px;
    }

    .category-list {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 8px;
        scrollbar-width: none;
    }

    .category-list::-webkit-scrollbar {
        display: none;
    }

    .category-btn {
        flex-shrink: 0;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .gallery-card,
    .gallery-card:nth-child(5n + 1),
    .gallery-card:nth-child(5n + 2),
    .gallery-card:nth-child(5n + 3),
    .gallery-card:nth-child(5n + 4),
    .gallery-card:nth-child(5n + 5),
    .gallery-card:nth-child(3n) {
        grid-column: span 1;
    }

    .gallery-image,
    .gallery-card:nth-child(5n + 1) .gallery-image,
    .gallery-card:nth-child(5n + 4) .gallery-image,
    .gallery-card:nth-child(5n + 2) .gallery-image,
    .gallery-card:nth-child(5n + 3) .gallery-image {
        aspect-ratio: 1.15 / 1;
    }

    .image-overlay {
        opacity: 1;
        padding: 17px;
    }

    .overlay-bottom h3 {
        font-size: 19px;
    }

    .lightbox {
        padding: 20px 15px;
    }

    .lightbox-content {
        width: 100%;
    }

    .lightbox-content > img {
        max-height: 65vh;
    }

    .lightbox-info {
        display: block;
    }

    .lightbox-counter {
        margin-top: 10px;
    }

    .lightbox-prev {
        left: 10px;
    }

    .lightbox-next {
        right: 10px;
    }
}
</style>