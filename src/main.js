import Vue from "vue";
import "./plugins/vuetify";
import App from "./App.vue";
import UploadButton from "vuetify-upload-button";
import router from "./router";
import { VueReCaptcha } from "vue-recaptcha-v3";

// For more options see below
Vue.use(VueReCaptcha, {
  siteKey: "6LeTIsgUAAAAALbdlQnvnIxy8UxCB81PRYnZ0Leg"
});

Vue.use(UploadButton);

Vue.config.productionTip = false;

new Vue({
  router,
  render: h => h(App)
}).$mount("#app");
