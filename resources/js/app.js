require('./bootstrap');
import Vue from 'vue';
import store from '@/configs/store';
import router from '@/configs/router';
import component from '@/components'
import App from './App.vue';
import moment from 'moment';


Vue.use(component)
Vue.prototype.$moment = moment

const app = new Vue(Vue.util.extend({ router, store}, App)).$mount('#app');
