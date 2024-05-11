import { createRouter, createWebHistory } from 'vue-router';
import UserLogin from '@/views/UserLogin.vue';
import HomeFile from '@/views/HomeFile.vue';
import EditPost from '../views/EditPost.vue';

const routes = [
  { path: '/', component: UserLogin },
  { path: '/home', component: HomeFile, meta: { requiresAuth: true } },
  { 
    path: '/edit/:id', 
    component: EditPost, 
    name: 'EditPost', 
    props: true, 
    meta: { requiresAuth: true } 
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (to.meta.requiresAuth && !token) {
    next('/');
  } else if (to.path !== '/' && !token) {
    next('/');
  } else {
    next();
  }
});

export default router;
