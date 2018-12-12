import modelProvider from './providers/modelProvider';
import uploader from 'vue-simple-uploader';
import VueClip from 'vue-clip';

Vue = window.Vue;

Vue.use(modelProvider,{url:'/api/survey'});
Vue.use(uploader);
Vue.use(VueClip);
Vue.component('single-survey',require('./components/survey/single.vue'));

const el = new Vue({
    el: '#app',
    
});