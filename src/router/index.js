import { createRouter, createWebHistory } from 'vue-router';
import UserLogin from '@/views/UserLogin.vue';
import HomeFile from '@/views/HomeFile.vue';
import EditPost from '../views/EditPost.vue';
import RegisterFile from '@/views/RegisterAccount.vue';
import CreatePost from '@/views/CreatePost.vue';

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
  { path: '/register', component: RegisterFile },
  { path: '/createpost', component: CreatePost },


];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (to.meta.requiresAuth && !token) {
    next('/');
  } else if (!token && (to.path !== '/' && to.path !== '/register')) {
    next('/register'); 
  } else {
    next();
  }
});


export default router;
