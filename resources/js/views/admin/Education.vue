<template>
    <AdminLayout>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Education</h4>
                    <p class="text-muted mb-0">Manage your educational background.</p>
                </div>

                <button class="btn btn-primary" @click="openCreateModal">
                    <i class="bi bi-plus-lg me-2"></i>
                    Add Education
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
                <p class="text-muted mt-2 mb-0">Loading education...</p>
            </div>

            <div v-else-if="educations.length === 0" class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-mortarboard fs-1 text-muted"></i>
                    <h5 class="mt-3">No education found</h5>
                    <p class="text-muted">Add your first education record.</p>

                    <button class="btn btn-primary" @click="openCreateModal">
                        <i class="bi bi-plus-lg me-2"></i>
                        Add Education
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
                                    <th>Education</th>
                                    <th>Institution</th>
                                    <th>Duration</th>
                                    <th>Grade</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(education, index) in educations" :key="education.id">
                                    <td class="ps-4">{{ index + 1 }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="education-icon me-3">
                                                <i class="bi bi-mortarboard"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    {{ education.degree }}
                                                </div>

                                                <small
                                                    v-if="education.field_of_study"
                                                    class="text-muted"
                                                >
                                                    {{ education.field_of_study }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ education.institution }}
                                        </div>

                                        <small
                                            v-if="education.location"
                                            class="text-muted"
                                        >
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ education.location }}
                                        </small>
                                    </td>

                                    <td>
                                        <span v-if="education.currently_studying">
                                            {{ formatDate(education.start_date) }}
                                            -
                                            Present
                                        </span>

                                        <span v-else>
                                            {{ formatDate(education.start_date) }}
                                            -
                                            {{ formatDate(education.end_date) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span v-if="education.grade" class="badge bg-light text-dark">
                                            {{ education.grade }}
                                        </span>

                                        <span v-else class="text-muted">—</span>
                                    </td>

                                    <td class="text-end pe-4">
                                        <button
                                            class="btn btn-sm btn-outline-primary me-2"
                                            @click="openEditModal(education)"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="deleteEducation(education)"
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

        <!-- Education Modal -->
        <div
            class="modal fade"
            id="educationModal"
            tabindex="-1"
            aria-labelledby="educationModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="educationModalLabel" class="modal-title">
                            {{ editMode ? 'Edit Education' : 'Add Education' }}
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            @click="closeModal"
                        ></button>
                    </div>

                    <form @submit.prevent="saveEducation">
                        <div class="modal-body">
                            <div v-if="formError" class="alert alert-danger">
                                {{ formError }}
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Institution <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        v-model="form.institution"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.institution }"
                                        placeholder="e.g. Kakna High School"
                                    >

                                    <div v-if="errors.institution" class="invalid-feedback">
                                        {{ errors.institution[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Degree <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        v-model="form.degree"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.degree }"
                                        placeholder="e.g. SSC"
                                    >

                                    <div v-if="errors.degree" class="invalid-feedback">
                                        {{ errors.degree[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Field of Study</label>

                                    <input
                                        v-model="form.field_of_study"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.field_of_study }"
                                        placeholder="e.g. Science"
                                    >

                                    <div v-if="errors.field_of_study" class="invalid-feedback">
                                        {{ errors.field_of_study[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Location</label>

                                    <input
                                        v-model="form.location"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.location }"
                                        placeholder="e.g. Manikganj, Bangladesh"
                                    >

                                    <div v-if="errors.location" class="invalid-feedback">
                                        {{ errors.location[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Start Date</label>

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
                                    <label class="form-label">End Date</label>

                                    <input
                                        v-model="form.end_date"
                                        type="date"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.end_date }"
                                        :disabled="form.currently_studying"
                                    >

                                    <div v-if="errors.end_date" class="invalid-feedback">
                                        {{ errors.end_date[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Grade / Result</label>

                                    <input
                                        v-model="form.grade"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.grade }"
                                        placeholder="e.g. GPA 5.00"
                                    >

                                    <div v-if="errors.grade" class="invalid-feedback">
                                        {{ errors.grade[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3 d-flex align-items-center">
                                    <div class="form-check mt-3">
                                        <input
                                            id="currentlyStudying"
                                            v-model="form.currently_studying"
                                            class="form-check-input"
                                            type="checkbox"
                                        >

                                        <label
                                            class="form-check-label"
                                            for="currentlyStudying"
                                        >
                                            Currently Studying
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Description</label>

                                    <textarea
                                        v-model="form.description"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.description }"
                                        rows="4"
                                        placeholder="Write a short description about your education..."
                                    ></textarea>

                                    <div v-if="errors.description" class="invalid-feedback">
                                        {{ errors.description[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sort Order</label>

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
                                    {{ editMode ? 'Update Education' : 'Add Education' }}
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

const educations = ref([]);
const loading = ref(false);
const saving = ref(false);
const editMode = ref(false);
const selectedEducation = ref(null);

const successMessage = ref('');
const errorMessage = ref('');
const formError = ref('');

let modal = null;

const form = reactive({
    institution: '',
    degree: '',
    field_of_study: '',
    location: '',
    start_date: '',
    end_date: '',
    currently_studying: false,
    grade: '',
    description: '',
    sort_order: 0,
});

const errors = reactive({});

const resetErrors = () => {
    Object.keys(errors).forEach(key => delete errors[key]);
};

const resetForm = () => {
    form.institution = '';
    form.degree = '';
    form.field_of_study = '';
    form.location = '';
    form.start_date = '';
    form.end_date = '';
    form.currently_studying = false;
    form.grade = '';
    form.description = '';
    form.sort_order = 0;

    resetErrors();
    formError.value = '';
};

const loadEducations = async () => {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axios.get('/admin/data/educations');

        educations.value = response.data.educations || [];
    } catch (error) {
        console.error(error);

        errorMessage.value =
            error.response?.data?.message ||
            'Unable to load education.';
    } finally {
        loading.value = false;
    }
};

const openCreateModal = () => {
    editMode.value = false;
    selectedEducation.value = null;

    resetForm();

    if (modal) {
        modal.show();
    }
};

const openEditModal = (education) => {
    editMode.value = true;
    selectedEducation.value = education;

    resetErrors();
    formError.value = '';

    form.institution = education.institution || '';
    form.degree = education.degree || '';
    form.field_of_study = education.field_of_study || '';
    form.location = education.location || '';
    form.start_date = education.start_date
        ? education.start_date.substring(0, 10)
        : '';
    form.end_date = education.end_date
        ? education.end_date.substring(0, 10)
        : '';
    form.currently_studying = Boolean(education.currently_studying);
    form.grade = education.grade || '';
    form.description = education.description || '';
    form.sort_order = education.sort_order ?? 0;

    if (modal) {
        modal.show();
    }
};

const closeModal = () => {
    if (modal) {
        modal.hide();
    }
};

const saveEducation = async () => {
    saving.value = true;
    formError.value = '';
    successMessage.value = '';
    errorMessage.value = '';

    resetErrors();

    try {
        const data = {
            institution: form.institution,
            degree: form.degree,
            field_of_study: form.field_of_study,
            location: form.location,
            start_date: form.start_date || null,
            end_date: form.currently_studying
                ? null
                : (form.end_date || null),
            currently_studying: form.currently_studying,
            grade: form.grade,
            description: form.description,
            sort_order: form.sort_order,
        };

        let response;

        if (editMode.value && selectedEducation.value) {
            response = await axios.put(
                `/admin/data/educations/${selectedEducation.value.id}`,
                data
            );
        } else {
            response = await axios.post(
                '/admin/data/educations',
                data
            );
        }

        successMessage.value = response.data.message;

        closeModal();

        await loadEducations();
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

const deleteEducation = async (education) => {
    const confirmed = window.confirm(
        `Are you sure you want to delete "${education.degree}" from "${education.institution}"?`
    );

    if (!confirmed) {
        return;
    }

    successMessage.value = '';
    errorMessage.value = '';

    try {
        const response = await axios.delete(
            `/admin/data/educations/${education.id}`
        );

        successMessage.value = response.data.message;

        await loadEducations();
    } catch (error) {
        console.error(error);

        errorMessage.value =
            error.response?.data?.message ||
            'Unable to delete education.';
    }
};

const formatDate = (date) => {
    if (!date) {
        return '—';
    }

    const parsedDate = new Date(date);

    return parsedDate.toLocaleDateString('en-US', {
        month: 'short',
        year: 'numeric',
    });
};

onMounted(() => {
    const modalElement = document.getElementById('educationModal');

    if (modalElement) {
        modal = new Modal(modalElement);
    }

    loadEducations();
});
</script>

<style scoped>
.education-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: var(--bs-light);
    color: var(--bs-primary);
    font-size: 20px;
}
</style>