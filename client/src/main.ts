import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from 'axios'
import VueAxios from 'vue-axios'
import "./registerServiceWorker";

Vue.config.productionTip = false;

axios.defaults.baseURL = 'https://voooice.herokuapp.com/';


Vue.use(VueAxios, axios)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
