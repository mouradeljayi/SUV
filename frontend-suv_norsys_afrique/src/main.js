import Vue from "vue";
import App from "./App";
import router from "./router/index";

import PaperDashboard from "./plugins/paperDashboard";
import "vue-notifyjs/themes/default.css";
import axios from "axios";
import VueAxios from "vue-axios";
import GlobalComponents from "@/plugins/globalComponents";
import GlobalDirectives from "@/plugins/globalDirectives";

import {BootstrapVue} from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import vueCountriesCities from "vue-countries-cities";

Vue.use(PaperDashboard);
Vue.use(VueAxios, axios);
Vue.use(GlobalComponents);
Vue.use(GlobalDirectives);
Vue.component("countriesCities", vueCountriesCities);

Vue.use(BootstrapVue);

axios.defaults.baseURL = "http://localhost:98/";

/* eslint-disable no-new */
new Vue({
  router,
  render: h => h(App)
}).$mount("#app");
