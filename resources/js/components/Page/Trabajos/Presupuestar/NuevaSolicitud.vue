<template>
    <main class="main">

        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">

            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <i class="fa fa-edit"></i>Solicitud Trabajo {{ friendly }}</div>
                    <div class="card-body">
                        <form class="form-horizontal" >


                        <grupo-trabajo v-if="grupo===null"
                                       :ruta="ruta" v-on:grupo="NextStep">
                        </grupo-trabajo>

                        <descripcion-trabajo v-else
                                                :ruta="ruta" :modo="0"
                                                :componentName="grupo" :idgrupo="idgrupo"
                                                v-on:done="showOK">
                        </descripcion-trabajo>


                        </form>
                    </div>
                </div>
              </div>

            </div>


       </div>
    </main>

</template>

<script>

import GrupoTrabajo from './GrupoTrabajo';
import DescripcionTrabajo from '@/components/Page/Trabajos/Descripcion/DescripcionTrabajo';
import Notifications from "@/components/Layouts/Notifications";
import Base from "@/components/Layouts/Base";

import EventBus from "@/EventBus";

export default {

    name: 'Solicitar',
    props : {
              ruta: String
    },
    extends: Base,
    components: {
        'descripcion-trabajo': DescripcionTrabajo,
        'grupo-trabajo': GrupoTrabajo,
        'notification-component': Notifications
    },
    data(){
        return {
            ok: 0,
            grupo: null,
            friendly: null,
            title: 'Características'
        }
    },
    methods: {

        NextStep(item){
            console.log('Escucho producto');
            this.grupo = item.grupo;
            this.idgrupo = item.id;
            this.friendly = ': ' + item.friendly_name;
        },
        showOK(){
            this.textonotificar = '';
            this.showAlert(1);
        }

    },
    created(){
        EventBus.$on('Creado', item => {
            console.log('Creado en NuevaSolicitud');

            this.textonotificar = 'Nueva solicitud agregada';
            this.showAlert(1);
            EventBus.$emit('Limpiar', null);
            this.grupo = null;
        });

        EventBus.$on('ErrorValidacion', (item) => {
            console.log('escucho error validacion')
            this.errorMostrarMsj = item;
            this.showAlert(2);
        });

    }

}
</script>

<style>

    fieldset:disabled {
        background:#ccc !important;
        background-color: #ccc !important;
        opacity: 4 !important;
    }

</style>
