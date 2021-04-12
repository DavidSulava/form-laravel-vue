/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { createApp } from 'vue';


window.Vue = require('vue').default;


let app = createApp({});
app.component('feed-back-form', require('./components/FeedBackForm.vue').default);
app.mount("#app")
