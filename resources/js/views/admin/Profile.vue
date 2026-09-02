<template>
    <AdminLayout>
        <div class="container-fluid py-4 profile-page">
            <div class="page-head">
                <h1 class="page-title">Profile</h1>
                <p class="page-sub">Manage your portfolio profile information.</p>
            </div>

            <div v-if="successMessage" class="notice notice-success">
                {{ successMessage }}
            </div>

            <div v-if="generalError" class="notice notice-error">
                {{ generalError }}
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="panel">
                        <form @submit.prevent="saveProfile">
                            <section class="form-section">
                                <div class="section-head">
                                    <h3>Basic details</h3>
                                </div>
                                <div class="field-grid">
                                    <div class="field" :class="{ 'has-error': errors.name }">
                                        <label for="name">Name</label>
                                        <input id="name" v-model="form.name" type="text">
                                        <p v-if="errors.name" class="field-error">{{ errors.name }}</p>
                                    </div>

                                    <div class="field">
                                        <label for="title">Professional title</label>
                                        <input id="title" v-model="form.title" type="text" placeholder="Web Developer">
                                        <p v-if="errors.title" class="field-error">{{ errors.title }}</p>
                                    </div>

                                    <div class="field" :class="{ 'has-error': errors.email }">
                                        <label for="email">Email</label>
                                        <input id="email" v-model="form.email" type="email">
                                        <p v-if="errors.email" class="field-error">{{ errors.email }}</p>
                                    </div>

                                    <div class="field">
                                        <label for="phone">Phone</label>
                                        <input id="phone" v-model="form.phone" type="text">
                                    </div>

                                    <div class="field">
                                        <label for="dob">Date of birth</label>
                                        <input id="dob" v-model="form.date_of_birth" type="date">
                                    </div>

                                    <div class="field" :class="{ 'has-error': errors.website }">
                                        <label for="website">Website</label>
                                        <input id="website" v-model="form.website" type="url" placeholder="https://example.com">
                                        <p v-if="errors.website" class="field-error">{{ errors.website }}</p>
                                    </div>

                                    <div class="field field-select">
                                        <label for="status">Status</label>
                                        <select id="status" v-model="form.status">
                                            <option value="a">Active</option>
                                            <option value="p">Pending</option>
                                            <option value="d">Deleted</option>
                                        </select>
                                    </div>
                                </div>
                            </section>

                            <section class="form-section">
                                <div class="section-head">
                                    <h3>Biography</h3>
                                </div>
                                <div class="field-grid">
                                    <div class="field field-wide">
                                        <label for="short_bio">Short bio</label>
                                        <textarea id="short_bio" v-model="form.short_bio" rows="3"></textarea>
                                    </div>

                                    <div class="field field-wide">
                                        <label for="about">About</label>
                                        <textarea id="about" v-model="form.about" rows="6"></textarea>
                                    </div>
                                </div>
                            </section>

                            <section class="form-section">
                                <div class="section-head">
                                    <h3>Address</h3>
                                </div>
                                <div class="field-grid">
                                    <div class="field field-wide">
                                        <label for="current_address">Current address</label>
                                        <textarea id="current_address" v-model="form.current_address" rows="3"></textarea>
                                    </div>

                                    <div class="field field-wide">
                                        <label for="permanent_address">Permanent address</label>
                                        <textarea id="permanent_address" v-model="form.permanent_address" rows="3"></textarea>
                                    </div>
                                </div>
                            </section>

                            <section class="form-section">
                                <div class="section-head">
                                    <h3>Media</h3>
                                </div>
                                <div class="field-grid">
                                    <div class="field">
                                        <label>Profile photo</label>
                                        <div class="upload-zone">
                                            <label v-if="!profilePhotoPreview" for="profile_photo_field" class="upload-zone-inner">
                                                <span class="upload-icon">+</span>
                                                <span class="upload-text">Click to upload</span>
                                                <span class="upload-hint">PNG or JPG, up to 6MB</span>
                                            </label>
                                            <div v-else class="upload-preview-wrap">
                                                <img :src="profilePhotoPreview" class="upload-preview profile-preview" alt="Profile preview">
                                                <div class="upload-actions">
                                                    <label for="profile_photo_field" class="upload-replace" style="margin-bottom:0px;">Replace</label>
                                                    <button type="button" class="remove-btn" @click="removeProfilePhoto">Remove</button>
                                                </div>
                                            </div>
                                            <input id="profile_photo_field" ref="profilePhotoInput" type="file" accept="image/*" class="visually-hidden-input" @change="handleProfilePhoto">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label>Cover image</label>
                                        <div class="upload-zone upload-zone-wide">
                                            <label v-if="!coverImagePreview" for="cover_image_field" class="upload-zone-inner">
                                                <span class="upload-icon">+</span>
                                                <span class="upload-text">Click to upload</span>
                                                <span class="upload-hint">PNG or JPG, up to 6MB</span>
                                            </label>
                                            <div v-else class="upload-preview-wrap">
                                                <img :src="coverImagePreview" class="upload-preview cover-preview" alt="Cover preview">
                                                <div class="upload-actions">
                                                    <label for="cover_image_field" class="upload-replace" style="margin-bottom:0px;">Replace</label>
                                                    <button type="button" class="remove-btn" @click="removeCoverImage">Remove</button>
                                                </div>
                                            </div>
                                            <input id="cover_image_field" ref="coverImageInput" type="file" accept="image/*" class="visually-hidden-input" @change="handleCoverImage">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <div class="submit-row">
                                <button type="submit" class="submit-btn" :disabled="saving">
                                    <span v-if="saving" class="spinner" aria-hidden="true"></span>
                                    {{ saving ? 'Saving' : 'Save profile' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="preview-card">
                        <div class="cover-container">
                            <img v-if="coverImagePreview" :src="coverImagePreview" class="cover-image" alt="Cover image">
                            <div v-else class="cover-placeholder"></div>

                            <div class="profile-photo-container">
                                <img v-if="profilePhotoPreview" :src="profilePhotoPreview" class="profile-photo" alt="Profile photo">
                                <div v-else class="profile-photo profile-placeholder">FI</div>
                            </div>
                        </div>

                        <div class="preview-body">
                            <h3>{{ form.name || 'Your name' }}</h3>
                            <p class="preview-title">{{ form.title || 'Professional title' }}</p>

                            <p v-if="form.short_bio" class="preview-bio">
                                {{ form.short_bio }}
                            </p>

                            <div class="preview-meta">
                                <div v-if="form.email" class="preview-item">
                                    <i class="bi bi-envelope"></i>
                                    <span>{{ form.email }}</span>
                                </div>

                                <div v-if="form.phone" class="preview-item">
                                    <i class="bi bi-telephone"></i>
                                    <span>{{ form.phone }}</span>
                                </div>

                                <div v-if="form.website" class="preview-item">
                                    <i class="bi bi-globe"></i>
                                    <span>{{ form.website }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { reactive, ref, onMounted, onBeforeUnmount } from 'vue';
import AdminLayout from '../../layouts/AdminLayout.vue';

const profilePhotoInput = ref(null);
const coverImageInput = ref(null);

const loading = ref(false);
const saving = ref(false);

const successMessage = ref('');
const generalError = ref('');

const profilePhotoPreview = ref('');
const coverImagePreview = ref('');

const profilePhotoFile = ref(null);
const coverImageFile = ref(null);

const errors = reactive({
    name: '',
    title: '',
    email: '',
    website: '',
});

const form = reactive({
    name: '',
    title: '',
    email: '',
    phone: '',
    date_of_birth: '',
    website: '',
    short_bio: '',
    about: '',
    current_address: '',
    permanent_address: '',
    status: 'a',
});

const clearMessages = () => {
    successMessage.value = '';
    generalError.value = '';
};

const loadProfile = async () => {
    loading.value = true;
    generalError.value = '';

    try {
        const response = await fetch('/admin/data/profile', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });

        const contentType = response.headers.get('content-type') || '';

        if (!contentType.includes('application/json')) {
            throw new Error('Server returned an invalid response.');
        }

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Unable to load profile.');
        }

        if (data.profile) {
            Object.keys(form).forEach(key => {
                if (data.profile[key] !== undefined && data.profile[key] !== null) {
                    form[key] = key === 'date_of_birth'
                        ? String(data.profile[key]).slice(0, 10)
                        : data.profile[key];
                }
            });

            if (data.profile.profile_photo_url) {
                profilePhotoPreview.value = data.profile.profile_photo_url;
            }

            if (data.profile.cover_image_url) {
                coverImagePreview.value = data.profile.cover_image_url;
            }
        }
    } catch (error) {
        console.error('Profile loading error:', error);
        generalError.value = error.message || 'Unable to load profile.';
    } finally {
        loading.value = false;
    }
};

const validateImage = file => {
    if (!file) {
        return false;
    }

    if (!file.type.startsWith('image/')) {
        generalError.value = 'Please select a valid image file.';
        return false;
    }

    if (file.size > 6 * 1024 * 1024) {
        generalError.value = 'Image size must not exceed 6 MB.';
        return false;
    }

    return true;
};

const handleProfilePhoto = event => {
    clearMessages();

    const file = event.target.files[0];

    if (!file || !validateImage(file)) {
        event.target.value = '';
        return;
    }

    profilePhotoFile.value = file;

    if (profilePhotoPreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(profilePhotoPreview.value);
    }

    profilePhotoPreview.value = URL.createObjectURL(file);
};

const handleCoverImage = event => {
    clearMessages();

    const file = event.target.files[0];

    if (!file || !validateImage(file)) {
        event.target.value = '';
        return;
    }

    coverImageFile.value = file;

    if (coverImagePreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(coverImagePreview.value);
    }

    coverImagePreview.value = URL.createObjectURL(file);
};

const removeProfilePhoto = () => {
    if (profilePhotoPreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(profilePhotoPreview.value);
    }

    profilePhotoPreview.value = '';
    profilePhotoFile.value = null;

    if (profilePhotoInput.value) {
        profilePhotoInput.value.value = '';
    }
};

const removeCoverImage = () => {
    if (coverImagePreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(coverImagePreview.value);
    }

    coverImagePreview.value = '';
    coverImageFile.value = null;

    if (coverImageInput.value) {
        coverImageInput.value.value = '';
    }
};

const saveProfile = async () => {
    saving.value = true;
    clearMessages();

    errors.name = '';
    errors.title = '';
    errors.email = '';
    errors.website = '';

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const formData = new FormData();

        Object.keys(form).forEach(key => {
            formData.append(key, form[key] ?? '');
        });

        if (profilePhotoFile.value) {
            formData.append('profile_photo', profilePhotoFile.value);
        }

        if (coverImageFile.value) {
            formData.append('cover_image', coverImageFile.value);
        }

        const response = await fetch('/admin/data/profile', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: formData,
        });

        const contentType = response.headers.get('content-type') || '';

        if (!contentType.includes('application/json')) {
            throw new Error('Server returned an invalid response.');
        }

        const data = await response.json();

        if (!response.ok) {
            if (data.errors) {
                Object.keys(errors).forEach(key => {
                    if (data.errors[key]) {
                        errors[key] = Array.isArray(data.errors[key]) ? data.errors[key][0] : data.errors[key];
                    }
                });
            }

            throw new Error(data.message || 'Unable to save profile.');
        }

        successMessage.value = data.message || 'Profile updated successfully.';

       if (data.profile.profile_photo_url) {
            profilePhotoPreview.value = data.profile.profile_photo_url;
        }

        if (data.profile.cover_image_url) {
            coverImagePreview.value = data.profile.cover_image_url;
        }

        profilePhotoFile.value = null;
        coverImageFile.value = null;
    } catch (error) {
        console.error('Profile save error:', error);
        generalError.value = error.message || 'Unable to save profile.';
    } finally {
        saving.value = false;
    }
};

onMounted(() => {
    loadProfile();
});

onBeforeUnmount(() => {
    if (profilePhotoPreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(profilePhotoPreview.value);
    }

    if (coverImagePreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(coverImagePreview.value);
    }
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Space+Grotesk:wght@400;500;600&display=swap');

.profile-page {
    font-family: 'Space Grotesk', sans-serif;
    color: #14131C;
}

/* ---------- Page head ---------- */

.page-head {
    margin-bottom: 28px;
}

.page-title {
    font-family: 'Fraunces', serif;
    font-weight: 500;
    font-size: 32px;
    margin: 0 0 6px;
    color: #14131C;
}

.page-sub {
    font-size: 14.5px;
    color: #6B6875;
    margin: 0;
}

/* ---------- Notices ---------- */

.notice {
    font-size: 14px;
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 24px;
    border: 1px solid transparent;
}

.notice-success {
    background: #EAF7EF;
    border-color: #BFE3CC;
    color: #2F7D4F;
}

.notice-error {
    background: #FBEAEA;
    border-color: #E7B6B6;
    color: #9A3B3B;
}

/* ---------- Panel ---------- */

.panel {
    background: #FFFFFF;
    border: 1px solid #ECE9DD;
    border-top: 3px solid #4A4CE0;
    border-radius: 12px;
    padding: 32px clamp(20px, 3vw, 40px) 36px;
}

.form-section {
    margin-top: 36px;
}

.form-section:first-child {
    margin-top: 0;
}

.form-section + .form-section {
    border-top: 1px solid #ECE9DD;
    padding-top: 32px;
}

.section-head h3 {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 600;
    font-size: 15px;
    color: #14131C;
    margin: 0 0 20px;
}

.field-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 26px 28px;
}

.field-wide {
    grid-column: 1 / -1;
}

/* ---------- Fields ---------- */

.field label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #14131C;
    margin-bottom: 8px;
}

.field input,
.field select {
    width: 100%;
    border: none;
    border-bottom: 1.5px solid #D8D5CB;
    background: transparent;
    padding: 7px 2px 9px;
    font-family: inherit;
    font-size: 14.5px;
    color: #14131C;
    outline: none;
    transition: border-color 0.2s ease;
}

.field textarea {
    width: 100%;
    border: 1.5px solid #D8D5CB;
    border-radius: 10px;
    background: transparent;
    padding: 12px 14px;
    font-family: inherit;
    font-size: 14.5px;
    color: #14131C;
    outline: none;
    resize: vertical;
    transition: border-color 0.2s ease;
}

.field input::placeholder,
.field textarea::placeholder {
    color: #B4B0A6;
}

.field input:focus,
.field select:focus,
.field textarea:focus {
    border-color: #4A4CE0;
}

.field.has-error input {
    border-color: #C24A4A;
}

.field-select select {
    padding-bottom: 8px;
    cursor: pointer;
}

.field-error {
    font-size: 12px;
    color: #C24A4A;
    margin: 6px 0 0;
}

/* ---------- Uploads ---------- */

.upload-zone {
    border: 1.5px dashed #D8D5CB;
    border-radius: 12px;
    overflow: hidden;
    transition: border-color 0.2s ease, background 0.2s ease;
}

.upload-zone:has(.upload-zone-inner:hover) {
    border-color: #4A4CE0;
    background: rgba(74, 76, 224, 0.03);
}

.upload-zone-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 28px 16px;
    cursor: pointer;
    text-align: center;
}

.upload-icon {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #14131C;
    color: #F7F5EF;
    font-size: 16px;
    margin-bottom: 6px;
}

.upload-text {
    font-size: 13.5px;
    font-weight: 500;
    color: #14131C;
}

.upload-hint {
    font-size: 12px;
    color: #8B879C;
}

.upload-preview-wrap {
    position: relative;
}

.upload-preview {
    display: block;
    width: 100%;
    object-fit: cover;
}

.profile-preview {
    height: 150px;
}

.cover-preview {
    height: 120px;
}

.upload-actions {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: rgba(20, 19, 28, 0.55);
    opacity: 0;
    transition: opacity 0.18s ease;
}

.upload-preview-wrap:hover .upload-actions {
    opacity: 1;
}

.upload-replace,
.remove-btn {
    font-size: 12.5px;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
}

.upload-replace {
    background: #F7F5EF;
    color: #14131C;
}

.remove-btn {
    background: transparent;
    color: #F7F5EF;
    border: 1.5px solid #F7F5EF;
}

.visually-hidden-input {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* ---------- Submit ---------- */

.submit-row {
    margin-top: 36px;
    padding-top: 32px;
    border-top: 1px solid #ECE9DD;
}

.submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #14131C;
    color: #F7F5EF;
    border: none;
    border-radius: 8px;
    padding: 13px 28px;
    font-family: inherit;
    font-size: 14.5px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.18s ease, transform 0.06s ease;
}

.submit-btn:hover:not(:disabled) {
    background: #4A4CE0;
}

.submit-btn:active:not(:disabled) {
    transform: scale(0.99);
}

.submit-btn:disabled {
    opacity: 0.75;
    cursor: default;
}

.spinner {
    width: 14px;
    height: 14px;
    border: 2px solid rgba(247, 245, 239, 0.35);
    border-top-color: #F7F5EF;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ---------- Preview card ---------- */

.preview-card {
    background: #FFFFFF;
    border: 1px solid #ECE9DD;
    border-radius: 12px;
    overflow: hidden;
    position: sticky;
    top: 24px;
}

.cover-container {
    position: relative;
    height: 150px;
    background: #14131C;
}

.cover-image,
.cover-placeholder {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.cover-placeholder {
    background: linear-gradient(135deg, #14131C, #23223A);
}

.profile-photo-container {
    position: absolute;
    left: 28px;
    bottom: -44px;
}

.profile-photo,
.profile-placeholder {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    border: 4px solid #FFFFFF;
    object-fit: cover;
    background: #14131C;
    color: #F7F5EF;
}

.profile-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Fraunces', serif;
    font-size: 24px;
    font-weight: 500;
}

.preview-body {
    padding: 56px 24px 28px;
}

.preview-body h3 {
    font-family: 'Fraunces', serif;
    font-weight: 500;
    font-size: 21px;
    margin: 0 0 3px;
    color: #14131C;
}

.preview-title {
    font-size: 13.5px;
    color: #6B6875;
    margin: 0 0 16px;
}

.preview-bio {
    font-size: 13.5px;
    color: #52505C;
    line-height: 1.55;
    margin: 0 0 20px;
}

.preview-meta {
    border-top: 1px solid #ECE9DD;
    padding-top: 14px;
}

.preview-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    font-size: 13px;
    color: #52505C;
}

.preview-item i {
    width: 18px;
    color: #4A4CE0;
}

input:focus-visible,
select:focus-visible,
textarea:focus-visible,
button:focus-visible,
label:focus-within {
    outline: 2px solid #4A4CE0;
    outline-offset: 3px;
}

/* ---------- Responsive ---------- */

@media (max-width: 768px) {
    .field-grid {
        grid-template-columns: 1fr;
    }

    .panel {
        padding: 24px 18px 28px;
    }

    .preview-card {
        position: static;
    }
}
</style>