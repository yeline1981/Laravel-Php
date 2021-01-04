/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//import VueKonva from 'vue-konva'

//Vue.use(VueKonva);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('base-component', require('./components/Layouts/Base.vue'));

Vue.component('crearusuario-component', require('./components/Page/Usuarios/CrearUsuario.vue').default);
Vue.component('listarusuario-component', require('./components/Page/Usuarios/ListarUsuarios.vue').default);

Vue.component('crearcliente-component', require('./components/Page/Clientes/CrearCliente.vue').default);
Vue.component('listarclientes-component', require('./components/Page/Clientes/ListarClientes.vue').default);

Vue.component('cajadiaria-component', require('./components/Page/Ventas/CajaDiaria.vue').default);
Vue.component('cajageneral-component', require('./components/Page/Ventas/CajaGeneral.vue').default);
Vue.component('facturacion-component', require('./components/Page/Ventas/Facturacion.vue').default);
Vue.component('deudores-component', require('./components/Page/Ventas/EstadoDeudores.vue').default);

Vue.component('listartrabajos-component', require('./components/Page/Trabajos/Produccion/ListarTrabajos.vue').default);

Vue.component('listarpendientes-component', require('./components/Page/Trabajos/Presupuestar/ListarSolicitudes.vue').default);
Vue.component('nuevo-component', require('./components/Page/Trabajos/Presupuestar/NuevaSolicitud.vue').default);

Vue.component('reporte-component', require('./components/Page/Reportes/ReporteGral.vue').default);
Vue.component('tendencia-component', require('./components/Page/Reportes/ReporteTendencia.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        menu: 12,
        ruta: '',
        estado: 0
    }
});
