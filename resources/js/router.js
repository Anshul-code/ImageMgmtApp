import { createRouter, createWebHistory } from "vue-router";
import HomeView from './views/HomeView.vue'
import DashboardView from './views/DashboardView.vue'
import ImagesReport from './views/images/ImagesReport.vue'
import CreateImage from './views/images/CreateImage.vue'
import ListImages from './views/images/ListImages.vue'


import { useAuthStore } from "./stores/auth";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomeView,
        meta: {
            requiresAuth: false,
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: DashboardView,
        children: [
            {
                path: 'images/create',
                name: 'CreateImage',
                component: CreateImage,
                meta: {
                    requiresAuth: true,
                    roleAccess: [1],
                }
            },
            {
                path: 'images/report',
                name: 'ImagesReport',
                component: ImagesReport,
                meta: {
                    requiresAuth: true,
                    roleAccess: [1],
                }
            },
        ],
        meta: {
            requiresAuth: true,
            roleAccess: [1,2],
        },
    },
    {
        path: '/dashboard/images/list',
        name: 'ListImages',
        component: ListImages,
        meta: {
            requiresAuth: true,
            roleAccess: [1,2],
        },
    },
    
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// Guards
router.beforeEach((to, from) => {
    const authStore = useAuthStore();
    
    // Auth Guards
    if(to.meta.requiresAuth && !authStore.token) {
        return { name: "Home" };
    } 

    if(to.meta.requiresAuth == false && authStore.token) {
        return { name: "Dashboard" };
    } 

    // Dashboard redirect according to roles
    if(to.name == "Dashboard" && !authStore.isGuest) {
      if(authStore.user.role_id == 1) { // Contributor
            return { name: 'CreateImage' };
        } else { // Normal User
            console.log('list');
            return { name: 'ListImages' };
        }
    }  

    // Role Based gaurds
    if(to.name !== "Dashboard" && to.meta.roleAccess && !authStore.isGuest){
        if(to.meta.roleAccess.indexOf(Number(authStore.user.role_id)) < 0){
            return { name: "Dashboard" };
        }
    }
});

export default router;

