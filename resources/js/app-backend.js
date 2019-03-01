require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();

import VeeValidate from 'vee-validate';
import VueRouter from 'vue-router';
import VueSweetalert2 from 'vue-sweetalert2';
import VueNumeric from 'vue-numeric';

Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(VueSweetalert2);
Vue.use(VueNumeric);


const LugarList = Vue.component('lugar-list', require('../js/components/lugar/LugarListComponent').default);
const LugarAdd = Vue.component('lugar-add', require('../js/components/lugar/LugarAddComponent').default);

const ExcursionList = Vue.component('excursion-list', require('../js/components/excursiones/backend/ListExcursionsComponent').default);
const ExcursionAdd = Vue.component('excursion-add', require('../js/components/excursiones/backend/AddExcursionComponent').default);

const routes = [
    {
        path: '/contact', component: require('./components/contacts/ListContactsComponent').default
    },
    {
        path: '/excursion', component: require('./components/excursiones/backend/ExcursionBackendComponent').default,
        children: [
            {
                path: '',
                component: ExcursionList },
            {
                path: 'add/:id?',
                name: 'excursionAdd',
                component: ExcursionAdd
            },
            {
                path: 'list',
                component: ExcursionList
            }
        ]
    },
    {
        path: '/lugar', component: require('./components/lugar/LugarComponent').default,
        children: [
            { path: '', component: LugarList },
            {
                path: 'add/:id?',
                name: 'lugarAdd',
                component: LugarAdd
            },
            {
                path: 'list',
                component: LugarList
            }
        ]
    }
];

const router = new VueRouter({
    mode: 'history',
    hashbang: false,
    routes // short for `routes: routes`
});



const appBackend = new Vue({
    el: '#app',
    router
});

