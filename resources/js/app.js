/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import Toasted from 'vue-toasted';
import {
    BootstrapVue,
    IconsPlugin
} from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueProgressBar from 'vue-progressbar';
import moment from 'moment';
import Swal from 'sweetalert2';
import VueMask from 'v-mask';
import Vuetify from 'vuetify';
import CKEditor from '@ckeditor/ckeditor5-vue';


//moment.locale('pt-br');

const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}


require('./bootstrap');

window.Vue = require('vue');
window.Fire = new Vue();

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


window.swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast;
Vue.use(VueProgressBar, options);
Vue.use(VueMask);
Vue.use(Vuetify); 
Vue.use(Toasted);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use( CKEditor );

// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);


const routes = [
    {
        path: '/users',
        name: 'users',
        component: require('./components/Users.vue').default
    },

    {
        path: '/products',
        name: 'products',
        component: require('./components/Products.vue').default
    },
   
    {
        path: '/product-detail',
        name: 'product-detail',
        component: require('./components/ProductDetail.vue').default,
        props: true
    },
    {
        path: '*',
        component: require('./components/NotFound.vue').default
    }
];


// filters

Vue.filter('upText', function (text) {
    return text === null ? 'Não Informado' : text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('formatData', function (data) {
    return moment(data).format('LLL');
});



const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



const app = new Vue({
    router,
    el: '#app',
    vuetify: new Vuetify(),

  
});
