import { createRouter, createWebHistory } from "vue-router";
import AppLayout from "../layouts/AppLayout.vue";
import NotFoundPage from "../pages/aborts/NotFoundPage.vue";
import ForbiddenPage from "../pages/aborts/ForbiddenPage.vue";

const routes = [
  /////////////////////////////// layouts ////////////////////////////////////
  {
    name: "app-layout",
    path: "/",
    component: AppLayout,
    children: [
      // routes
      {
        name: "home",
        path: "home",
        component: function () {
          return import("../pages/home/HomePage.vue");
        },
      }, //end of web
    ], //end of children
    redirect: { name: "home" },
  }, //end of app layout
  ///////////////////////////////// auth //////////////////////////////////////
  {
    name: "login",
    path: "/login",
    component: function () {
      return import("../pages/users/auth/LoginPage.vue");
    },
  }, //end of login
  {
    name: "register",
    path: "/register",
    component: function () {
      return import("../pages/users/auth/RegisterPage.vue");
    },
  }, //end of register
  //////////////////////////////// abort pages ////////////////////////////////
  {
    name: "notfound",
    path: "/:notfound(.*)",
    component: NotFoundPage,
  }, //end of notfound
  {
    name: "forbidden",
    path: "/forbidden",
    component: ForbiddenPage,
  }, //end of forbidden
]; //end of routes

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
}); //end of router

export default router;
