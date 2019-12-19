import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import Landing from "./views/Landing.vue";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: "/whistleblower",
  routes: [
    {
      path: "/",
      name: "home",
      component: Landing
    },
    {
      path: "/form",
      name: "form",
      component: () =>
        import(/* webpackChunkName: "form" */ "./views/Home.vue")
    },
    {
      path: "/formlist",
      name: "formlist",
      props: true,
      component: () =>
        import(/* webpackChunkName: "formlist" */ "./views/FormList.vue")
    },
    {
      path: "/form/:secret",
      name: "forms",
      component: () =>
        import(/* webpackChunkName: "resultform" */ "./views/ResultForm.vue")
    },
    {
      path: "/thankyou",
      name: "thankyou",
      props: true,
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () =>
        import(/* webpackChunkName: "thankyou" */ "./views/ThankYou.vue")
    },
    {
      path: "*",
      redirect: "/"
    }
  ]
});
