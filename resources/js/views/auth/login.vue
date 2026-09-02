<template>
    <div class="login-page">
        <div class="showcase" aria-hidden="true">
            <div class="aurora"></div>
            <div class="showcase-content">
                <p class="showcase-eyebrow">Portfolio admin</p>
                <h1 class="showcase-mark">Foysal<br>Imtiaj</h1>
                <p class="showcase-line">The work behind the work.</p>
            </div>
            <div class="showcase-grid"></div>
        </div>

        <div class="panel">
            <div class="panel-inner">
                <router-link to="/" class="back-link">
                    <span class="back-arrow">←</span> Back to portfolio
                </router-link>

                <div class="panel-head">
                    <h2>Welcome back</h2>
                    <p>Sign in to Show the World .</p>
                </div>

                <div v-if="generalError" class="alert" role="alert">
                    {{ generalError }}
                </div>

                <form @submit.prevent="login" novalidate>
                    <div class="field" :class="{ 'has-error': errors.email }">
                        <label for="email">Email</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="you@example.com"
                            autocomplete="email"
                            required
                        >
                        <p v-if="errors.email" class="field-error">{{ errors.email }}</p>
                    </div>

                    <div class="field" :class="{ 'has-error': errors.password }">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        <p v-if="errors.password" class="field-error">{{ errors.password }}</p>
                    </div>

                    <button type="submit" class="submit" :disabled="loading">
                        <span v-if="loading" class="spinner" aria-hidden="true"></span>
                        {{ loading ? 'Signing in' : 'Sign in' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const form = reactive({
    email: '',
    password: '',
    remember: false,
});

const loading = ref(false);
const generalError = ref('');
const errors = reactive({
    email: '',
    password: '',
});

const login = async () => {
    loading.value = true;
    generalError.value = '';
    errors.email = '';
    errors.password = '';
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');

        const response = await fetch('/admin/login', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With':
                    'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                email: form.email,
                password: form.password,
                remember: form.remember,
            }),
        });
        const data = await response.json();
        if (!response.ok) {
            if (data.errors) {
                if (data.errors.email) {
                    errors.email =
                        Array.isArray(data.errors.email)
                            ? data.errors.email[0]
                            : data.errors.email;

                }
                if (data.errors.password) {
                    errors.password =
                        Array.isArray(data.errors.password)
                            ? data.errors.password[0]
                            : data.errors.password;

                }

            }
            generalError.value =
                data.message ||
                'Login failed. Please check your credentials.';

            return;
        }
        router.push({
            name: 'admin.dashboard',
        });
    }

    catch (error) {
        console.error(
            'Login error:',
            error
        );
        generalError.value =
            'Something went wrong. Please try again.';
    }
    finally {
        loading.value = false;
    }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Space+Grotesk:wght@400;500;600&display=swap');

.login-page {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1.05fr 1fr;
    font-family: 'Space Grotesk', sans-serif;
    background: #F7F5EF;
}


.showcase {
    position: relative;
    overflow: hidden;
    background: #14131C;
    color: #F7F5EF;
    display: flex;
    align-items: center;
    padding: 6vw;
}

.aurora {
    position: absolute;
    inset: -20%;
    background:
        radial-gradient(38% 42% at 22% 28%, rgba(74, 76, 224, 0.55), transparent 70%),
        radial-gradient(32% 36% at 78% 68%, rgba(227, 167, 60, 0.28), transparent 70%),
        radial-gradient(45% 50% at 60% 15%, rgba(74, 76, 224, 0.22), transparent 70%);
    filter: blur(40px);
    animation: drift 22s ease-in-out infinite alternate;
}

@keyframes drift {
    0%   { transform: translate3d(0, 0, 0) scale(1); }
    100% { transform: translate3d(-4%, 3%, 0) scale(1.08); }
}

.showcase-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(247, 245, 239, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(247, 245, 239, 0.05) 1px, transparent 1px);
    background-size: 64px 64px;
    mask-image: linear-gradient(to bottom, transparent, black 30%, black 80%, transparent);
}

.showcase-content {
    position: relative;
    z-index: 1;
    max-width: 460px;
}

.showcase-eyebrow {
    font-size: 13px;
    letter-spacing: 0.02em;
    color: #A6A3B8;
    margin: 0 0 18px;
}

.showcase-mark {
    font-family: 'Fraunces', serif;
    font-weight: 500;
    font-size: clamp(48px, 6.4vw, 84px);
    line-height: 0.98;
    letter-spacing: -0.01em;
    margin: 0 0 26px;
}

.showcase-line {
    font-size: 16px;
    color: #C7C4D6;
    margin: 0;
    max-width: 30ch;
}


.panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8vw 8%;
}

.panel-inner {
    width: 100%;
    max-width: 380px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #6B6875;
    text-decoration: none;
    margin-bottom: 48px;
    transition: color 0.15s ease;
}

.back-link:hover {
    color: #14131C;
}

.back-arrow {
    transition: transform 0.15s ease;
}

.back-link:hover .back-arrow {
    transform: translateX(-3px);
}

.panel-head h2 {
    font-family: 'Fraunces', serif;
    font-weight: 500;
    font-size: 34px;
    margin: 0 0 8px;
    color: #14131C;
}

.panel-head p {
    font-size: 15px;
    color: #6B6875;
    margin: 0 0 36px;
}

.alert {
    background: #FBEAEA;
    border: 1px solid #E7B6B6;
    color: #9A3B3B;
    font-size: 14px;
    padding: 12px 14px;
    border-radius: 8px;
    margin-bottom: 24px;
}

.field {
    margin-bottom: 26px;
}

.field label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #14131C;
    margin-bottom: 8px;
}

.field input {
    width: 100%;
    border: none;
    border-bottom: 1.5px solid #D8D5CB;
    background: transparent;
    padding: 8px 2px 10px;
    font-family: inherit;
    font-size: 15px;
    color: #14131C;
    outline: none;
    transition: border-color 0.2s ease;
}

.field input::placeholder {
    color: #B4B0A6;
}

.field input:focus {
    border-color: #4A4CE0;
}

.field.has-error input {
    border-color: #C24A4A;
}

.field-error {
    font-size: 12.5px;
    color: #C24A4A;
    margin: 6px 0 0;
}

.remember {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #52505C;
    cursor: pointer;
    margin-bottom: 32px;
    user-select: none;
}

.remember input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.remember-box {
    width: 18px;
    height: 18px;
    flex: none;
    border: 1.5px solid #D8D5CB;
    border-radius: 4px;
    position: relative;
    transition: background 0.15s ease, border-color 0.15s ease;
}

.remember input:checked + .remember-box {
    background: #4A4CE0;
    border-color: #4A4CE0;
}

.remember input:checked + .remember-box::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 1px;
    width: 5px;
    height: 9px;
    border: solid #F7F5EF;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.remember input:focus-visible + .remember-box {
    outline: 2px solid #4A4CE0;
    outline-offset: 2px;
}

.submit {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #14131C;
    color: #F7F5EF;
    border: none;
    border-radius: 8px;
    padding: 14px;
    font-family: inherit;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.18s ease, transform 0.06s ease;
}

.submit:hover:not(:disabled) {
    background: #4A4CE0;
}

.submit:active:not(:disabled) {
    transform: scale(0.99);
}

.submit:disabled {
    opacity: 0.75;
    cursor: default;
}

.spinner {
    width: 15px;
    height: 15px;
    border: 2px solid rgba(247, 245, 239, 0.35);
    border-top-color: #F7F5EF;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

input:focus-visible,
button:focus-visible,
a:focus-visible {
    outline: 2px solid #4A4CE0;
    outline-offset: 3px;
}

@media (prefers-reduced-motion: reduce) {
    .aurora {
        animation: none;
    }
}


@media (max-width: 860px) {
    .login-page {
        grid-template-columns: 1fr;
    }

    .showcase {
        padding: 44px 24px;
        min-height: 260px;
    }

    .showcase-mark {
        font-size: clamp(38px, 11vw, 56px);
    }

    .showcase-line {
        display: none;
    }

    .panel {
        padding: 40px 24px 56px;
    }
}
</style>