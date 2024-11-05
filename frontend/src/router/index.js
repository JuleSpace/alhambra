import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/home.vue';
import ChatIndex from '../views/chat/ChatIndex.vue';
import ChatCreate from '../views/chat/ChatCreate.vue';
import ChatShow from '../views/chat/ChatShow.vue';
import ChatEdit from '../views/chat/ChatEdit.vue';
import ChatDelete from '../views/chat/ChatDelete.vue';
import CommissionsIndex from '../views/commissions/CommissionsIndex.vue';
import CommissionsCreate from '../views/commissions/CommissionsCreate.vue';
import CommissionsShow from '../views/commissions/CommissionsShow.vue';
import CommissionsEdit from '../views/commissions/CommissionsEdit.vue';
import CommissionsDelete from '../views/commissions/CommissionsDelete.vue';
import PostsIndex from '../views/Posts/PostsIndex.vue';
import PostsCreate from '../views/Posts/PostsCreate.vue';
import PostsShow from '../views/Posts/PostsShow.vue';
import PostsEdit from '../views/Posts/PostsEdit.vue';
import PostsDelete from '../views/Posts/PostsDelete.vue';
import PrivilegesIndex from '../views/Privileges/PrivilegesIndex.vue';
import PrivilegesCreate from '../views/Privileges/PrivilegesCreate.vue';
import PrivilegesShow from '../views/Privileges/PrivilegesShow.vue';
import PrivilegesEdit from '../views/Privileges/PrivilegesEdit.vue';
import PrivilegesDelete from '../views/Privileges/PrivilegesDelete.vue';
import UtilisateurIndex from '../views/Utilisateur/UtilisateurIndex.vue';
import UtilisateurCreate from '../views/Utilisateur/UtilisateurCreate.vue';
import UtilisateurShow from '../views/Utilisateur/UtilisateurShow.vue';
import UtilisateurEdit from '../views/Utilisateur/UtilisateurEdit.vue';
import UtilisateurDelete from '../views/Utilisateur/UtilisateurDelete.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/chat',
    component: ChatIndex,
    children: [
      {
        path: 'create',
        name: 'ChatCreate',
        component: ChatCreate,
      },
      {
        path: ':id',
        name: 'ChatShow',
        component: ChatShow,
      },
      {
        path: ':id/edit',
        name: 'ChatEdit',
        component: ChatEdit,
      },
      {
        path: ':id/delete',
        name: 'ChatDelete',
        component: ChatDelete,
      },
    ],
  },
  {
    path: '/commissions',
    component: CommissionsIndex,
    children: [
      {
        path: 'create',
        name: 'CommissionsCreate',
        component: CommissionsCreate,
      },
      {
        path: ':id',
        name: 'CommissionsShow',
        component: CommissionsShow,
      },
      {
        path: ':id/edit',
        name: 'CommissionsEdit',
        component: CommissionsEdit,
      },
      {
        path: ':id/delete',
        name: 'CommissionsDelete',
        component: CommissionsDelete,
      },
    ],
  },
  {
    path: '/posts',
    component: PostsIndex,
    children: [
      {
        path: 'create',
        name: 'PostsCreate',
        component: PostsCreate,
      },
      {
        path: ':id',
        name: 'PostsShow',
        component: PostsShow,
      },
      {
        path: ':id/edit',
        name: 'PostsEdit',
        component: PostsEdit,
      },
      {
        path: ':id/delete',
        name: 'PostsDelete',
        component: PostsDelete,
      },
    ],
  },
  {
    path: '/privileges',
    component: PrivilegesIndex,
    children: [
      {
        path: 'create',
        name: 'PrivilegesCreate',
        component: PrivilegesCreate,
      },
      {
        path: ':id',
        name: 'PrivilegesShow',
        component: PrivilegesShow,
      },
      {
        path: ':id/edit',
        name: 'PrivilegesEdit',
        component: PrivilegesEdit,
      },
      {
        path: ':id/delete',
        name: 'PrivilegesDelete',
        component: PrivilegesDelete,
      },
    ],
  },
  {
    path: '/utilisateur',
    component: UtilisateurIndex,
    children: [
      {
        path: 'create',
        name: 'UtilisateurCreate',
        component: UtilisateurCreate,
      },
      {
        path: ':id',
        name: 'UtilisateurShow',
        component: UtilisateurShow,
      },
      {
        path: ':id/edit',
        name: 'UtilisateurEdit',
        component: UtilisateurEdit,
      },
      {
        path: ':id/delete',
        name: 'UtilisateurDelete',
        component: UtilisateurDelete,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
