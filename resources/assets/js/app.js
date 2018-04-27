
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.alertify = require('alertify.js');


window.Vue = require('vue');
import Vuetify from 'vuetify'
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(Vuetify)

window.Bus = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('dashboard-layout', require('./layout/DashboardLayout.vue'));
Vue.component('main-map', require('./components/Map.vue'));
Vue.component('message', require('./components/message.vue'));

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAcIcAUlACAAytFIbjQa8WoeNdRKnbufVE',
    libraries: 'places', // This is required if you use the Autocomplete plugin
  }
});

const vm = new Vue({
    el: '#app',
    data: {
        arr: [
            {n:1},{n:2},{n:3}
        ]
    },
    methods: {
        add: function(){
            console.log('add');
        }
    }
});
