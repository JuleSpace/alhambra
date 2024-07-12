import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/home.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/Utilisateur',
    name: 'Utilisateur',
    component: () => import('./Utilisateur/index.vue'),
  },
  {
    path: '/Privilèges',
    name: 'Privilèges',
    component: () => import('./Privilèges/index.vue'),
  },
  {
    path: '/Posts',
    name: 'Posts',
    component: () => import('./Posts/index.vue'),
  },
  {
    path: '/Commissions',
    name: 'Commissions',
    component: () => import('./Commissions/index.vue'),
  },
  {
    path: '/Chat',
    name: 'Chat',
    component: () => import('./Chat/index.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;

