import {
    createRouter,
    createWebHistory
} from 'vue-router';

import { useAuth } from '../stores/auth';


const routes = [

    /*
    |--------------------------------------------------------------------------
    | Public
    |--------------------------------------------------------------------------
    */

    {
        path: '/',
        name: 'home',

        component: () =>
            import('../views/public/Home.vue'),
    },

    {
        path: '/projects',
        name: 'projects',

        component: () =>
            import('../views/public/Projects.vue'),
    },

    {
        path: '/gallery',
        name: 'gallery',

        component: () =>
            import('../views/public/Gallery.vue'),
    },

    {
        path: '/contact',
        name: 'contact',

        component: () =>
            import('../views/public/Contact.vue'),
    },


    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/login',

        name: 'admin.login',

        component: () =>
            import('../views/auth/login.vue'),

        meta: {
            guest: true,
        },
    },


    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/dashboard',

        name: 'admin.dashboard',

        component: () =>
            import('../views/admin/Dashboard.vue'),

        meta: {
            requiresAuth: true,
        },
    },


    /*
    |--------------------------------------------------------------------------
    | Admin Projects
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/projects',

        name: 'admin.projects',

        component: () =>
            import('../views/admin/Projects.vue'),

        meta: {
            requiresAuth: true,
        },
    },


    /*
    |--------------------------------------------------------------------------
    | Admin Skills
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/skills',

        name: 'admin.skills',

        component: () =>
            import('../views/admin/Skills.vue'),

        meta: {
            requiresAuth: true,
        },
    },


    /*
    |--------------------------------------------------------------------------
    | Admin Experience
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/experience',

        name: 'admin.experience',

        component: () =>
            import('../views/admin/Experience.vue'),

        meta: {
            requiresAuth: true,
        },
    },


    /*
    |--------------------------------------------------------------------------
    | Admin Education
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/education',

        name: 'admin.education',

        component: () =>
            import('../views/admin/Education.vue'),

        meta: {
            requiresAuth: true,
        },
    },


    /*
    |--------------------------------------------------------------------------
    | Admin Messages
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/messages',

        name: 'admin.messages',

        component: () =>
            import('../views/admin/Messages.vue'),

        meta: {
            requiresAuth: true,
        },
    },


    /*
    |--------------------------------------------------------------------------
    | Admin Profile
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/profile',

        name: 'admin.profile',

        component: () =>
            import('../views/admin/Profile.vue'),

        meta: {
            requiresAuth: true,
        },
    },


    /*
    |--------------------------------------------------------------------------
    | Admin Settings
    |--------------------------------------------------------------------------
    */

    {
        path: '/admin/settings',

        name: 'admin.settings',

        component: () =>
            import('../views/admin/Settings.vue'),

        meta: {
            requiresAuth: true,
        },
    },

];


const router = createRouter({

    history: createWebHistory(),

    routes,

    scrollBehavior() {

        return {
            top: 0,
        };

    },

});


/*
|--------------------------------------------------------------------------
| Authentication Guard
|--------------------------------------------------------------------------
*/

router.beforeEach(async (to) => {

    const auth = useAuth();


    /*
    |--------------------------------------------------------------------------
    | Protected Page
    |--------------------------------------------------------------------------
    */

    if (to.meta.requiresAuth) {

        /*
        |--------------------------------------------------------------------------
        | Ask Laravel whether session exists
        |--------------------------------------------------------------------------
        */

        const authenticated =
            await auth.fetchUser();


        if (!authenticated) {

            return {
                name: 'admin.login',
            };

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Login Page
    |--------------------------------------------------------------------------
    */

    if (to.meta.guest) {

        const authenticated =
            await auth.fetchUser();


        if (authenticated) {

            return {
                name: 'admin.dashboard',
            };

        }

    }

});


export default router;