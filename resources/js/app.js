import './bootstrap';

import { createApp } from 'vue';

import { createPinia } from 'pinia';

import App from './App.vue';

import router from './router';

import 'bootstrap/dist/css/bootstrap.min.css';

import 'bootstrap';

import 'bootstrap-icons/font/bootstrap-icons.css';

const appElement = document.getElementById('app');
const authUser = appElement?.dataset.user
    ? JSON.parse(appElement.dataset.user)
    : null;
const app = createApp(App);

app.provide('authUser', authUser);

const pinia = createPinia();

app.use(pinia);

app.use(router);



app.mount('#app');