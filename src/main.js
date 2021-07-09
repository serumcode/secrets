import Vue from 'vue'
import App from './App.vue'
import vuetify from '@/plugins/vuetify';
import router from './router';
import '@fortawesome/fontawesome-free/css/all.css';
import axios from 'axios';

Vue.config.productionTip = false
Vue.config.devtools = true;
Vue.config.debug = true;

const axiosInstance = axios.create({
baseURL:  process.env.VUE_APP_LOCALHOST_API_URL, 
withCredentials: true,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }
})
// prod
 //const axiosInstance = axios.create({baseURL:  window.location.protocol + '//' + window.location.hostname + '/backend/api/controller'});

Vue.prototype.$axios = axiosInstance;
export {axiosInstance};

new Vue({
  vuetify,
  router,
  render: h => h(App),
  data: {
  alert_type: "success",
  alert_text: "",
  alert_log: false,
  alert_elapse: null,
  title: ""
  },
  methods: {
    set_alert(type, text, time = 5000) {
      this.alert_type = type;
      this.alert_text = text;
      this.alert_log = true;

      let timer = this.set_alert.timer;
      if (timer) {
        clearTimeout(timer);
      }
      this.set_alert.timer = setTimeout(() => {
        this.alert_type = null;
        this.alert_log = false;
      }, time);

      this.alert_elapse = 1;
      let t = this.set_alert.t;
      if (t) {
        clearInterval(t);
      }

      this.set_alert.t = setInterval(() => {
        if (this.alert_elapse === 3) {
          this.alert_elapse = 0;
          clearInterval(this.set_alert.t);
        } else {
          this.alert_elapse++;
        }
      }, 1000);
    },
  },

}).$mount('#app')
