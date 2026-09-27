<template>
    <AdminLayout>
        <div class="page-header">
            <div>
                <h4>Social Media</h4>
                <p>Manage your social media profiles and links.</p>
            </div>
            <button class="btn btn-dark" @click="openCreateModal">
                <i class="bi bi-plus-lg me-2"></i>
                Add Social Media
            </button>
        </div>

        <div class="content-card">
            <div class="card-header-custom">
                <div>
                    <h6>Social Media Profiles</h6>
                    <span>Manage your social media links and icons</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Social Link</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="socialMedia.length === 0">
                            <td colspan="6" class="text-center py-5 text-muted">No social media found.</td>
                        </tr>

                        <tr v-for="item in socialMedia" :key="item.id">
                            <td>
                                <div class="social-icon">
                                    <div v-if="item.icon" v-html="item.icon"></div>
                                    <i v-else class="bi bi-share"></i>
                                </div>
                            </td>

                            <td>
                                <strong>{{ item.name }}</strong>
                            </td>

                            <td>
                                <a :href="item.link" target="_blank" rel="noopener noreferrer" class="social-link">
                                    {{ item.link }}
                                </a>
                            </td>

                            <td>
                                <span :class="statusClass(item.status)">
                                    {{ statusLabel(item.status) }}
                                </span>
                            </td>

                            <td>{{ item.sort_order }}</td>

                            <td class="text-end">
                                <button class="btn btn-sm btn-light me-1" @click="openEditModal(item)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-light text-danger" @click="deleteSocialMedia(item.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <div class="modal fade" id="socialMediaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ editingId ? 'Edit Social Media' : 'Add Social Media' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Social Media Name</label>
                            <input v-model="form.name" type="text" class="form-control" placeholder="Facebook">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Social Media Link</label>
                            <input v-model="form.link" type="url" class="form-control" placeholder="https://facebook.com/yourprofile">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SVG Icon Code</label>
                            <textarea v-model="form.icon" class="form-control svg-input" rows="7" placeholder="<svg viewBox=&quot;0 0 24 24&quot; ...></svg>"></textarea>
                            <small class="text-muted">Paste the complete SVG code here.</small>
                        </div>

                        <div v-if="form.icon" class="icon-preview mb-3">
                            <div class="preview-title">Icon Preview</div>
                            <div class="preview-icon" v-html="form.icon"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select v-model="form.status" class="form-select">
                                    <option value="a">Active</option>
                                    <option value="d">Draft</option>
                                    <option value="p">Pending</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input v-model.number="form.sort_order" type="number" min="0" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-dark" @click="saveSocialMedia" :disabled="saving">
                            {{ saving ? 'Saving...' : 'Save Social Media' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../layouts/AdminLayout.vue';
import { onMounted, reactive, ref } from 'vue';
import axios from 'axios';
import Modal from 'bootstrap/js/dist/modal';

const socialMedia = ref([]);
const editingId = ref(null);
const saving = ref(false);
let socialMediaModal = null;

const form = reactive({
    name: '',
    link: '',
    icon: '',
    status: 'a',
    sort_order: 0
});

const loadSocialMedia = () => {
    axios.get('/admin/data/social-media')
        .then(response => {
            socialMedia.value = response.data.social_media;
        })
        .catch(error => {
            console.error('Error loading social media:', error);
        });
};

const resetForm = () => {
    form.name = '';
    form.link = '';
    form.icon = '';
    form.status = 'a';
    form.sort_order = 0;
};

const openCreateModal = () => {
    editingId.value = null;
    resetForm();
    socialMediaModal = Modal.getOrCreateInstance(document.getElementById('socialMediaModal'));
    socialMediaModal.show();
};

const openEditModal = item => {
    editingId.value = item.id;
    form.name = item.name;
    form.link = item.link;
    form.icon = item.icon || '';
    form.status = item.status;
    form.sort_order = item.sort_order || 0;
    socialMediaModal = Modal.getOrCreateInstance(document.getElementById('socialMediaModal'));
    socialMediaModal.show();
};

const saveSocialMedia = () => {
    if (!form.name) {
        alert('Please enter social media name.');
        return;
    }

    if (!form.link) {
        alert('Please enter social media link.');
        return;
    }

    saving.value = true;

    const request = editingId.value
        ? axios.put(`/admin/data/social-media/${editingId.value}`, form)
        : axios.post('/admin/data/social-media', form);

    request
        .then(response => {
            alert(response.data.message);
            socialMediaModal.hide();
            loadSocialMedia();
        })
        .catch(error => {
            console.error('Error saving social media:', error);

            if (error.response?.data?.errors) {
                const errors = Object.values(error.response.data.errors).flat();
                alert(errors.join('\n'));
            } else if (error.response?.data?.message) {
                alert(error.response.data.message);
            }
        })
        .finally(() => {
            saving.value = false;
        });
};

const deleteSocialMedia = id => {
    if (!confirm('Are you sure you want to delete this social media?')) {
        return;
    }

    axios.delete(`/admin/data/social-media/${id}`)
        .then(response => {
            alert(response.data.message);
            loadSocialMedia();
        })
        .catch(error => {
            console.error('Error deleting social media:', error);
        });
};

const statusLabel = status => {
    if (status === 'a') return 'Active';
    if (status === 'd') return 'Draft';
    if (status === 'p') return 'Pending';
    return 'Unknown';
};

const statusClass = status => {
    if (status === 'a') return 'status-active';
    if (status === 'd') return 'status-draft';
    if (status === 'p') return 'status-pending';
    return 'status-draft';
};

onMounted(() => {
    loadSocialMedia();
});
</script>

<style scoped>
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 25px;
}

.page-header h4 {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
    color: #202733;
}

.page-header p {
    margin: 5px 0 0;
    font-size: 13px;
    color: #8991a0;
}

/* Card */
.content-card {
    background: #ffffff;
    border: 1px solid #e9edf3;
    border-radius: 12px;
    overflow: hidden;
}

.card-header-custom {
    padding: 20px;
    border-bottom: 1px solid #edf0f4;
}

.card-header-custom h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #252b36;
}

.card-header-custom span {
    display: block;
    margin-top: 3px;
    font-size: 11px;
    color: #9299a6;
}

/* Table */
.table thead th {
    background: #fafbfc;
    border-bottom: 1px solid #edf0f4;
    color: #9299a6;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
}

.table tbody td {
    border-color: #f0f2f5;
    color: #697386;
    font-size: 12px;
}

/* Social Icon */
.social-icon {
    width: 40px;
    height: 40px;
    border-radius: 9px;
    background: #f1f3f5;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.social-icon > div {
    width: 23px;
    height: 23px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.social-icon :deep(svg) {
    width: 23px;
    height: 23px;
    display: block;
}

.social-icon i {
    font-size: 18px;
    color: #495057;
}

/* Social Link */
.social-link {
    max-width: 300px;
    display: inline-block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #495057;
    text-decoration: none;
}

.social-link:hover {
    text-decoration: underline;
}

/* Status */
.status-active,
.status-draft,
.status-pending {
    display: inline-block;
    font-size: 10px;
    padding: 5px 9px;
    border-radius: 20px;
    font-weight: 600;
}

.status-active {
    background: #e9f7ef;
    color: #198754;
}

.status-draft {
    background: #f1f3f5;
    color: #6c757d;
}

.status-pending {
    background: #fff4e5;
    color: #fd7e14;
}

/* SVG Input */
.svg-input {
    font-family: monospace;
    font-size: 12px;
    line-height: 1.5;
}

/* SVG Preview */
.icon-preview {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 15px;
    background: #f8f9fa;
    border: 1px solid #edf0f4;
    border-radius: 9px;
}

.preview-title {
    font-size: 11px;
    color: #6c757d;
    font-weight: 600;
}

.preview-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-icon :deep(svg) {
    width: 36px;
    height: 36px;
    display: block;
}
</style>