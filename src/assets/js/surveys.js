import modelProvider from './providers/modelProvider';
Vue = window.Vue;

Vue.use(modelProvider,{url:'api/survey'});
Vue.component('survey-modal',require('./components/survey/interface.vue'));

const el = new Vue({
    el: '#app',
    
});