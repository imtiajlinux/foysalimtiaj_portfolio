<template>
    <AdminLayout>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Projects</h4>
                    <p class="text-muted mb-0">Manage your portfolio projects.</p>
                </div>

                <button class="btn btn-primary" @click="openCreateModal">
                    <i class="bi bi-plus-lg me-2"></i>
                    Add Project
                </button>
            </div>

            <div v-if="successMessage" class="alert alert-success alert-dismissible fade show">
                {{ successMessage }}
                <button type="button" class="btn-close" @click="successMessage = ''"></button>
            </div>

            <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show">
                {{ errorMessage }}
                <button type="button" class="btn-close" @click="errorMessage = ''"></button>
            </div>

            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary"></div>
                <p class="text-muted mt-2 mb-0">Loading projects...</p>
            </div>

            <div v-else-if="projects.length === 0" class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-folder2-open fs-1 text-muted"></i>

                    <h5 class="mt-3">No projects found</h5>

                    <p class="text-muted">
                        Add your first portfolio project.
                    </p>

                    <button class="btn btn-primary" @click="openCreateModal">
                        <i class="bi bi-plus-lg me-2"></i>
                        Add Project
                    </button>
                </div>
            </div>

            <div v-else class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Project</th>
                                    <th>Category</th>
                                    <th>Technologies</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(project, index) in projects" :key="project.id">
                                    <td class="ps-4">
                                        {{ index + 1 }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="project-image me-3">
                                                <img
                                                    v-if="project.image"
                                                    :src="getImageUrl(project.image)"
                                                    :alt="project.title"
                                                >

                                                <i
                                                    v-else
                                                    class="bi bi-folder2-open"
                                                ></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    {{ project.title }}
                                                </div>

                                                <small
                                                    v-if="project.short_description"
                                                    class="text-muted"
                                                >
                                                    {{ truncate(project.short_description, 60) }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span
                                            v-if="project.category"
                                            class="badge bg-light text-dark"
                                        >
                                            {{ project.category }}
                                        </span>

                                        <span v-else class="text-muted">
                                            —
                                        </span>
                                    </td>

                                    <td>
                                        <div
                                            v-if="project.technologies"
                                            class="technology-list"
                                        >
                                            <span
                                                v-for="technology in parseTechnologies(project.technologies).slice(0, 3)"
                                                :key="technology"
                                                class="badge bg-light text-dark me-1 mb-1"
                                            >
                                                {{ technology }}
                                            </span>

                                            <span
                                                v-if="parseTechnologies(project.technologies).length > 3"
                                                class="text-muted small"
                                            >
                                                +{{ parseTechnologies(project.technologies).length - 3 }}
                                            </span>
                                        </div>

                                        <span v-else class="text-muted">
                                            —
                                        </span>
                                    </td>

                                    <td>
                                        <span
                                            class="badge"
                                            :class="project.is_active ? 'bg-success' : 'bg-secondary'"
                                        >
                                            {{ project.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span
                                            v-if="project.is_featured"
                                            class="badge bg-warning text-dark"
                                        >
                                            <i class="bi bi-star-fill me-1"></i>
                                            Featured
                                        </span>

                                        <span v-else class="text-muted">
                                            —
                                        </span>
                                    </td>

                                    <td class="text-end pe-4">
                                        <button
                                            class="btn btn-sm btn-outline-primary me-2"
                                            @click="openEditModal(project)"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="deleteProject(project)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Modal -->
        <div
            class="modal fade"
            id="projectModal"
            tabindex="-1"
            aria-labelledby="projectModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="projectModalLabel" class="modal-title">
                            {{ editMode ? 'Edit Project' : 'Add Project' }}
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            @click="closeModal"
                        ></button>
                    </div>

                    <form @submit.prevent="saveProject">
                        <div class="modal-body">
                            <div v-if="formError" class="alert alert-danger">
                                {{ formError }}
                            </div>

                            <div class="row">
                                <!-- Title -->
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">
                                        Project Title
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        v-model="form.title"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.title }"
                                        placeholder="e.g. Portfolio Website"
                                    >

                                    <div v-if="errors.title" class="invalid-feedback">
                                        {{ errors.title[0] }}
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Category</label>

                                    <input
                                        v-model="form.category"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.category }"
                                        placeholder="e.g. Web Application"
                                    >

                                    <div v-if="errors.category" class="invalid-feedback">
                                        {{ errors.category[0] }}
                                    </div>
                                </div>

                                <!-- Short Description -->
                                <div class="col-12 mb-3">
                                    <label class="form-label">
                                        Short Description
                                    </label>

                                    <textarea
                                        v-model="form.short_description"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.short_description }"
                                        rows="2"
                                        placeholder="Write a short description of the project..."
                                    ></textarea>

                                    <div v-if="errors.short_description" class="invalid-feedback">
                                        {{ errors.short_description[0] }}
                                    </div>
                                </div>

                                <!-- Technologies -->
                                <div class="col-12 mb-3">
                                    <label class="form-label">
                                        Technologies
                                    </label>

                                    <input
                                        v-model="form.technologies"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.technologies }"
                                        placeholder="Laravel, Vue.js, MySQL, Bootstrap"
                                    >

                                    <small class="text-muted">
                                        Separate technologies using commas.
                                    </small>

                                    <div v-if="errors.technologies" class="invalid-feedback">
                                        {{ errors.technologies[0] }}
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12 mb-3">
                                    <label class="form-label">
                                        Project Description
                                    </label>

                                    <textarea
                                        v-model="form.description"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.description }"
                                        rows="5"
                                        placeholder="Describe the project in detail..."
                                    ></textarea>

                                    <div v-if="errors.description" class="invalid-feedback">
                                        {{ errors.description[0] }}
                                    </div>
                                </div>

                                <!-- Project URL -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Live Project URL
                                    </label>

                                    <input
                                        v-model="form.project_url"
                                        type="url"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.project_url }"
                                        placeholder="https://example.com"
                                    >

                                    <div v-if="errors.project_url" class="invalid-feedback">
                                        {{ errors.project_url[0] }}
                                    </div>
                                </div>

                                <!-- GitHub URL -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        GitHub URL
                                    </label>

                                    <input
                                        v-model="form.github_url"
                                        type="url"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.github_url }"
                                        placeholder="https://github.com/username/project"
                                    >

                                    <div v-if="errors.github_url" class="invalid-feedback">
                                        {{ errors.github_url[0] }}
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">
                                        Project Image
                                    </label>

                                    <input
                                        ref="imageInput"
                                        type="file"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.image }"
                                        accept="image/jpeg,image/png,image/webp"
                                        @change="handleImageChange"
                                    >

                                    <small class="text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum 4 MB.
                                    </small>

                                    <div v-if="errors.image" class="text-danger small mt-1">
                                        {{ errors.image[0] }}
                                    </div>
                                </div>

                                <!-- Image Preview -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Preview
                                    </label>

                                    <div class="project-preview">
                                        <img
                                            v-if="imagePreview"
                                            :src="imagePreview"
                                            alt="Project preview"
                                        >

                                        <div v-else class="text-muted text-center">
                                            <i class="bi bi-image fs-2"></i>
                                            <div class="small mt-1">
                                                No image selected
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sort Order -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Sort Order
                                    </label>

                                    <input
                                        v-model.number="form.sort_order"
                                        type="number"
                                        min="0"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.sort_order }"
                                    >

                                    <div v-if="errors.sort_order" class="invalid-feedback">
                                        {{ errors.sort_order[0] }}
                                    </div>
                                </div>

                                <!-- Featured -->
                                <div class="col-md-4 mb-3 d-flex align-items-center">
                                    <div class="form-check mt-4">
                                        <input
                                            id="isFeatured"
                                            v-model="form.is_featured"
                                            class="form-check-input"
                                            type="checkbox"
                                        >

                                        <label
                                            class="form-check-label"
                                            for="isFeatured"
                                        >
                                            Featured Project
                                        </label>
                                    </div>
                                </div>

                                <!-- Active -->
                                <div class="col-md-4 mb-3 d-flex align-items-center">
                                    <div class="form-check mt-4">
                                        <input
                                            id="isActive"
                                            v-model="form.is_active"
                                            class="form-check-input"
                                            type="checkbox"
                                        >

                                        <label
                                            class="form-check-label"
                                            for="isActive"
                                        >
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="closeModal"
                                :disabled="saving"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="saving"
                            >
                                <span v-if="saving">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Saving...
                                </span>

                                <span v-else>
                                    <i class="bi bi-check-lg me-2"></i>
                                    {{ editMode ? 'Update Project' : 'Add Project' }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import axios from 'axios';
import { Modal } from 'bootstrap';
import AdminLayout from '../../layouts/AdminLayout.vue';

const projects = ref([]);
const loading = ref(false);
const saving = ref(false);
const editMode = ref(false);
const selectedProject = ref(null);

const successMessage = ref('');
const errorMessage = ref('');
const formError = ref('');

const imageInput = ref(null);
const imagePreview = ref('');

let modal = null;

const form = reactive({
    title: '',
    category: '',
    short_description: '',
    description: '',
    technologies: '',
    project_url: '',
    github_url: '',
    image: null,
    is_featured: false,
    is_active: true,
    sort_order: 0,
});

const errors = reactive({});

const resetErrors = () => {
    Object.keys(errors).forEach(key => delete errors[key]);
};

const resetForm = () => {
    form.title = '';
    form.category = '';
    form.short_description = '';
    form.description = '';
    form.technologies = '';
    form.project_url = '';
    form.github_url = '';
    form.image = null;
    form.is_featured = false;
    form.is_active = true;
    form.sort_order = 0;

    imagePreview.value = '';

    if (imageInput.value) {
        imageInput.value.value = '';
    }

    resetErrors();
    formError.value = '';
};

const loadProjects = async () => {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axios.get('/admin/data/projects');

        projects.value = response.data.projects || [];
    } catch (error) {
        console.error(error);

        errorMessage.value =
            error.response?.data?.message ||
            'Unable to load projects.';
    } finally {
        loading.value = false;
    }
};

const getImageUrl = (path) => {
    if (!path) {
        return '';
    }

    return `/${path}`;
};

const truncate = (text, length = 60) => {
    if (!text) {
        return '';
    }

    return text.length > length
        ? `${text.substring(0, length)}...`
        : text;
};

const parseTechnologies = (technologies) => {
    if (!technologies) {
        return [];
    }

    return technologies
        .split(',')
        .map(item => item.trim())
        .filter(item => item !== '');
};

const handleImageChange = (event) => {
    const file = event.target.files[0];

    if (!file) {
        form.image = null;
        return;
    }

    form.image = file;

    imagePreview.value = URL.createObjectURL(file);
};

const openCreateModal = () => {
    editMode.value = false;
    selectedProject.value = null;

    resetForm();

    if (modal) {
        modal.show();
    }
};

const openEditModal = (project) => {
    editMode.value = true;
    selectedProject.value = project;

    resetErrors();
    formError.value = '';

    form.title = project.title || '';
    form.category = project.category || '';
    form.short_description = project.short_description || '';
    form.description = project.description || '';
    form.technologies = project.technologies || '';
    form.project_url = project.project_url || '';
    form.github_url = project.github_url || '';
    form.image = null;
    form.is_featured = Boolean(project.is_featured);
    form.is_active = Boolean(project.is_active);
    form.sort_order = project.sort_order ?? 0;

    imagePreview.value = project.image
        ? getImageUrl(project.image)
        : '';

    if (imageInput.value) {
        imageInput.value.value = '';
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

const saveProject = async () => {
    saving.value = true;
    formError.value = '';
    successMessage.value = '';
    errorMessage.value = '';

    resetErrors();

    try {
        const formData = new FormData();

        formData.append('title', form.title);
        formData.append('category', form.category);
        formData.append('short_description', form.short_description);
        formData.append('description', form.description);
        formData.append('technologies', form.technologies);
        formData.append('project_url', form.project_url);
        formData.append('github_url', form.github_url);
        formData.append('is_featured', form.is_featured ? '1' : '0');
        formData.append('is_active', form.is_active ? '1' : '0');
        formData.append('sort_order', form.sort_order);

        if (form.image) {
            formData.append('image', form.image);
        }

        let response;

        if (editMode.value && selectedProject.value) {
            formData.append('_method', 'PUT');

            response = await axios.post(
                `/admin/data/projects/${selectedProject.value.id}`,
                formData
            );
        } else {
            response = await axios.post(
                '/admin/data/projects',
                formData
            );
        }

        successMessage.value = response.data.message;

        closeModal();

        await loadProjects();
    } catch (error) {
        console.error(error);

        if (error.response?.status === 422) {
            const validationErrors = error.response.data.errors || {};

            Object.assign(errors, validationErrors);

            formError.value =
                error.response.data.message ||
                'Please correct the errors below.';
        } else {
            formError.value =
                error.response?.data?.message ||
                'Something went wrong.';
        }
    } finally {
        saving.value = false;
    }
};

const deleteProject = async (project) => {
    const confirmed = window.confirm(
        `Are you sure you want to delete "${project.title}"?`
    );

    if (!confirmed) {
        return;
    }

    successMessage.value = '';
    errorMessage.value = '';

    try {
        const response = await axios.delete(
            `/admin/data/projects/${project.id}`
        );

        successMessage.value = response.data.message;

        await loadProjects();
    } catch (error) {
        console.error(error);

        errorMessage.value =
            error.response?.data?.message ||
            'Unable to delete project.';
    }
};

onMounted(() => {
    const modalElement = document.getElementById('projectModal');

    if (modalElement) {
        modal = new Modal(modalElement);
    }

    loadProjects();
});
</script>

<style scoped>
.project-image {
    width: 55px;
    height: 45px;
    border-radius: 6px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bs-light);
    color: var(--bs-primary);
    flex-shrink: 0;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.project-preview {
    width: 100%;
    height: 120px;
    border: 1px dashed var(--bs-border-color);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: var(--bs-light);
}

.project-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>