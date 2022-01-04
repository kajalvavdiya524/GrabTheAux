
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
import VueAudio from 'vue-audio-better'
Vue.use(VueAudio)

// import App from './App.vue';
Vue.use(VueAxios, axios);
import Meeting from './components/Meeting';


const routes = [

  {
    path: '/meeting',
    name: 'meeting',
    component: Meeting
  }

];

const router = new VueRouter({
  mode: 'history',
  routes: routes
});


Vue.component('meeting-component', require('./components/Meeting.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');


const app = new Vue({
    el: '#app',
});
