require('./bootstrap');
window.Swal = require('sweetalert2');

window.Vue = require('vue');

Vue.component('autocomplete-component', require('./components/AutoCompleteComponent.vue').default);
Vue.component('table-campaigns-donors-component', require('./components/TableComponent.vue').default);

const app = new Vue({
    el: '#app',
});
