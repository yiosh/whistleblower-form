import Vue from "vue";
import "./plugins/vuetify";
import App from "./App.vue";
import UploadButton from "vuetify-upload-button";

Vue.use(UploadButton);

Vue.config.productionTip = false;

new Vue({
  render: h => h(App)
}).$mount("#app");
