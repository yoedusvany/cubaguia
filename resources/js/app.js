require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();

import VeeValidate from 'vee-validate';
import VueSweetalert2 from 'vue-sweetalert2';
import VueSlideoutPanel from 'vue2-slideout-panel';

Vue.use(VueSlideoutPanel);

Vue.use(VeeValidate);
Vue.use(VueSweetalert2);


//COMPONENTS
Vue.component('contact-component', require('./components/contacts/ContactComponent.vue').default);
Vue.component('excursion-component', require('./components/excursiones/ExcursionComponent.vue').default);

const appBackend = new Vue({
    el: '#app'
});


