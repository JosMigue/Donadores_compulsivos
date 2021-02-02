var VuePaginate = require('vue-paginate')
require('./bootstrap');
window.Swal = require('sweetalert2');

window.Vue = require('vue');

Vue.component('quiz-component', require('./components/QuizDonationComponent.vue').default);
Vue.component('dayofweek-component', require('./components/DaysOfTheWeekComponent.vue').default);
Vue.component('autocomplete-component', require('./components/AutoCompleteComponent.vue').default);
Vue.component('table-campaigns-donors-component', require('./components/TableComponent.vue').default);
Vue.component('modal-donor-component', require('./components/ModalDonorsComponent.vue').default);
Vue.component('filters-donors-component', require('./components/AdvancedFilterComponent.vue').default);
Vue.component('datatable-temporal-donors-component', require('./components/TemporalDonorDataTableComponent.vue').default);
Vue.component('create-donor-component', require('./components/CreateDonorComponent.vue').default);
Vue.component('individual-donation-component', require('./components/IndividualDonationComponent.vue').default);
Vue.component('individual-donation-create-component', require('./components/ModalIndividualDOnationCreateComponent.vue').default);
Vue.component('camera-driver-component', require('./components/CameraComponent.vue').default);
Vue.component('modal-predonor-asign-component', require('./components/ModalAsignPreDonorCampaign.vue').default);
Vue.component('modal-donor-asign-component', require('./components/ModalAsignDonorCampaign.vue').default);
Vue.use(VuePaginate)
Vue.config.productionTip = false;

const app = new Vue({
    el: '#app',
});
