import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/home.vue'
import UtilisateurIndex from '@/views/UtilisateurIndex.vue'
import CommissionIndex from '@/views/CommissionIndex.vue'
import PostIndex from '@/views/PostIndex.vue'
import PrivilegeIndex from '@/views/PrivilegeIndex.vue'
import ChatIndex from '@/views/ChatIndex.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/utilisateur',
      name: 'utilisateur-index',
      component: UtilisateurIndex
    },
    {
      path: '/commission',
      name: 'commission-index',
      component: CommissionIndex
    },
    {
      path: '/post',
      name: 'post-index',
      component: PostIndex
    },
    {
      path: '/privilege',
      name: 'privilege-index',
      component: PrivilegeIndex
    },
    {
      path: '/chat',
      name: 'chat-index',
      component: ChatIndex
    }
  ]
})
