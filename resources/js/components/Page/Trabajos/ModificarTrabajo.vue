<template>
    <div class="col-lg-12">
        <div class="card">
                <div class="card-header">
                <i class="fa fa-align-justify"></i> {{title}}
                </div>

                <div class="card-body">
                    <descripcion-trabajo :ruta="ruta" :modo="modo"
                                         :componentName="datos.grupo"
                                         :datos="datos" v-if="datos != null"></descripcion-trabajo>
                </div>
        </div>
    </div>
</template>

<script>


import EventBus from "@/EventBus";
import DescripcionTrabajo from './Descripcion/DescripcionTrabajo';

    export default {
        name: 'ModificarTrabajo',
        props: {
            ruta: String,
            datos: Object,
            modo: Number
        },
        components: {
          'descripcion-trabajo': DescripcionTrabajo
        },
        data () {
            return {
                titleD: ''
            }
        },
        methods: {

        },
        created: function() {

            console.log('ModificarTrabajo');

            if (this.modo === 2)
                this.title = 'Actualizar Solicitud - ' + this.datos.friendly_name;

            if (this.modo === 3)
                this.title = 'Ver Trabajo';

            //this.titleD = this.datos.grupo;
        }

    }
</script>

