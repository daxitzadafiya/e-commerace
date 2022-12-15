import Vue from "vue";
import router from "vue-router";
// import store from "@/store.js";

import Login from "@/pages/auth/Login";
import Home from "@/pages/Home";
import Register from "@/pages/auth/Register";
import addProduct from "@/pages/product/addProduct";
import product from "@/pages/product/index";
import variant from "@/pages/productVariant/index";
import addProductVariant from "@/pages/productVariant/addProductVariant";

Vue.use(router);

const route = new router({
  mode: "history",
  routes: [
    {
      path: "",
      name: "Home",
      component: Home,
      meta: {
        public: true,
      },
    },
    {
      path: "/login",
      name: "Login",
      component: Login,
      meta: {
        public: true,
      },
    },
    {
      path: "/register",
      name: "Register",
      component: Register,
      meta: {
        public: true,
      },
    },
    {
      path: "/product/create",
      name: "AddProduct",
      component: addProduct,
      meta: {
        public: true,
      },
    },
    {
      path: "/product",
      name: "product",
      component: product,
      meta: {
        public: false,
      },
    },
    {
      path: "/product/:id",
      name: "updateProduct",
      component: addProduct,
      meta: {
        public: true,
      },
    },
    {
      path: "/variant",
      name: "variant",
      component: variant,
      meta: {
        public: true,
      },
    },
    {
      path: "/variant/create",
      name: "AddVariant",
      component: addProductVariant,
      meta: {
        public: true,
      },
    },
    {
      path: "/variant/:id",
      name: "updateVariant",
      component: addProductVariant,
      meta: {
        public: true,
      },
    },
  ],
});

// Auth guard
// route.beforeEach((to, from, next) => {
//   const authRequired = !to.matched.some((record) => record.meta.public);
//   const loggedIn = store.getters.isLoggedIn;
//   console.log(loggedIn);
//   console.log(authRequired);

//   if (authRequired && !loggedIn) {
//     if (!authRequired && loggedIn) {
//       next("/");
//       return;
//     } else {
//       next({
//         path: "/login",
//         query: { redirect: to.fullPath },
//       });
//     }
//   }
//   next();
// });

export default route;
