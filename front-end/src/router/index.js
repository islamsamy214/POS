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
      {
        name: "home",
        path: "home",
        component: function () {
          return import("../pages/home/HomePage.vue");
        },
      }, //end of home
      {
        name: "cart",
        path: "cart",
        component: function () {
          return import("../pages/home/cart/Cart.vue");
        },
      }, //end of cart
      {
        name: "products-show",
        path: "products/:product_sku",
        component: function () {
          return import("../pages/home/products/show/ShowPage.vue");
        },
      }, //end of products show
      {
        name: "products-create",
        path: "products/create",
        component: function () {
          return import("../pages/users/products/create/CreatePage.vue");
        },
      }, //end of products create
      {
        name: "products-edit",
        path: "products/edit/:product_sku",
        component: function () {
          return import("../pages/users/products/edit/EditPage.vue");
        },
      }, //end of products edit
      {
        name: "users",
        path: "users",
        component: function () {
          return import("../pages/users/users/UserPage.vue");
        },
      }, //end of users
      {
        name: "users-create",
        path: "users/create",
        component: function () {
          return import("../pages/users/users/create/CreatePage.vue");
        },
      }, //end of users create
      {
        name: "users-edit",
        path: "users/edit/:id",
        component: function () {
          return import("../pages/users/users/Edit/EditPage.vue");
        },
      }, //end of users edit
      {
        name: "orders",
        path: "orders",
        component: function () {
          return import("../pages/users/orders/OrderPage.vue");
        },
      }, //end of orders
      {
        name: "orders-show",
        path: "orders/:order",
        component: function () {
          return import("../pages/users/orders/show/ShowPage.vue");
        },
      }, //end of orders show
      {
        name: "orders-create",
        path: "orders/create",
        component: function () {
          return import("../pages/users/orders/create/CreatePage.vue");
        },
      }, //end of orders create
      {
        name: "orders-edit",
        path: "orders/edit/:id",
        component: function () {
          return import("../pages/users/orders/edit/EditPage.vue");
        },
      }, //end of orders edit
      {
        name: "brands",
        path: "brands",
        component: function () {
          return import("../pages/users/brands/BrandPage.vue");
        },
      }, //end of brands
      {
        name: "brands-create",
        path: "brands/create",
        component: function () {
          return import("../pages/users/brands/create/CreatePage.vue");
        },
      }, //end of brands create
      {
        name: "brands-edit",
        path: "brands/edit/:title",
        component: function () {
          return import("../pages/users/brands/edit/EditPage.vue");
        },
      }, //end of brands edit
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
