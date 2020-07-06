import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from 'axios'
import VueAxios from 'vue-axios'
import "./registerServiceWorker";

Vue.config.productionTip = false;

//axios.defaults.baseURL = 'http://localhost/';
axios.defaults.baseURL = 'http://13.113.68.244/'

Vue.use(VueAxios, axios)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
