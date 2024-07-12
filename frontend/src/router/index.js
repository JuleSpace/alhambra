import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/home.vue';
import Utilisateur from '../views/Utilisateur/index.vue';
import Privileges from '../views/Privileges/index.vue';
import Posts from '../views/Posts/index.vue';
import Commissions from '../views/Commissions/index.vue';
import Chat from '../views/Chat/index.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/Utilisateur',
    name: 'Utilisateur',
    component: Utilisateur,
  },
  {
    path: '/Privileges',
    name: 'Privileges',
    component: Privileges,
  },
  {
    path: '/Posts',
    name: 'Posts',
    component: Posts,
  },
  {
    path: '/Commissions',
    name: 'Commissions',
    component: Commissions,
  },
  {
    path: '/Chat',
    name: 'Chat',
    component: Chat,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
