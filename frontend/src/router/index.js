import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/home.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/utilisateur',
    name: 'Utilisateur',
    component: () => import('./views/utilisateur/index.vue'),
  },
  {
    path: '/privilèges',
    name: 'Privilèges',
    component: () => import('./views/privileges/index.vue'),
  },
  {
    path: '/posts',
    name: 'Posts',
    component: () => import('./views/posts/index.vue'),
  },
  {
    path: '/commissions',
    name: 'Commissions',
    component: () => import('./views/commissions/index.vue'),
  },
  {
    path: '/chat',
    name: 'Chat',
    component: () => import('./views/chat/index.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;

