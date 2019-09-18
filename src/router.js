import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import Landing from "./views/Landing.vue";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
      path: "/result",
      name: "result",
      props: true,
      component: () =>
        import(/* webpackChunkName: "about" */ "./views/ResultForm.vue")
    },
    {
      path: "/thankyou",
      name: "thankyou",
      props: true,
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () =>
        import(/* webpackChunkName: "about" */ "./views/ThankYou.vue")
    },
    {
      path: "*",
      redirect: "/"
    }
  ]
});
