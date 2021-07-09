import Vue from 'vue'
import VueRouter from 'vue-router'
import getSecret from '../views/GetSecret.vue';
Vue.use(VueRouter)

const routes = [

  {
    path: '/',
    name: 'Create secret',
    component: () => import('../views/CreateSecret.vue')
  },
  {
    path: '/get_secret',
    name: 'Get Secret',
    component: () => import('../views/GetSecret.vue')
  },
  { path: '/get_secret/:hash', component:getSecret }
];


const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
