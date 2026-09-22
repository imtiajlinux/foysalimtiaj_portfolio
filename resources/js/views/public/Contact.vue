<template>
    <PublicLayout>
        <section class="contact-page">
            <div class="contact-glow"></div>

            <div class="container">
                <div class="contact-header">
                    <div>
                        <span class="section-label">GET IN TOUCH</span>
                        <h1 class="contact-title">
                            Let's build
                            <span>something.</span>
                        </h1>
                    </div>

                    <p class="contact-intro">
                        Have a project in mind, an idea to discuss, or simply
                        want to say hello? Send me a message and I'll get back
                        to you.
                    </p>
                </div>

                <div class="contact-layout">
                    <div class="contact-info">
                        <div class="info-block">
                            <span class="info-number">01</span>
                            <div>
                                <span class="info-label">EMAIL</span>
                                <a :href="`mailto:${profile.email}`">
                                    {{ profile.email || 'hello@example.com' }}
                                </a>
                            </div>
                        </div>

                        <div class="info-block">
                            <span class="info-number">02</span>
                            <div>
                                <span class="info-label">PHONE</span>
                                <a v-if="profile.phone" :href="`tel:${profile.phone}`">
                                    {{ profile.phone }}
                                </a>
                                <span v-else class="info-muted">Available on request</span>
                            </div>
                        </div>

                        <div class="info-block">
                            <span class="info-number">03</span>
                            <div>
                                <span class="info-label">LOCATION</span>
                                <span>Dhaka, Bangladesh</span>
                            </div>
                        </div>

                        <div class="contact-note">
                            <span class="note-dot"></span>
                            <span>Currently open to interesting projects and opportunities.</span>
                        </div>
                    </div>

                    <div class="contact-form-wrapper">
                        <form class="contact-form" @submit.prevent="submitMessage">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Your Name</label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        placeholder="John Doe"
                                        :class="{ 'has-error': errors.name }"
                                    >
                                    <small v-if="errors.name">{{ errors.name[0] }}</small>
                                </div>

                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        placeholder="john@example.com"
                                        :class="{ 'has-error': errors.email }"
                                    >
                                    <small v-if="errors.email">{{ errors.email[0] }}</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Subject <span>(Optional)</span></label>
                                <input
                                    v-model="form.subject"
                                    type="text"
                                    placeholder="Let's work together"
                                    :class="{ 'has-error': errors.subject }"
                                >
                                <small v-if="errors.subject">{{ errors.subject[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Your Message</label>
                                <textarea
                                    v-model="form.message"
                                    rows="7"
                                    placeholder="Tell me a little about your project or idea..."
                                    :class="{ 'has-error': errors.message }"
                                ></textarea>
                                <small v-if="errors.message">{{ errors.message[0] }}</small>
                            </div>

                            <div v-if="successMessage" class="form-success">
                                <i class="bi bi-check-circle"></i>
                                <span>{{ successMessage }}</span>
                            </div>

                            <div v-if="serverError" class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                <span>{{ serverError }}</span>
                            </div>

                            <button type="submit" class="submit-button" :disabled="sending">
                                <span>{{ sending ? 'Sending...' : 'Send Message' }}</span>
                                <i v-if="!sending" class="bi bi-arrow-up-right"></i>
                                <i v-else class="bi bi-arrow-repeat spinning"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import axios from 'axios';
import PublicLayout from '../../layouts/PublicLayout.vue';

const profile = ref({});
const sending = ref(false);
const successMessage = ref('');
const serverError = ref('');
const errors = ref({});

const form = reactive({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const loadProfile = async () => {
    try {
        const response = await axios.get('/data/home');

        if (response.data.profile) {
            profile.value = response.data.profile;
        }
    } catch (error) {
        console.error('Failed to load profile:', error);
    }
};

const submitMessage = async () => {
    sending.value = true;
    successMessage.value = '';
    serverError.value = '';
    errors.value = {};

    try {
        const response = await axios.post('/data/messages', form);

        successMessage.value = response.data.message;

        form.name = '';
        form.email = '';
        form.subject = '';
        form.message = '';
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
            serverError.value = 'Please check the highlighted fields.';
        } else {
            serverError.value = 'Something went wrong. Please try again.';
        }
    } finally {
        sending.value = false;
    }
};

onMounted(() => {
    loadProfile();
});
</script>

<style scoped>
.contact-page {
    position: relative;
    overflow: hidden;
    min-height: calc(100vh - 82px);
    padding: 110px 0 120px;
    background: #08080c;
}

.contact-glow {
    position: absolute;
    width: 600px;
    height: 600px;
    right: -300px;
    top: 50px;
    border-radius: 50%;
    background: rgba(139, 108, 255, 0.08);
    filter: blur(110px);
    pointer-events: none;
}

.contact-header {
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

.contact-title {
    max-width: 750px;
    margin: 0;
    color: #f5f5f7;
    font-size: clamp(3.5rem, 8vw, 7rem);
    line-height: 0.92;
    letter-spacing: -0.065em;
    font-weight: 600;
}

.contact-title span {
    display: block;
    color: #8b6cff;
}

.contact-intro {
    max-width: 340px;
    margin: 0 0 4px;
    color: #6b6b76;
    font-size: 0.82rem;
    line-height: 1.85;
}

.contact-layout {
    position: relative;
    display: grid;
    grid-template-columns: 0.8fr 1.2fr;
    gap: 100px;
    padding-top: 70px;
}

.contact-info {
    display: flex;
    flex-direction: column;
}

.info-block {
    display: flex;
    gap: 20px;
    padding: 24px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.info-number {
    padding-top: 3px;
    color: #45454f;
    font-size: 0.58rem;
    font-weight: 600;
}

.info-block > div {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.info-label {
    color: #484851;
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.15em;
}

.info-block a,
.info-block div > span:last-child {
    color: #d1d1d6;
    text-decoration: none;
    font-size: 0.8rem;
}

.info-block a:hover {
    color: #8b6cff;
}

.info-muted {
    color: #666670 !important;
}

.contact-note {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-top: 30px;
    color: #5e5e68;
    font-size: 0.68rem;
    line-height: 1.6;
}

.note-dot {
    flex-shrink: 0;
    width: 6px;
    height: 6px;
    margin-top: 5px;
    border-radius: 50%;
    background: #8b6cff;
    box-shadow: 0 0 12px rgba(139, 108, 255, 0.7);
}

.contact-form-wrapper {
    padding: 38px;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.018);
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 9px;
    color: #8c8c96;
    font-size: 0.66rem;
    font-weight: 600;
}

.form-group label span {
    color: #4e4e58;
    font-weight: 400;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 13px 0;
    border: 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    outline: none;
    resize: vertical;
    color: #ededf0;
    background: transparent;
    font-family: inherit;
    font-size: 0.8rem;
    transition: border-color 0.25s ease;
}

.form-group textarea {
    min-height: 145px;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #44444e;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #8b6cff;
}

.form-group input.has-error,
.form-group textarea.has-error {
    border-color: #d95c6a;
}

.form-group small {
    margin-top: 7px;
    color: #d95c6a;
    font-size: 0.62rem;
}

.submit-button {
    align-self: flex-start;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    margin-top: 4px;
    padding: 12px 12px 12px 18px;
    border: 0;
    border-radius: 8px;
    color: #fff;
    background: #8b6cff;
    font-size: 0.72rem;
    font-weight: 600;
    cursor: pointer;
    transition: 0.25s ease;
}

.submit-button:hover:not(:disabled) {
    background: #7655ef;
    transform: translateY(-2px);
}

.submit-button:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

.submit-button i {
    width: 27px;
    height: 27px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background: rgba(0, 0, 0, 0.15);
}

.form-success,
.form-error {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 12px 14px;
    border-radius: 7px;
    font-size: 0.68rem;
}

.form-success {
    color: #a8dfbd;
    background: rgba(75, 180, 115, 0.08);
    border: 1px solid rgba(75, 180, 115, 0.15);
}

.form-error {
    color: #e69ba4;
    background: rgba(217, 92, 106, 0.08);
    border: 1px solid rgba(217, 92, 106, 0.15);
}

.spinning {
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@media (max-width: 991.98px) {
    .contact-header {
        display: block;
    }

    .contact-intro {
        margin-top: 30px;
    }

    .contact-layout {
        grid-template-columns: 1fr;
        gap: 55px;
    }
}

@media (max-width: 767.98px) {
    .contact-page {
        padding: 80px 0;
    }

    .contact-header {
        padding-bottom: 55px;
    }

    .contact-title {
        font-size: clamp(3rem, 15vw, 5rem);
    }

    .contact-layout {
        padding-top: 50px;
    }

    .contact-form-wrapper {
        padding: 25px 20px;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 25px;
    }
}
</style>