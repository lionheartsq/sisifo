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

// main.js
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

Vue.directive('focus', {
    // Cuando el elemento enlazado se inserta en el DOM...
    inserted: function (el) {
      // Enfoca el elemento
      el.focus()
    }
  });

  import VueTypeaheadBootstrap from 'vue-typeahead-bootstrap';

  // Required dependency of bootstrap css/scss files
  import 'bootstrap/scss/bootstrap.scss';

  // Global registration
  Vue.component('vue-typeahead-bootstrap', VueTypeaheadBootstrap);

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
Vue.component('facturacion', require('./components/Facturacion.vue').default);
Vue.component('asientos', require('./components/Asientos.vue').default);
Vue.component('asociacion', require('./components/Asociacion.vue').default);
Vue.component('ciudades', require('./components/Ciudades.vue').default);
Vue.component('clientes', require('./components/Clientes.vue').default);
Vue.component('cobros', require('./components/Cobros.vue').default);
Vue.component('cobrosasientos', require('./components/Cobrosasientos.vue').default);
Vue.component('departamentos', require('./components/Departamentos.vue').default);
Vue.component('detallefacturas', require('./components/Detallefacturas.vue').default);
Vue.component('detallepedidos', require('./components/Detallepedidos.vue').default);
Vue.component('empresa', require('./components/Empresa.vue').default);
Vue.component('facturas', require('./components/Facturas.vue').default);
Vue.component('grupos', require('./components/Grupos.vue').default);
Vue.component('impuesto', require('./components/Impuesto.vue').default);
Vue.component('libromayor', require('./components/Libromayor.vue').default);
Vue.component('medida', require('./components/Medida.vue').default);
Vue.component('pagos', require('./components/Pagos.vue').default);
Vue.component('pagosasientos', require('./components/Pagosasientos.vue').default);
Vue.component('pedidos', require('./components/Pedidos.vue').default);
Vue.component('productos', require('./components/Productos.vue').default);
Vue.component('proveedores', require('./components/Proveedores.vue').default);
Vue.component('registros', require('./components/Registros.vue').default);
Vue.component('roles', require('./components/Roles.vue').default);
Vue.component('tipofactura', require('./components/Tipofactura.vue').default);
Vue.component('tipologia', require('./components/Tipologia.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);

Vue.component('empleados', require('./components/Empleados.vue').default);
Vue.component('control', require('./components/Control.vue').default);
Vue.component('historico', require('./components/Historico.vue').default);
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
