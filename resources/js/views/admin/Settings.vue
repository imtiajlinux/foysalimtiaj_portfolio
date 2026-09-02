<template>
    <AdminLayout>
        <div class="container-fluid py-4 settings-page">
            <div class="page-head">
                <h1 class="page-title">Settings</h1>
                <p class="page-sub">Manage your account settings.</p>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div class="panel-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h3>Change password</h3>
                        <p>Update your admin account password.</p>
                    </div>
                </div>

                <form @submit.prevent="changePassword">
                    <div class="field" :class="{ 'has-error': errors.current_password }">
                        <label for="current_password">Current password</label>
                        <div class="field-input">
                            <input
                                id="current_password"
                                v-model="form.current_password"
                                :type="showCurrentPassword ? 'text' : 'password'"
                                placeholder="Enter current password"
                                autocomplete="current-password"
                            >
                            <button
                                type="button"
                                class="toggle-visibility"
                                :aria-label="showCurrentPassword ? 'Hide password' : 'Show password'"
                                @click="showCurrentPassword = !showCurrentPassword"
                            >
                                <i :class="showCurrentPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                            </button>
                        </div>
                        <p v-if="errors.current_password" class="field-error">{{ errors.current_password[0] }}</p>
                    </div>

                    <div class="field" :class="{ 'has-error': errors.password }">
                        <label for="password">New password</label>
                        <div class="field-input">
                            <input
                                id="password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                placeholder="Enter new password"
                                autocomplete="new-password"
                            >
                            <button
                                type="button"
                                class="toggle-visibility"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                                @click="showPassword = !showPassword"
                            >
                                <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                            </button>
                        </div>

                        <div v-if="form.password" class="strength">
                            <div class="strength-bars">
                                <span
                                    v-for="n in 4"
                                    :key="n"
                                    class="bar"
                                    :class="{ filled: n <= passwordStrength.score, [strengthClass]: n <= passwordStrength.score }"
                                ></span>
                            </div>
                            <span class="strength-label" :class="strengthClass">{{ passwordStrength.label }}</span>
                        </div>

                        <p v-if="errors.password" class="field-error">{{ errors.password[0] }}</p>
                        <p v-else class="field-hint">Password must be at least 8 characters.</p>
                    </div>

                    <div class="field" :class="{ 'has-error': errors.password_confirmation }">
                        <label for="password_confirmation">Confirm new password</label>
                        <div class="field-input">
                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                :type="showConfirmation ? 'text' : 'password'"
                                placeholder="Confirm new password"
                                autocomplete="new-password"
                            >
                            <button
                                type="button"
                                class="toggle-visibility"
                                :aria-label="showConfirmation ? 'Hide password' : 'Show password'"
                                @click="showConfirmation = !showConfirmation"
                            >
                                <i :class="showConfirmation ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                            </button>
                        </div>
                        <p v-if="errors.password_confirmation" class="field-error">{{ errors.password_confirmation[0] }}</p>
                        <p
                            v-else-if="form.password_confirmation && form.password_confirmation !== form.password"
                            class="field-hint mismatch"
                        >
                            Doesn't match the new password yet.
                        </p>
                    </div>

                    <div v-if="successMessage" class="notice notice-success">
                        <i class="bi bi-check-circle"></i>
                        {{ successMessage }}
                    </div>

                    <div v-if="generalError" class="notice notice-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ generalError }}
                    </div>

                    <div class="submit-row">
                        <button type="submit" class="submit-btn" :disabled="loading">
                            <span v-if="loading" class="spinner" aria-hidden="true"></span>
                            <i v-else class="bi bi-key"></i>
                            {{ loading ? 'Changing' : 'Change password' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../layouts/AdminLayout.vue';
import { reactive, ref, computed } from 'vue';
import axios from 'axios';

const form = reactive({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const errors = ref({});
const generalError = ref('');
const successMessage = ref('');
const loading = ref(false);

const showCurrentPassword = ref(false);
const showPassword = ref(false);
const showConfirmation = ref(false);

const passwordStrength = computed(() => {
    const value = form.password;

    if (!value) {
        return { score: 0, label: '' };
    }

    let score = 0;
    if (value.length >= 8) score++;
    if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
    if (/[0-9]/.test(value)) score++;
    if (/[^A-Za-z0-9]/.test(value)) score++;

    const labels = ['Weak', 'Weak', 'Fair', 'Good', 'Strong'];

    return { score, label: labels[score] };
});

const strengthClass = computed(() => {
    if (passwordStrength.value.score <= 1) return 'weak';
    if (passwordStrength.value.score === 2) return 'fair';
    if (passwordStrength.value.score === 3) return 'good';
    return 'strong';
});

const changePassword = async () => {
    loading.value = true;
    errors.value = {};
    generalError.value = '';
    successMessage.value = '';

    try {
        const response = await axios.post('/admin/data/settings/password', form);

        successMessage.value = response.data.message;

        form.current_password = '';
        form.password = '';
        form.password_confirmation = '';
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};

            generalError.value = error.response.data.message || '';
        } else {
            generalError.value = 'Something went wrong. Please try again.';
        }
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Space+Grotesk:wght@400;500;600&display=swap');

.settings-page {
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

/* ---------- Panel ---------- */

.panel {
    max-width: 480px;
    background: #FFFFFF;
    border: 1px solid #ECE9DD;
    border-top: 3px solid #4A4CE0;
    border-radius: 12px;
    padding: 32px clamp(20px, 3vw, 36px) 36px;
}

.panel-head {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 30px;
}

.panel-icon {
    flex: none;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #14131C;
    color: #F7F5EF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.panel-head h3 {
    font-family: 'Fraunces', serif;
    font-weight: 500;
    font-size: 20px;
    margin: 0 0 4px;
    color: #14131C;
}

.panel-head p {
    font-size: 13.5px;
    color: #6B6875;
    margin: 0;
}

/* ---------- Fields ---------- */

.field {
    margin-bottom: 24px;
}

.field label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #14131C;
    margin-bottom: 8px;
}

.field-input {
    display: flex;
    align-items: center;
    border-bottom: 1.5px solid #D8D5CB;
    transition: border-color 0.2s ease;
}

.field-input:focus-within {
    border-color: #4A4CE0;
}

.field.has-error .field-input {
    border-color: #C24A4A;
}

.field-input input {
    flex: 1;
    min-width: 0;
    border: none;
    background: transparent;
    padding: 7px 2px 9px;
    font-family: inherit;
    font-size: 14.5px;
    color: #14131C;
    outline: none;
}

.field-input input::placeholder {
    color: #B4B0A6;
}

.toggle-visibility {
    flex: none;
    background: none;
    border: none;
    color: #8B879C;
    font-size: 16px;
    padding: 4px 2px;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: color 0.15s ease;
}

.toggle-visibility:hover {
    color: #4A4CE0;
}

.field-error {
    font-size: 12px;
    color: #C24A4A;
    margin: 6px 0 0;
}

.field-hint {
    font-size: 12px;
    color: #8B879C;
    margin: 6px 0 0;
}

.field-hint.mismatch {
    color: #C24A4A;
}

/* ---------- Password strength ---------- */

.strength {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.strength-bars {
    display: flex;
    gap: 4px;
    flex: 1;
}

.bar {
    height: 4px;
    flex: 1;
    border-radius: 2px;
    background: #ECE9DD;
    transition: background 0.2s ease;
}

.bar.filled.weak { background: #C24A4A; }
.bar.filled.fair { background: #E3A73C; }
.bar.filled.good { background: #4A4CE0; }
.bar.filled.strong { background: #2F7D4F; }

.strength-label {
    font-size: 12px;
    font-weight: 500;
    color: #8B879C;
    flex: none;
}

.strength-label.weak { color: #C24A4A; }
.strength-label.fair { color: #E3A73C; }
.strength-label.good { color: #4A4CE0; }
.strength-label.strong { color: #2F7D4F; }

/* ---------- Notices ---------- */

.notice {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 14px;
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 20px;
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

/* ---------- Submit ---------- */

.submit-row {
    display: flex;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 24px;
    border-top: 1px solid #ECE9DD;
}

.submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: #14131C;
    color: #F7F5EF;
    border: none;
    border-radius: 8px;
    padding: 12px 26px;
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

input:focus-visible,
button:focus-visible {
    outline: 2px solid #4A4CE0;
    outline-offset: 3px;
}

@media (max-width: 560px) {
    .panel {
        max-width: 100%;
        padding: 24px 18px 28px;
    }
}
</style>