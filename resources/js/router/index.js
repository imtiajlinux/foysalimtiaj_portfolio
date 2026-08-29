import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../views/public/Home.vue'),
    },

    {
        path: '/projects',
        name: 'projects',
        component: () => import('../views/public/Projects.vue'),
    },

    {
        path: '/gallery',
        name: 'gallery',
        component: () => import('../views/public/Gallery.vue'),
    },

    {
        path: '/contact',
        name: 'contact',
        component: () => import('../views/public/Contact.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;