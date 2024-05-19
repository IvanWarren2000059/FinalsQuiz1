import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "@/views/LoginPage.vue";
import HomePage from "@/views/HomePage.vue";
import EditPage from "../views/EditPage.vue";
import RegisterPage from "@/views/RegisterPage.vue";
import CreatePost from "@/views/CreatePost.vue";

const routes = [
  { path: "/login", component: LoginPage },
  { path: "/home", component: HomePage, meta: { requiresAuth: true } },
  {
    path: "/edit/:id",
    component: EditPage,
    name: "EditPost",
    props: true,
    meta: { requiresAuth: true },
  },
  { path: "/register", component: RegisterPage },
  { path: "/createpost", component: CreatePost },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token");
  if (to.meta.requiresAuth && !token) {
    next("/login");
  } else if (!token && to.path !== "/login" && to.path !== "/register") {
    next("/login");
  } else {
    next();
  }
});

export default router;
