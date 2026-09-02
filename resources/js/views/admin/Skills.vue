<template>
    <AdminLayout>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Skills</h4>
                    <p class="text-muted mb-0">Manage your professional skills.</p>
                </div>

                <button class="btn btn-primary" @click="openCreateModal">
                    <i class="bi bi-plus-lg me-2"></i>
                    Add Skill
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
                <p class="text-muted mt-2 mb-0">Loading skills...</p>
            </div>

            <div v-else-if="skills.length === 0" class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-lightning-charge fs-1 text-muted"></i>
                    <h5 class="mt-3">No skills found</h5>
                    <p class="text-muted">Add your first skill to get started.</p>

                    <button class="btn btn-primary" @click="openCreateModal">
                        <i class="bi bi-plus-lg me-2"></i>
                        Add Skill
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
                                    <th>Skill</th>
                                    <th>Category</th>
                                    <th style="width: 250px;">Level</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(skill, index) in skills" :key="skill.id">
                                    <td class="ps-4">{{ index + 1 }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div v-if="skill.icon" class="me-3">
                                                <i :class="skill.icon" class="fs-4"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">{{ skill.name }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span v-if="skill.category" class="badge bg-light text-dark">
                                            {{ skill.category }}
                                        </span>
                                        <span v-else class="text-muted">—</span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div
                                                    class="progress-bar"
                                                    role="progressbar"
                                                    :style="{ width: skill.percentage + '%' }"
                                                    :aria-valuenow="skill.percentage"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                                ></div>
                                            </div>

                                            <span class="small fw-semibold">
                                                {{ skill.percentage }}%
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span
                                            class="badge"
                                            :class="skill.is_active ? 'bg-success' : 'bg-secondary'"
                                        >
                                            {{ skill.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td class="text-end pe-4">
                                        <button
                                            class="btn btn-sm btn-outline-primary me-2"
                                            @click="openEditModal(skill)"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="deleteSkill(skill)"
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

        <!-- Skill Modal -->
        <div
            class="modal fade"
            id="skillModal"
            tabindex="-1"
            aria-labelledby="skillModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="skillModalLabel" class="modal-title">
                            {{ editMode ? 'Edit Skill' : 'Add Skill' }}
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            @click="closeModal"
                        ></button>
                    </div>

                    <form @submit.prevent="saveSkill">
                        <div class="modal-body">
                            <div v-if="formError" class="alert alert-danger">
                                {{ formError }}
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Skill Name <span class="text-danger">*</span>
                                </label>

                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.name }"
                                    placeholder="e.g. Laravel"
                                >

                                <div v-if="errors.name" class="invalid-feedback">
                                    {{ errors.name[0] }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category</label>

                                <input
                                    v-model="form.category"
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.category }"
                                    placeholder="e.g. Backend"
                                >

                                <div v-if="errors.category" class="invalid-feedback">
                                    {{ errors.category[0] }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Skill Level
                                    <span class="text-muted">({{ form.percentage }}%)</span>
                                </label>

                                <input
                                    v-model.number="form.percentage"
                                    type="range"
                                    class="form-range"
                                    min="0"
                                    max="100"
                                    step="1"
                                >

                                <div class="d-flex justify-content-between text-muted small">
                                    <span>0%</span>
                                    <span>50%</span>
                                    <span>100%</span>
                                </div>

                                <div v-if="errors.percentage" class="text-danger small mt-1">
                                    {{ errors.percentage[0] }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Icon Class</label>

                                <input
                                    v-model="form.icon"
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.icon }"
                                    placeholder="e.g. bi bi-code-slash"
                                >

                                <div v-if="errors.icon" class="invalid-feedback">
                                    {{ errors.icon[0] }}
                                </div>

                                <small class="text-muted">
                                    You can use Bootstrap Icons classes.
                                </small>
                            </div>

                            <div class="mb-3">
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

                            <div class="form-check">
                                <input
                                    id="isActive"
                                    v-model="form.is_active"
                                    class="form-check-input"
                                    type="checkbox"
                                >

                                <label class="form-check-label" for="isActive">
                                    Active
                                </label>
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
                                    {{ editMode ? 'Update Skill' : 'Add Skill' }}
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

const skills = ref([]);
const loading = ref(false);
const saving = ref(false);
const editMode = ref(false);
const selectedSkill = ref(null);

const successMessage = ref('');
const errorMessage = ref('');
const formError = ref('');

let modal = null;

const form = reactive({
    name: '',
    category: '',
    percentage: 0,
    icon: '',
    is_active: true,
    sort_order: 0,
});

const errors = reactive({});

const resetErrors = () => {
    Object.keys(errors).forEach(key => delete errors[key]);
};

const resetForm = () => {
    form.name = '';
    form.category = '';
    form.percentage = 0;
    form.icon = '';
    form.is_active = true;
    form.sort_order = 0;

    resetErrors();
    formError.value = '';
};

const loadSkills = async () => {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await axios.get('/admin/data/skills');

        skills.value = response.data.skills || [];
    } catch (error) {
        console.error(error);

        errorMessage.value =
            error.response?.data?.message ||
            'Unable to load skills.';
    } finally {
        loading.value = false;
    }
};

const openCreateModal = () => {
    editMode.value = false;
    selectedSkill.value = null;

    resetForm();

    if (modal) {
        modal.show();
    }
};

const openEditModal = (skill) => {
    editMode.value = true;
    selectedSkill.value = skill;

    resetErrors();
    formError.value = '';

    form.name = skill.name || '';
    form.category = skill.category || '';
    form.percentage = skill.percentage ?? 0;
    form.icon = skill.icon || '';
    form.is_active = Boolean(skill.is_active);
    form.sort_order = skill.sort_order ?? 0;

    if (modal) {
        modal.show();
    }
};

const closeModal = () => {
    if (modal) {
        modal.hide();
    }
};

const saveSkill = async () => {
    saving.value = true;
    formError.value = '';
    successMessage.value = '';
    errorMessage.value = '';

    resetErrors();

    try {
        const data = {
            name: form.name,
            category: form.category,
            percentage: form.percentage,
            icon: form.icon,
            is_active: form.is_active,
            sort_order: form.sort_order,
        };

        let response;

        if (editMode.value && selectedSkill.value) {
            response = await axios.put(
                `/admin/data/skills/${selectedSkill.value.id}`,
                data
            );
        } else {
            response = await axios.post(
                '/admin/data/skills',
                data
            );
        }

        successMessage.value = response.data.message;

        closeModal();

        await loadSkills();
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

const deleteSkill = async (skill) => {
    const confirmed = window.confirm(
        `Are you sure you want to delete "${skill.name}"?`
    );

    if (!confirmed) {
        return;
    }

    successMessage.value = '';
    errorMessage.value = '';

    try {
        const response = await axios.delete(
            `/admin/data/skills/${skill.id}`
        );

        successMessage.value = response.data.message;

        await loadSkills();
    } catch (error) {
        console.error(error);

        errorMessage.value =
            error.response?.data?.message ||
            'Unable to delete skill.';
    }
};

onMounted(() => {
    const modalElement = document.getElementById('skillModal');

    if (modalElement) {
        modal = new Modal(modalElement);
    }

    loadSkills();
});
</script>