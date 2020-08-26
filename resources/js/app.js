require('./bootstrap');
window.Swal = require('sweetalert2');

window.Vue = require('vue');

Vue.component('autocomplete-component', require('./components/AutoCompleteComponent.vue').default);

const app = new Vue({
    el: '#app',
});
