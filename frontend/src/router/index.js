import { createRouter, createWebHistory } from 'vue-router';
import ChatCreate from '../views/chat/ChatCreate.vue';
import ChatDelete from '../views/chat/ChatDelete.vue';
import ChatEdit from '../views/chat/ChatEdit.vue';
import Chat from '../views/chat/ChatIndex.vue';
import ChatShow from '../views/chat/ChatShow.vue';
import CommissionsCreate from '../views/commissions/CommissionsCreate.vue';
import CommissionsDelete from '../views/commissions/CommissionsDelete.vue';
import CommissionsEdit from '../views/commissions/CommissionsEdit.vue';
import Commissions from '../views/commissions/CommissionsIndex.vue';
import CommissionsShow from '../views/commissions/CommissionsShow.vue';
import Home from '../views/home.vue';
import PostsCreate from '../views/Posts/PostsCreate.vue';
import PostsDelete from '../views/Posts/PostsDelete.vue';
import PostsEdit from '../views/Posts/PostsEdit.vue';
import Posts from '../views/Posts/PostsIndex.vue';
import PostsShow from '../views/Posts/PostsShow.vue';
import PrivilegesCreate from '../views/Privileges/PrivilegesCreate.vue';
import PrivilegesDelete from '../views/Privileges/PrivilegesDelete.vue';
import PrivilegesEdit from '../views/Privileges/PrivilegesEdit.vue';
import Privileges from '../views/Privileges/PrivilegesIndex.vue';
import PrivilegesShow from '../views/Privileges/PrivilegesShow.vue';
import UtilisateurCreate from '../views/Utilisateur/UtilisateurCreate.vue';
import UtilisateurDelete from '../views/Utilisateur/UtilisateurDelete.vue';
import UtilisateurEdit from '../views/Utilisateur/UtilisateurEdit.vue';
import Utilisateur from '../views/Utilisateur/UtilisateurIndex.vue';
import UtilisateurShow from '../views/Utilisateur/UtilisateurShow.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/Utilisateur',
    component: Utilisateur,
    children: [
      {
        path: 'UtilisateurCreate',
        name: 'UtilisateurCreate',
        component: UtilisateurCreate,
      },
      {
        path: 'UtilisateurShow',
        name: 'UtilisateurShow',
        component: UtilisateurShow,
      },
      {
        path: 'UtilisateurDelete',
        name: 'UtilisateurDelete',
        component: UtilisateurDelete,
      },
      {
        path: 'UtilisateurEdit',
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
        path: 'PrivilegesCreate',
        name: 'PrivilegesCreate',
        component: PrivilegesCreate,
      },
      {
        path: 'PrivilegesShow',
        name: 'PrivilegesShow',
        component: PrivilegesShow,
      },
      {
        path: 'PrivilegesDelete',
        name: 'PrivilegesDelete',
        component: PrivilegesDelete,
      },
      {
        path: 'PrivilegesEdit',
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
        path: 'PostsCreate',
        name: 'PostsCreate',
        component: PostsCreate,
      },
      {
        path: 'PostsShow',
        name: 'PostsShow',
        component: PostsShow,
      },
      {
        path: 'PostsDelete',
        name: 'PostsDelete',
        component: PostsDelete,
      },
      {
        path: 'PostsEdit',
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
        path: 'CommissionsCreate',
        name: 'CommissionsCreate',
        component: CommissionsCreate,
      },
      {
        path: 'CommissionsShow',
        name: 'CommissionsShow',
        component: CommissionsShow,
      },
      {
        path: 'CommissionsDelete',
        name: 'CommissionsDelete',
        component: CommissionsDelete,
      },
      {
        path: 'CommissionsEdit',
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
        path: 'ChatCreate',
        name: 'ChatCreate',
        component: ChatCreate,
      },
      {
        path: 'ChatShow',
        name: 'ChatShow',
        component: ChatShow,
      },
      {
        path: 'ChatDelete',
        name: 'ChatDelete',
        component: ChatDelete,
      },
      {
        path: 'ChatEdit',
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
