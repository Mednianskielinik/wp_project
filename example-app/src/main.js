import Vue from 'vue/dist/vue.js'
import App from './App.vue'
import VueRouter from 'vue-router'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import routes from './routes';

Vue.use(VueMaterial);

const router = new VueRouter({
    routes
});

Vue.use(VueRouter);
Vue.config.productionTip = false;

new Vue({
    router,
  render: h => h(App),
}).$mount('#app');
