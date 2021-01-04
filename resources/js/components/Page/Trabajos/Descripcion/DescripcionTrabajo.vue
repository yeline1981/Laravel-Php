<template>
    <div class="card">

        <div class="card-body">
            <h2> Características </h2>

            <div class="col-md-12">

                <description-content :componentName="componentName" :modo="modo" :ruta="ruta" :datos="datos" :idgrupo="idgrupo"></description-content>

            </div>
        </div>

        <description-footer :modo="modo" @action="Action" :estado="idestado"></description-footer>

    </div>
</template>


<script>

import DescriptionContent from './Content';
import DescriptionFooter from './Footer';
import EventBus from "@/EventBus";

export default {
    name: 'DescripcionTrabajo',
    props: {
        modo: Number,
		componentName: {
			type: String,
			required: true
        },
        ruta: String,
        datos: {type: Object, default: null},
       // title: String,
        idgrupo: Number
    },
    components: {
        DescriptionContent, DescriptionFooter
    },
    computed: {

	},
    data () {
        return {
            idestado: null
        }
    },
    methods: {
        Action(newValue) {
            console.log('Accion seteada');
            switch (newValue) {
                case 1:
                    this.Crear();
                    break;
                case 2:
                    this.Actualizar();
                    break;
                case 3:
                    this.Cancelar();
                    break;
                case 4:
                    this.Estado();
                    break;
                case 5:
                    this.Salir();
                    break;
                case 6:
                    this.Mostrando();
                    break;
                case 7:
                    this.Modificar();
                    break;
                default:
                    console.log('Lo lamentamos, por el momento no disponemos de ' + expr + '.');
            }
        },
        Cancelar(){
           window.location.href = this.ruta + '/main';
        },
        Salir(){
            if (this.modo == 3)
                EventBus.$emit('VerTrabajos', 1);
            else
                EventBus.$emit('VerSolicitudes', 1);
        },
        Estado(){
           let me = this;

            axios.put(me.ruta + '/trabajos/' + me.datos.id + '/done',{
            })
            .then(function (response) {
                // handle success
                console.log(response);
                EventBus.$emit('VerTrabajos', 1);
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
            });
        },
        Mostrando(){
           let me = this;

            axios.put(me.ruta + '/trabajos/' + me.datos.id + '/display',{
            })
            .then(function (response) {
                // handle success
                console.log(response);
                EventBus.$emit('VerTrabajos', 1);
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
            });
        },
        Crear(){
            console.log('Llamando crear ' + this.componentName);
            EventBus.$emit('Crear_' + this.componentName );
        },
        Actualizar(){
            console.log('Llamando actualizar ' + this.componentName);
            EventBus.$emit('Actualizar_' + this.componentName );
        },
        Modificar(){
            console.log('Llamando modificar ' + this.componentName);
            EventBus.$emit('Modificar_' + this.componentName );
        },


    },
    created: function() {
        console.log('DescripcionTrabajo');
        if (this.datos !== null){
            this.idestado = this.datos.idestado;
        }

    }


}
</script>


