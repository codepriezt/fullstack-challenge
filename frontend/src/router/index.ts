import { createRouter, createWebHashHistory } from "vue-router";
import UserView from "../views/UserView.vue";
import LoginView from "../views/LoginView.vue";
import Layout from "../layouts/AdminLayout.vue";

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "",
      name: "home",
      component: Layout,
      children: [
        {
          path: "/users",
          name: "home",
          component: UserView,
        },
      ],
    },

    {
      path: "/login",
      name: "login",
      component: LoginView,
    },
  ],
});

export default router;
