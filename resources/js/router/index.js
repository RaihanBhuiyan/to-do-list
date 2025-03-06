import { createRouter, createWebHashHistory, createWebHistory } from 'vue-router';

// Import components
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import TaskList from '../components/TaskList.vue';

const routes = [
    {
        path: '/',
        name: 'login',
        component: Login,
        beforeEnter: (to, from, next) => {
            const isAuthenticated = localStorage.getItem('auth_token');
            if (isAuthenticated) {
                next({ name: 'task-list' }); // Redirect to task list if authenticated
            } else {
                next();
            }
        },
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
    },
    {
        path: '/task-list',
        name: 'task-list',
        component: TaskList,
        beforeEnter: (to, from, next) => {
            const isAuthenticated = localStorage.getItem('auth_token');
            if (isAuthenticated) {
                next();
            } else {
                next({ name: 'login' }); // Redirect to login if not authenticated
            }
        },
    },
];

const router = createRouter({
    // history: createWebHistory(import.meta.env.APP_URL), // Update if necessary
    //history: createWebHashHistory(),
    history: createWebHistory(),
    routes,
});

export default router;
