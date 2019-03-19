require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();

import VeeValidate from 'vee-validate';
import VueSweetalert2 from 'vue-sweetalert2';
import VueSlideoutPanel from 'vue2-slideout-panel';
import { i18n } from './i18n';

Vue.use(VueSlideoutPanel);
Vue.use(VeeValidate);
Vue.use(VueSweetalert2);


//COMPONENTS
Vue.component('contact-component', require('./components/contacts/ContactComponent.vue').default);
Vue.component('excursion-component', require('./components/excursiones/ExcursionComponent.vue').default);
Vue.component('footer-contact-details', require('./components/footer/FooterContactDataComponent').default);
Vue.component('servicios', require('./components/services/ServiciosFrontendComponent').default);

const app = new Vue({
    i18n,
    el: '#app'
});


