/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./popper');

window.Vue = require('vue');

import Vuesax from 'vuesax';

import 'vuesax/dist/vuesax.css'; //Vuesax styles

import 'material-icons/iconfont/material-icons.css';

window.Vue.use(Vuesax, {
    // options here
  });

import VueCurrencyFilter from 'vue-currency-filter';

Vue.use(VueCurrencyFilter,[
    {
      symbol : '$',
      thousandsSeparator: '.',
      fractionCount: 0,
      fractionSeparator: ',',
      symbolPosition: 'front',
      symbolSpacing: true
    },
    { // default name 'currency_2'
      name: 'currency_2',
      symbol: '',
      thousandsSeparator: '.',
      fractionCount: 0,
      fractionSeparator: ',',
      symbolPosition: 'front',
      symbolSpacing: false
      //avoidEmptyDecimals: '--'
    }
    ]);

    Vue.filter('redondeo', function (value) {
        // devuelve el valor procesado
        if (!value) return ''
        value = value.toFixed(0)
        return value;
      });

      Vue.filter('redondeodec', function (value) {
        // devuelve el valor procesado
        if (!value) return ''
        value = value.toFixed(2)
        return value;
      });
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example', require('./components/ExampleComponent.vue').default);
Vue.component('bienvenida', require('./components/Bienvenida.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});
