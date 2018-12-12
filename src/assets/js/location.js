import modelProvider from './providers/modelProvider';
Vue = window.Vue;

Vue.use(modelProvider,{url:'api/field'});
Vue.component('location-modal',require('./components/locations/location-modal.vue'));

const el = new Vue({
    el: '#app',
    
});