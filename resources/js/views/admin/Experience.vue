

<template>
    <AdminLayout>
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Experience</h4>
                    <p class="text-muted mb-0">Manage your professional experience.</p>
                </div>

                <button class="btn btn-primary" @click="openCreateModal">
                    <i class="bi bi-plus-lg me-2"></i>
                    Add Experience
                </button>
            </div>

            <!-- Success -->
            <div v-if="successMessage" class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>
                {{ successMessage }}

                <button type="button" class="btn-close" @click="successMessage = ''"></button>
            </div>

            <!-- Error -->
            <div v-if="generalError" class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ generalError }}

                <button type="button" class="btn-close" @click="generalError = ''"></button>
            </div>

            <!-- Loading -->
            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary"></div>
                <p class="text-muted mt-2 mb-0">Loading experiences...</p>
            </div>

            <!-- Empty -->
            <div v-else-if="experiences.length === 0" class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-briefcase fs-1 text-muted"></i>

                    <h5 class="mt-3">No Experience Found</h5>

                    <p class="text-muted">
                        Add your first professional experience.
                    </p>

                    <button class="btn btn-primary" @click="openCreateModal">
                        <i class="bi bi-plus-lg me-2"></i>
                        Add Experience
                    </button>
                </div>
            </div>

            <!-- Experience List -->
            <div v-else class="row g-4">
                <div
                    v-for="experience in experiences"
                    :key="experience.id"
                    class="col-12"
                >
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Logo -->
                                <div class="col-auto">
                                    <div
                                        class="experience-logo bg-light rounded d-flex align-items-center justify-content-center"
                                    >
                                        <img
                                            v-if="experience.company_logo"
                                            :src="getImageUrl(experience.company_logo)"
                                            :alt="experience.company"
                                            class="img-fluid rounded"
                                        >

                                        <i
                                            v-else
                                            class="bi bi-building fs-3 text-muted"
                                        ></i>
                                    </div>
                                </div>

                                <!-- Details -->
                                <div class="col">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <h5 class="mb-0">
                                            {{ experience.position }}
                                        </h5>

                                        <span
                                            v-if="experience.currently_working"
                                            class="badge bg-success"
                                        >
                                            Current
                                        </span>
                                    </div>

                                    <p class="mb-1 mt-1 fw-medium">
                                        {{ experience.company }}
                                    </p>

                                    <div class="d-flex flex-wrap gap-3 text-muted small">
                                        <span v-if="experience.employment_type">
                                            <i class="bi bi-briefcase me-1"></i>
                                            {{ experience.employment_type }}
                                        </span>

                                        <span v-if="experience.location">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ experience.location }}
                                        </span>

                                        <span>
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ formatDate(experience.start_date) }}
                                            -
                                            {{
                                                experience.currently_working
                                                    ? 'Present'
                                                    : formatDate(experience.end_date)
                                            }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-auto">
                                    <div class="d-flex gap-2">
                                        <button
                                            class="btn btn-sm btn-outline-primary"
                                            @click="openEditModal(experience)"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="deleteExperience(experience)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div
                                v-if="experience.description"
                                class="border-top mt-3 pt-3"
                            >
                                <p class="text-muted mb-0">
                                    {{ experience.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div
                class="modal fade"
                id="experienceModal"
                tabindex="-1"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ editMode ? 'Edit Experience' : 'Add Experience' }}
                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                @click="closeModal"
                            ></button>
                        </div>

                        <form @submit.prevent="saveExperience">
                            <div class="modal-body">
                                <!-- Company / Position -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Company <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            v-model="form.company"
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors.company }"
                                            placeholder="e.g. Link-up Technology"
                                        >

                                        <div v-if="errors.company" class="invalid-feedback">
                                            {{ errors.company[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Position <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            v-model="form.position"
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors.position }"
                                            placeholder="e.g. Web Developer"
                                        >

                                        <div v-if="errors.position" class="invalid-feedback">
                                            {{ errors.position[0] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Employment / Location -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Employment Type
                                        </label>

                                        <select
                                            v-model="form.employment_type"
                                            class="form-select"
                                        >
                                            <option value="">Select type</option>
                                            <option value="Full-time">Full-time</option>
                                            <option value="Part-time">Part-time</option>
                                            <option value="Contract">Contract</option>
                                            <option value="Internship">Internship</option>
                                            <option value="Freelance">Freelance</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Location
                                        </label>

                                        <input
                                            v-model="form.location"
                                            type="text"
                                            class="form-control"
                                            placeholder="e.g. Dhaka, Bangladesh"
                                        >
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Start Date <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            v-model="form.start_date"
                                            type="date"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors.start_date }"
                                        >

                                        <div v-if="errors.start_date" class="invalid-feedback">
                                            {{ errors.start_date[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            End Date
                                        </label>

                                        <input
                                            v-model="form.end_date"
                                            type="date"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors.end_date }"
                                            :disabled="form.currently_working"
                                        >

                                        <div v-if="errors.end_date" class="invalid-feedback">
                                            {{ errors.end_date[0] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Current -->
                                <div class="form-check mb-3">
                                    <input
                                        id="currentlyWorking"
                                        v-model="form.currently_working"
                                        type="checkbox"
                                        class="form-check-input"
                                    >

                                    <label
                                        for="currentlyWorking"
                                        class="form-check-label"
                                    >
                                        I currently work here
                                    </label>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        Description
                                    </label>

                                    <textarea
                                        v-model="form.description"
                                        rows="5"
                                        class="form-control"
                                        placeholder="Describe your responsibilities, achievements, technologies, etc."
                                    ></textarea>
                                </div>

                                <!-- Logo -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        Company Logo
                                    </label>

                                    <input
                                        ref="fileInput"
                                        type="file"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.company_logo }"
                                        accept="image/jpeg,image/png,image/webp"
                                        @change="handleImageChange"
                                    >

                                    <div class="form-text">
                                        JPG, JPEG, PNG or WEBP. Maximum 2 MB.
                                    </div>

                                    <div v-if="errors.company_logo" class="invalid-feedback">
                                        {{ errors.company_logo[0] }}
                                    </div>
                                </div>

                                <!-- Image Preview -->
                                <div v-if="imagePreview" class="mt-3">
                                    <label class="form-label d-block">
                                        Logo Preview
                                    </label>

                                    <div class="experience-logo-preview">
                                        <img
                                            :src="imagePreview"
                                            alt="Company logo preview"
                                            class="img-fluid rounded"
                                        >
                                    </div>
                                </div>

                                <!-- Sort Order -->
                                <div class="mt-3">
                                    <label class="form-label">
                                        Sort Order
                                    </label>

                                    <input
                                        v-model="form.sort_order"
                                        type="number"
                                        min="0"
                                        class="form-control"
                                        placeholder="0"
                                    >

                                    <div class="form-text">
                                        Lower numbers appear first.
                                    </div>
                                </div>

                                <!-- General Error -->
                                <div v-if="modalError" class="alert alert-danger mt-3 mb-0">
                                    {{ modalError }}
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    @click="closeModal"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    :disabled="saving"
                                >
                                    <span
                                        v-if="saving"
                                        class="spinner-border spinner-border-sm me-2"
                                    ></span>

                                    <i
                                        v-else
                                        :class="editMode ? 'bi bi-check-lg me-2' : 'bi bi-plus-lg me-2'"
                                    ></i>

                                    {{ saving ? 'Saving...' : editMode ? 'Update Experience' : 'Add Experience' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import AdminLayout from '../../layouts/AdminLayout.vue';
import axios from 'axios';
import { Modal } from 'bootstrap';

const experiences = ref([]);

const loading = ref(false);
const saving = ref(false);
const editMode = ref(false);

const successMessage = ref('');
const generalError = ref('');
const modalError = ref('');

const errors = ref({});

const selectedExperience = ref(null);
const imagePreview = ref('');
const fileInput = ref(null);

let modal = null;

const form = reactive({
    company: '',
    position: '',
    employment_type: '',
    location: '',
    start_date: '',
    end_date: '',
    currently_working: false,
    description: '',
    company_logo: null,
    sort_order: 0,
});

const resetForm = () => {
    form.company = '';
    form.position = '';
    form.employment_type = '';
    form.location = '';
    form.start_date = '';
    form.end_date = '';
    form.currently_working = false;
    form.description = '';
    form.company_logo = null;
    form.sort_order = 0;

    errors.value = {};
    modalError.value = '';
    imagePreview.value = '';

    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const loadExperiences = async () => {
    loading.value = true;
    generalError.value = '';

    try {
        const response = await axios.get('/admin/data/experiences');

        experiences.value = response.data.experiences;
    } catch (error) {
        generalError.value = 'Unable to load experiences.';
    } finally {
        loading.value = false;
    }
};

const openCreateModal = () => {
    editMode.value = false;
    selectedExperience.value = null;

    resetForm();

    if (modal) {
        modal.show();
    }
};

const openEditModal = (experience) => {
    editMode.value = true;
    selectedExperience.value = experience;

    form.company = experience.company || '';
    form.position = experience.position || '';
    form.employment_type = experience.employment_type || '';
    form.location = experience.location || '';
    form.start_date = formatInputDate(experience.start_date);
    form.end_date = formatInputDate(experience.end_date);
    form.currently_working = Boolean(experience.currently_working);
    form.description = experience.description || '';
    form.company_logo = null;
    form.sort_order = experience.sort_order ?? 0;

    errors.value = {};
    modalError.value = '';

    if (experience.company_logo) {
        imagePreview.value = getImageUrl(experience.company_logo);
    } else {
        imagePreview.value = '';
    }

    if (fileInput.value) {
        fileInput.value.value = '';
    }

    if (modal) {
        modal.show();
    }
};

const closeModal = () => {
    if (modal) {
        modal.hide();
    }
};

const handleImageChange = (event) => {
    const file = event.target.files[0];

    if (!file) {
        form.company_logo = null;
        return;
    }

    form.company_logo = file;

    const reader = new FileReader();

    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };

    reader.readAsDataURL(file);
};

const saveExperience = async () => {
    saving.value = true;
    errors.value = {};
    modalError.value = '';
    successMessage.value = '';

    const data = new FormData();

    data.append('company', form.company);
    data.append('position', form.position);
    data.append('employment_type', form.employment_type || '');
    data.append('location', form.location || '');
    data.append('start_date', form.start_date);
    data.append(
        'end_date',
        form.currently_working ? '' : form.end_date || ''
    );
    data.append(
        'currently_working',
        form.currently_working ? '1' : '0'
    );
    data.append('description', form.description || '');
    data.append('sort_order', form.sort_order ?? 0);

    if (form.company_logo) {
        data.append('company_logo', form.company_logo);
    }

    try {
        let response;

        if (editMode.value) {
            data.append('_method', 'PUT');

            response = await axios.post(
                `/admin/data/experiences/${selectedExperience.value.id}`,
                data,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }
            );
        } else {
            response = await axios.post(
                '/admin/data/experiences',
                data,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }
            );
        }

        successMessage.value = response.data.message;

        if (modal) {
            modal.hide();
        }

        await loadExperiences();

        resetForm();
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
            modalError.value = error.response.data.message || '';
        } else {
            modalError.value = 'Something went wrong. Please try again.';
        }
    } finally {
        saving.value = false;
    }
};

const deleteExperience = async (experience) => {
    const confirmed = window.confirm(
        `Are you sure you want to delete "${experience.position}" at "${experience.company}"?`
    );

    if (!confirmed) {
        return;
    }

    try {
        const response = await axios.delete(
            `/admin/data/experiences/${experience.id}`
        );

        successMessage.value = response.data.message;

        await loadExperiences();
    } catch (error) {
        generalError.value = 'Unable to delete experience.';
    }
};

const formatInputDate = (date) => {
    if (!date) {
        return '';
    }

    return date.substring(0, 10);
};

const formatDate = (date) => {
    if (!date) {
        return '';
    }

    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        year: 'numeric',
    });
};

const getImageUrl = (path) => {
    if (!path) {
        return '';
    }

    return `/${path}`;
};

onMounted(() => {
    const modalElement = document.getElementById('experienceModal');

    if (modalElement) {
        modal = new Modal(modalElement);
    }

    loadExperiences();
});
</script>

<style scoped>
.experience-logo {
    width: 70px;
    height: 70px;
    overflow: hidden;
}

.experience-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.experience-logo-preview {
    width: 120px;
    height: 120px;
    padding: 10px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: #f8f9fa;
}

.experience-logo-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
</style>