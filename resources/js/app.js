import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

const vueApp = createApp(App);

vueApp.use(router);

vueApp.mount('#app');