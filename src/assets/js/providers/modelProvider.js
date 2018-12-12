import axios from 'axios';
import _ from 'lodash';
import htmlform2json from 'htmlform2json';

const Provider = {
    

    install(Vue, options) {
        
        Vue.prototype.$parse = (form => {
            return htmlform2json(form);
        });

        Vue.prototype.$changeUrl = (url) => {
            options.url = url
        }

        Vue.prototype.$getUrl = (url = false) => {
            return options.url+'/'+url;
        }

        Vue.prototype.$get = (cb) => {
            return axios.get(options.url+'/get')
                        .then(resp => {
                            if(cb)
                                cb(resp.data);
                        });
        }

        Vue.prototype.$getSingle = ((data,cb=false) => {
            if(!data.id)    throw 'Can not execute function with the propper data ID attribute.';

            console.log('Executing single search query:',options.url);

            return axios.get(options.url+'/single/'+data.id)
                        .then(resp => {
                            console.log('resp:',resp);
                            if(cb)
                                cb(resp.data);
                        });
        });
        Vue.prototype.$create = (raw, cb = false) => {
            let data = new FormData();
            for (let key in raw) {
                data.append(key, raw[key]);
            }
            return axios.post(options.url+'/create', data)
                        .then(resp => {
                            if(cb)
                                cb(resp.data);
                        });
        };

        Vue.prototype.$update = (id, raw, cb = false) => {
            let data = new FormData();
            for (let key in raw) {
                data.append(key, raw[key]);
            }
            return axios.post(options.url+'/update/'+id, data)
                        .then(resp => {
                            if(cb)
                                cb(resp.data);
                        });
        };
        
        Vue.prototype.$delete = (id, cb = false) => {
            return axios.post(options.url+'/delete/'+id)
                        .then(resp => {
                            cb(resp.data);
                        });
    
        };

        Vue.prototype.$call = (url, raw, cb) => {
            let data = new FormData();
            for (let key in raw) {
                data.append(key, raw[key]);
            }
            return axios.post(options.url+url,data)
                        .then(resp => {
                            cb(resp.data);
                        });
        }

        Vue.prototype.$callGet = (url, cb) => {
            return axios.get(options.url+url).then(resp => {
                cb(resp.data);
            });
        };
    },

}

export default Provider;