import { createRouter, createWebHistory } from 'vue-router';
import ChatCreate from '../views/chat/create.vue';
import ChatDelete from '../views/chat/delete.vue';
import ChatEdit from '../views/chat/edit.vue';
import Chat from '../views/chat/index.vue';
import ChatShow from '../views/chat/show.vue';
import CommissionsCreate from '../views/commissions/create.vue';
import CommissionsDelete from '../views/commissions/delete.vue';
import CommissionsEdit from '../views/commissions/edit.vue';
import Commissions from '../views/commissions/index.vue';
import CommissionsShow from '../views/commissions/show.vue';
import Home from '../views/home.vue';
import PostsCreate from '../views/Posts/create.vue';
import PostsDelete from '../views/Posts/delete.vue';
import PostsEdit from '../views/Posts/edit.vue';
import Posts from '../views/Posts/index.vue';
import PostsShow from '../views/Posts/show.vue';
import PrivilegesCreate from '../views/Privileges/create.vue';
import PrivilegesDelete from '../views/Privileges/delete.vue';
import PrivilegesEdit from '../views/Privileges/edit.vue';
import Privileges from '../views/Privileges/index.vue';
import PrivilegesShow from '../views/Privileges/show.vue';
import UtilisateurCreate from '../views/Utilisateur/create.vue';
import UtilisateurDelete from '../views/Utilisateur/delete.vue';
import UtilisateurEdit from '../views/Utilisateur/edit.vue';
import Utilisateur from '../views/Utilisateur/index.vue';
import UtilisateurShow from '../views/Utilisateur/show.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/utilisateur',
    component: Utilisateur,
    children: [
      {
        path: 'create',
        name: 'UtilisateurCreate',
        component: UtilisateurCreate,
      },
      {
        path: 'show',
        name: 'UtilisateurShow',
        component: UtilisateurShow,
      },
      {
        path: 'delete',
        name: 'UtilisateurDelete',
        component: UtilisateurDelete,
      },
      {
        path: 'edit',
        name: 'UtilisateurEdit',
        component: UtilisateurEdit,
      },
    ],
  },
  {
    path: '/privileges',
    component: Privileges,
    children: [
      {
        path: 'create',
        name: 'PrivilegesCreate',
        component: PrivilegesCreate,
      },
      {
        path: 'show',
        name: 'PrivilegesShow',
        component: PrivilegesShow,
      },
      {
        path: 'delete',
        name: 'PrivilegesDelete',
        component: PrivilegesDelete,
      },
      {
        path: 'edit',
        name: 'PrivilegesEdit',
        component: PrivilegesEdit,
      },
    ],
  },
  {
    path: '/posts',
    component: Posts,
    children: [
      {
        path: 'create',
        name: 'PostsCreate',
        component: PostsCreate,
      },
      {
        path: 'show',
        name: 'PostsShow',
        component: PostsShow,
      },
      {
        path: 'delete',
        name: 'PostsDelete',
        component: PostsDelete,
      },
      {
        path: 'edit',
        name: 'PostsEdit',
        component: PostsEdit,
      },
    ],
  },
  {
    path: '/commissions',
    component: Commissions,
    children: [
      {
        path: 'create',
        name: 'CommissionsCreate',
        component: CommissionsCreate,
      },
      {
        path: 'show',
        name: 'CommissionsShow',
        component: CommissionsShow,
      },
      {
        path: 'delete',
        name: 'CommissionsDelete',
        component: CommissionsDelete,
      },
      {
        path: 'edit',
        name: 'CommissionsEdit',
        component: CommissionsEdit,
      },
    ],
  },
  {
    path: '/chat',
    component: Chat,
    children: [
      {
        path: 'create',
        name: 'ChatCreate',
        component: ChatCreate,
      },
      {
        path: 'show',
        name: 'ChatShow',
        component: ChatShow,
      },
      {
        path: 'delete',
        name: 'ChatDelete',
        component: ChatDelete,
      },
      {
        path: 'edit',
        name: 'ChatEdit',
        component: ChatEdit,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
