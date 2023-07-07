/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import iView from "iview";
import "iview/dist/styles/iview.css";
import router from "./router";
import common from "./common";
import store from "./store";
import Vue from "vue";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import Multiselect from 'vue-multiselect';


// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";



Vue.use(iView);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.mixin(common);

Vue.component('multiselect', Multiselect);
Vue.component('App', require('./App.vue').default);

import "../css/global.scss";
import "../css/c.button.scss";
import "../css/c.nav.scss";
import "../css/u.display.scss";
import "../css/u.type.scss";
import "../css/c.container.scss";
import "../css/c.card.scss";
import "../css/c.tab.scss";
import "../css/c.img.scss";
import "../css/c.loader.scss";
import "../css/c.input.scss";
import "../css/c.login.scss";
import "../css/c.hero.scss";
import "../css/c.section.scss";


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router,
    store: store,
});
