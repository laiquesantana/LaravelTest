import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)


const routes = [
    {
        path: '/users',
        name: 'users',
        component: require('../components/Users.vue').default
    },

    {
        path: '/products',
        name: 'products',
        component: require('../components/Products.vue').default
    },
   
    {
        path: '*',
        component: require('../components/NotFound.vue').default
    }
];



const router = new VueRouter({
    routes,
    mode: 'history'
})

export default router