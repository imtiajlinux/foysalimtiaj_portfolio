<template>
    <AdminLayout>
        <div class="page-header">
            <div>
                <h4>Gallery</h4>
                <p>Manage gallery categories and images.</p>
            </div>

            <div class="header-actions">
                <button class="btn btn-outline-dark" @click="openCategoryModal()">
                    <i class="bi bi-folder-plus me-2"></i>
                    Category
                </button>

                <button class="btn btn-dark" @click="openUploadModal">
                    <i class="bi bi-images me-2"></i>
                    Add Images
                </button>
            </div>
        </div>

        <!-- Categories -->
        <div class="content-card mb-4">
            <div class="card-header-custom">
                <div>
                    <h6>Gallery Categories</h6>
                    <small>Organize your gallery images.</small>
                </div>

                <button class="btn btn-sm btn-dark" @click="openCategoryModal()">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add Category
                </button>
            </div>

            <div class="category-list">
                <button
                    class="category-item"
                    :class="{ active: selectedCategory === '' }"
                    @click="selectCategory('')"
                >
                    <span>
                        <i class="bi bi-grid me-2"></i>
                        All Images
                    </span>
                    <strong>{{ totalImages }}</strong>
                </button>

                <button
                    v-for="category in categories"
                    :key="category.id"
                    class="category-item"
                    :class="{ active: selectedCategory == category.id }"
                    @click="selectCategory(category.id)"
                >
                    <span>
                        <i class="bi bi-folder me-2"></i>
                        {{ category.name }}
                    </span>

                    <span class="category-right">
                        <strong>{{ category.images_count }}</strong>

                        <span
                            class="category-actions"
                            @click.stop
                        >
                            <button
                                class="btn btn-sm btn-light"
                                @click="openCategoryModal(category)"
                            >
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button
                                class="btn btn-sm btn-light text-danger"
                                @click="deleteCategory(category)"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </span>
                    </span>
                </button>
            </div>
        </div>

        <!-- Gallery Images -->
        <div class="content-card">
            <div class="card-header-custom">
                <div>
                    <h6>
                        {{ selectedCategoryName || 'All Images' }}
                    </h6>
                    <small>
                        {{ filteredImages.length }} image(s)
                    </small>
                </div>
            </div>

            <div class="row g-4 p-3">
                <div
                    v-for="image in filteredImages"
                    :key="image.id"
                    class="col-xl-3 col-lg-4 col-md-6"
                >
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img
                                :src="getImageUrl(image.image)"
                                :alt="image.title"
                            >

                            <span class="priority-badge">
                                #{{ image.priority }}
                            </span>

                            <span
                                class="status-badge"
                                :class="image.is_active ? 'active' : 'inactive'"
                            >
                                {{ image.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="gallery-content">
                            <div class="image-category">
                                {{ image.category?.name }}
                            </div>

                            <h6>{{ image.title }}</h6>

                            <p v-if="image.short_description">
                                {{ image.short_description }}
                            </p>

                            <div class="image-actions">
                                <button
                                    class="btn btn-sm btn-light"
                                    @click="openEditModal(image)"
                                >
                                    <i class="bi bi-pencil me-1"></i>
                                    Edit
                                </button>

                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    @click="deleteImage(image)"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="!loading && filteredImages.length === 0"
                    class="col-12"
                >
                    <div class="empty-state">
                        <i class="bi bi-images"></i>
                        <h5>No Images Found</h5>
                        <p>There are no images in this category.</p>

                        <button
                            class="btn btn-dark"
                            @click="openUploadModal"
                        >
                            Add Images
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Modal -->
        <div
            class="modal fade"
            id="categoryModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ categoryForm.id ? 'Edit Category' : 'Add Category' }}
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <form @submit.prevent="saveCategory">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>

                                <input
                                    v-model="categoryForm.name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Example: Wedding"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>

                                <textarea
                                    v-model="categoryForm.description"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Category description"
                                ></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>

                                <input
                                    v-model.number="categoryForm.sort_order"
                                    type="number"
                                    min="0"
                                    class="form-control"
                                >
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="btn btn-dark"
                                :disabled="savingCategory"
                            >
                                {{ savingCategory ? 'Saving...' : 'Save Category' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Upload Images Modal -->
        <div
            class="modal fade"
            id="uploadModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Add Gallery Images
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <form @submit.prevent="uploadImages">
                        <div class="modal-body">
                            <div class="mb-4">
                                <label class="form-label">
                                    Select Images
                                </label>

                                <input
                                    ref="uploadInput"
                                    type="file"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    multiple
                                    @change="handleFiles"
                                    required
                                >

                                <small class="text-muted">
                                    JPG, JPEG, PNG, WEBP. Maximum 5 MB per image.
                                </small>
                            </div>

                            <div
                                v-if="uploadItems.length"
                                class="upload-items"
                            >
                                <div
                                    v-for="(item, index) in uploadItems"
                                    :key="index"
                                    class="upload-item"
                                >
                                    <div class="upload-preview">
                                        <img :src="item.preview" :alt="item.file.name">
                                    </div>

                                    <div class="upload-form">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">
                                                    Category
                                                </label>

                                                <select
                                                    v-model="item.gallery_category_id"
                                                    class="form-select"
                                                    required
                                                >
                                                    <option value="" disabled>
                                                        Select Category
                                                    </option>

                                                    <option
                                                        v-for="category in categories"
                                                        :key="category.id"
                                                        :value="category.id"
                                                    >
                                                        {{ category.name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">
                                                    Title
                                                </label>

                                                <input
                                                    v-model="item.title"
                                                    type="text"
                                                    class="form-control"
                                                    required
                                                >
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label">
                                                    Short Description
                                                </label>

                                                <input
                                                    v-model="item.short_description"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Short description"
                                                >
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label">
                                                    Long Description
                                                </label>

                                                <textarea
                                                    v-model="item.long_description"
                                                    class="form-control"
                                                    rows="3"
                                                    placeholder="Long description"
                                                ></textarea>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">
                                                    Priority
                                                </label>

                                                <input
                                                    v-model.number="item.priority"
                                                    type="number"
                                                    min="0"
                                                    class="form-control"
                                                >

                                                <small class="text-muted">
                                                    Lower number appears first.
                                                </small>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label d-block">
                                                    Status
                                                </label>

                                                <div class="form-check form-switch mt-2">
                                                    <input
                                                        v-model="item.is_active"
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    >

                                                    <label class="form-check-label">
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                v-else
                                class="select-image-box"
                            >
                                <i class="bi bi-cloud-arrow-up"></i>
                                <p>Select one or more images to continue.</p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="btn btn-dark"
                                :disabled="saving || !uploadItems.length"
                            >
                                {{ saving ? 'Uploading...' : 'Upload Images' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Image Modal -->
        <div
            class="modal fade"
            id="editImageModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Edit Gallery Image
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <form @submit.prevent="updateImage">
                        <div class="modal-body">
                            <div
                                v-if="editForm.currentImage"
                                class="edit-preview mb-4"
                            >
                                <img
                                    :src="getImageUrl(editForm.currentImage)"
                                    :alt="editForm.title"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Replace Image
                                </label>

                                <input
                                    ref="editInput"
                                    type="file"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    @change="handleEditFile"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Category
                                </label>

                                <select
                                    v-model="editForm.gallery_category_id"
                                    class="form-select"
                                    required
                                >
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Title
                                </label>

                                <input
                                    v-model="editForm.title"
                                    type="text"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Short Description
                                </label>

                                <input
                                    v-model="editForm.short_description"
                                    type="text"
                                    class="form-control"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Long Description
                                </label>

                                <textarea
                                    v-model="editForm.long_description"
                                    class="form-control"
                                    rows="5"
                                ></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Priority
                                    </label>

                                    <input
                                        v-model.number="editForm.priority"
                                        type="number"
                                        min="0"
                                        class="form-control"
                                    >
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label d-block">
                                        Status
                                    </label>

                                    <div class="form-check form-switch mt-2">
                                        <input
                                            v-model="editForm.is_active"
                                            class="form-check-input"
                                            type="checkbox"
                                        >

                                        <label class="form-check-label">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="btn btn-dark"
                                :disabled="saving"
                            >
                                {{ saving ? 'Updating...' : 'Update Image' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import axios from 'axios';
import AdminLayout from '../../layouts/AdminLayout.vue';
import Modal from 'bootstrap/js/dist/modal';

const categories = ref([]);
const images = ref([]);
const selectedCategory = ref('');
const loading = ref(false);
const saving = ref(false);
const savingCategory = ref(false);

const uploadInput = ref(null);
const editInput = ref(null);

const uploadItems = ref([]);

let categoryModal = null;
let uploadModal = null;
let editImageModal = null;

const categoryForm = reactive({
    id: null,
    name: '',
    description: '',
    sort_order: 0,
});

const editForm = reactive({
    id: null,
    gallery_category_id: '',
    title: '',
    short_description: '',
    long_description: '',
    priority: 0,
    is_active: true,
    currentImage: '',
    file: null,
});


const totalImages = computed(() => images.value.length);


const filteredImages = computed(() => {
    if (!selectedCategory.value) {
        return images.value;
    }

    return images.value.filter(
        image =>
            Number(image.gallery_category_id) ===
            Number(selectedCategory.value)
    );
});


const selectedCategoryName = computed(() => {
    if (!selectedCategory.value) {
        return '';
    }

    const category = categories.value.find(
        item => Number(item.id) === Number(selectedCategory.value)
    );

    return category?.name || '';
});


const getImageUrl = image => {
    return `/uploads/gallery/${image}`;
};


const loadCategories = async () => {
    try {
        const response = await axios.get(
            '/admin/data/gallery/categories'
        );

        categories.value = response.data.categories;
    } catch (error) {
        console.error('Category loading error:', error);
    }
};


const loadImages = async () => {
    loading.value = true;

    try {
        const response = await axios.get(
            '/admin/data/gallery/images'
        );

        images.value = response.data.images;
    } catch (error) {
        console.error('Gallery loading error:', error);
    } finally {
        loading.value = false;
    }
};


const loadData = async () => {
    await Promise.all([
        loadCategories(),
        loadImages(),
    ]);
};


const selectCategory = categoryId => {
    selectedCategory.value = categoryId;
};


const resetCategoryForm = () => {
    categoryForm.id = null;
    categoryForm.name = '';
    categoryForm.description = '';
    categoryForm.sort_order = 0;
};


const openCategoryModal = category => {
    resetCategoryForm();

    if (category) {
        categoryForm.id = category.id;
        categoryForm.name = category.name;
        categoryForm.description = category.description || '';
        categoryForm.sort_order = category.sort_order;
    }

    categoryModal.show();
};


const saveCategory = async () => {
    savingCategory.value = true;

    try {
        if (categoryForm.id) {
            await axios.put(
                `/admin/data/gallery/categories/${categoryForm.id}`,
                {
                    name: categoryForm.name,
                    description: categoryForm.description,
                    sort_order: categoryForm.sort_order,
                }
            );
        } else {
            await axios.post(
                '/admin/data/gallery/categories',
                {
                    name: categoryForm.name,
                    description: categoryForm.description,
                    sort_order: categoryForm.sort_order,
                }
            );
        }

        categoryModal.hide();

        await loadData();

    } catch (error) {
        console.error('Category save error:', error);

        alert(
            error.response?.data?.message ||
            'Unable to save category.'
        );
    } finally {
        savingCategory.value = false;
    }
};


const deleteCategory = async category => {
    if (category.images_count > 0) {
        alert(
            'This category contains images. Delete or move the images first.'
        );
        return;
    }

    if (!confirm(`Delete "${category.name}"?`)) {
        return;
    }

    try {
        await axios.delete(
            `/admin/data/gallery/categories/${category.id}`
        );

        await loadData();

    } catch (error) {
        alert(
            error.response?.data?.message ||
            'Unable to delete category.'
        );
    }
};


const openUploadModal = () => {
    uploadItems.value = [];

    if (uploadInput.value) {
        uploadInput.value.value = '';
    }

    uploadModal.show();
};


const handleFiles = event => {
    const files = Array.from(event.target.files);

    uploadItems.value = files.map((file, index) => ({
        file,
        preview: URL.createObjectURL(file),
        gallery_category_id: selectedCategory.value || (
            categories.value[0]?.id || ''
        ),
        title: file.name.replace(/\.[^/.]+$/, ''),
        short_description: '',
        long_description: '',
        priority: index,
        is_active: true,
    }));
};


const uploadImages = async () => {
    if (!uploadItems.value.length) {
        return;
    }

    saving.value = true;

    try {
        const formData = new FormData();

        uploadItems.value.forEach((item, index) => {
            formData.append(
                `items[${index}][gallery_category_id]`,
                item.gallery_category_id
            );

            formData.append(
                `items[${index}][image]`,
                item.file
            );

            formData.append(
                `items[${index}][title]`,
                item.title
            );

            formData.append(
                `items[${index}][short_description]`,
                item.short_description
            );

            formData.append(
                `items[${index}][long_description]`,
                item.long_description
            );

            formData.append(
                `items[${index}][priority]`,
                item.priority
            );

            formData.append(
                `items[${index}][is_active]`,
                item.is_active ? '1' : '0'
            );
        });

        await axios.post(
            '/admin/data/gallery/images',
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }
        );

        uploadModal.hide();

        await loadData();

        uploadItems.value = [];

    } catch (error) {
        console.error('Upload error:', error);

        alert(
            error.response?.data?.message ||
            'Unable to upload images.'
        );
    } finally {
        saving.value = false;
    }
};


const openEditModal = image => {
    editForm.id = image.id;
    editForm.gallery_category_id = image.gallery_category_id;
    editForm.title = image.title;
    editForm.short_description = image.short_description || '';
    editForm.long_description = image.long_description || '';
    editForm.priority = image.priority;
    editForm.is_active = image.is_active;
    editForm.currentImage = image.image;
    editForm.file = null;

    if (editInput.value) {
        editInput.value.value = '';
    }

    editImageModal.show();
};


const handleEditFile = event => {
    editForm.file = event.target.files[0] || null;
};


const updateImage = async () => {
    saving.value = true;

    try {
        const formData = new FormData();

        formData.append(
            'gallery_category_id',
            editForm.gallery_category_id
        );

        formData.append(
            'title',
            editForm.title
        );

        formData.append(
            'short_description',
            editForm.short_description
        );

        formData.append(
            'long_description',
            editForm.long_description
        );

        formData.append(
            'priority',
            editForm.priority
        );

        formData.append(
            'is_active',
            editForm.is_active ? '1' : '0'
        );

        if (editForm.file) {
            formData.append(
                'image',
                editForm.file
            );
        }

        await axios.post(
            `/admin/data/gallery/images/${editForm.id}`,
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }
        );

        editImageModal.hide();

        await loadData();

    } catch (error) {
        console.error('Image update error:', error);

        alert(
            error.response?.data?.message ||
            'Unable to update image.'
        );
    } finally {
        saving.value = false;
    }
};


const deleteImage = async image => {
    if (!confirm(`Delete "${image.title}"?`)) {
        return;
    }

    try {
        await axios.delete(
            `/admin/data/gallery/images/${image.id}`
        );

        await loadData();

    } catch (error) {
        console.error('Image delete error:', error);

        alert(
            error.response?.data?.message ||
            'Unable to delete image.'
        );
    }
};


onMounted(() => {
    categoryModal = new Modal(
        document.getElementById('categoryModal')
    );

    uploadModal = new Modal(
        document.getElementById('uploadModal')
    );

    editImageModal = new Modal(
        document.getElementById('editImageModal')
    );

    loadData();
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
}

.page-header p {
    margin: 5px 0 0;
    color: #8b93a1;
    font-size: 13px;
}

.header-actions {
    display: flex;
    gap: 10px;
}

.content-card {
    background: #fff;
    border: 1px solid #e8ecf1;
    border-radius: 12px;
    overflow: hidden;
}

.card-header-custom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid #edf0f3;
}

.card-header-custom h6 {
    margin: 0;
    font-weight: 700;
}

.card-header-custom small {
    color: #8b93a1;
}

.category-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 15px 20px;
}

.category-item {
    border: 1px solid #e1e5ea;
    background: #fff;
    border-radius: 8px;
    padding: 9px 12px;
    display: flex;
    align-items: center;
    gap: 15px;
    color: #495057;
}

.category-item.active {
    background: #212529;
    border-color: #212529;
    color: #fff;
}

.category-right {
    display: flex;
    align-items: center;
    gap: 7px;
}

.category-actions {
    display: flex;
    gap: 3px;
}

.category-item.active .category-actions .btn {
    background: #fff;
    color: #212529;
}

.gallery-card {
    border: 1px solid #e7ebef;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    transition: .2s;
}

.gallery-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, .07);
}

.gallery-image {
    height: 210px;
    position: relative;
    background: #f3f4f6;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.priority-badge,
.status-badge {
    position: absolute;
    top: 10px;
    padding: 5px 8px;
    border-radius: 5px;
    font-size: 10px;
    font-weight: 600;
}

.priority-badge {
    left: 10px;
    background: #212529;
    color: #fff;
}

.status-badge {
    right: 10px;
}

.status-badge.active {
    background: #d1e7dd;
    color: #146c43;
}

.status-badge.inactive {
    background: #f8d7da;
    color: #b02a37;
}

.gallery-content {
    padding: 15px;
}

.image-category {
    font-size: 10px;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 7px;
    text-transform: uppercase;
}

.gallery-content h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
}

.gallery-content p {
    margin: 7px 0 12px;
    color: #8b93a1;
    font-size: 12px;
    line-height: 1.5;
}

.image-actions {
    display: flex;
    gap: 7px;
    border-top: 1px solid #edf0f3;
    padding-top: 10px;
}

.upload-item {
    display: flex;
    gap: 20px;
    padding: 20px;
    border: 1px solid #e6e9ed;
    border-radius: 10px;
    margin-bottom: 15px;
}

.upload-preview {
    width: 180px;
    min-width: 180px;
    height: 140px;
    border-radius: 8px;
    overflow: hidden;
    background: #f3f4f6;
}

.upload-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.upload-form {
    flex: 1;
}

.select-image-box {
    border: 2px dashed #dce1e6;
    border-radius: 10px;
    text-align: center;
    padding: 60px 20px;
    color: #8b93a1;
}

.select-image-box i {
    display: block;
    font-size: 40px;
    margin-bottom: 10px;
}

.edit-preview {
    width: 100%;
    height: 250px;
    border-radius: 8px;
    overflow: hidden;
    background: #f3f4f6;
}

.edit-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.empty-state {
    text-align: center;
    padding: 70px 20px;
}

.empty-state i {
    font-size: 45px;
    color: #adb5bd;
}

.empty-state h5 {
    margin-top: 15px;
    font-size: 16px;
}

.empty-state p {
    color: #8b93a1;
    font-size: 13px;
}

@media (max-width: 767px) {
    .page-header {
        align-items: flex-start;
        gap: 15px;
    }

    .header-actions {
        flex-direction: column;
    }

    .upload-item {
        flex-direction: column;
    }

    .upload-preview {
        width: 100%;
        height: 200px;
    }
}
</style>