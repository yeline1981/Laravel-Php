<template>
<keep-alive exclude="modificarcliente">
    <main class="main" style="padding: 0px !important">
        <!-- Breadcrumb-->
        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">

            <div v-show="modo">
                <ver-cliente :ruta="ruta"></ver-cliente>
            </div>
            <div>
              <modificar-cliente :ruta="ruta"></modificar-cliente>
            </div>

        </div>

      </main>
</keep-alive>
</template>

<script>

import EventBus from '../../../EventBus'

import ModificarCliente  from './ModificarCliente'
import VerClientes  from './VerClientes'
import Notifications from "@/components/Layouts/Notifications";
import Base from "@/components/Layouts/Base";

    export default {
    name: 'ListarClientes',
    props : ['ruta'] ,
    extends: Base,
    components: {
        'modificar-cliente': ModificarCliente,
        'ver-cliente': VerClientes,
        'notification-component': Notifications
    },

      data(){
        return {
            modo: 1,
            //texto: '',
        }
      },

      methods: {

      },
      created : function(){

        EventBus.$on('ModificarCliente', (item) => {

             this.errorMostrarMsj = [];

             if (item.id === 0){
               this.textonotificar = 'Actualizado cliente';
               this.showAlert(1) ;
             }
             else if (item.id === 1){

               this.errorMostrarMsj.push(item.msg);
               this.showAlert(2);
             }

             this.modo = 1;
             EventBus.$emit('ListarClientes', 1);
        });

      }
    }
</script>


