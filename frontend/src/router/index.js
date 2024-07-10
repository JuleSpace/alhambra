import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/home.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  // autres routes si nécessaires
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;