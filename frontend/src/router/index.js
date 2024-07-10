import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/home.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  // Ajoutez d'autres routes ici si nécessaire
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
