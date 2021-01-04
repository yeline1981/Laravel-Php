<template>

    <div class="col-md-12">

        <div class="form-group row justify-content-center" v-if="modo!=0">
            <label class="col-md-2 col-form-label" for="pa_tipo">Tipo *</label>
            <div class="col-md-6">
                <input v-model="tipotrabajo" class="form-control" type="text" disabled >
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_papel">Papel *</label>
            <div class="col-md-6">
                <select id="pa_papel" class="form-control" v-model="papel" data-show_option_none="yes" >
                    <option value="" disabled>Seleccioná</option>
                    <option value="Común 75 grs" >Común 75 grs</option>
                    <option value="Común 90 grs" >Común 90 grs</option>
                    <option value="Común 180 grs" >Común 180 grs</option>
                    <option value="Mate 90 grs" >Mate 90 grs</option>
                    <option value="Mate 180 grs" >Mate 180 grs</option>
                    <option value="Brillante 90 grs" >Brillante 90 grs</option>
                    <option value="Brillante 130 grs" >Brillante 130 grs</option>
                    <option value="Brillante 180 grs" >Brillante 180 grs</option>
                    <option value="Transparente" >Transparente</option>
                    <option value="Otros" >Otros</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">

            <label class="col-md-2 col-form-label" for="pa_formato">Formato (cms)*</label>
            <div class="col-md-6">
                <select id="pa_formato" class="form-control" v-model="formato" data-show_option_none="yes">
                    <option value="" disabled>Seleccioná</option>
                    <option value="21x29.7 cms A4">21x29.7 cms (A4)</option>
                    <option value="32x45 cms Super A3">32x45 cms (Super A3)</option>
                    <option value="29.7x42 cms A3">29.7x42 cms (A3)</option>
                    <option value="18x24 Pul ARCH C">18x24 Pul ARCH C</option>
                    <option value="59.4x84.1 cms A1">59.4x84.1 cms (A1)</option>
                    <option value="A medida" >A medida</option>
                </select>
                <div v-if="formato === 'A medida'" class="row Otros">
                    <input class="form-control col-md-2 separar" type="text" v-model="base" placeholder="base"/> x
                    <input class="form-control col-md-2 separar" type="text" v-model="altura" placeholder="altura"/>
                    <span>cms</span>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_impresion-frente">Impresión*</label>
            <div class="col-md-6">

                <select id="pa_impresion-frente" class="form-control" v-model="frente" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Negro" >Negro</option>
                    <option value="Color" >Color</option>
                    <option value="Negro Pleno" >Negro Pleno</option>
                    <option value="Color Pleno" >Color Pleno</option>
                </select>

            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_sangrado">Sangrado*</label>
            <div class="col-md-6">
                <select id="pa_sangrado" class="form-control" v-model="sangrado" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Si" >Si</option>
                    <option value="No" >No</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_contenido">Contenido*</label>
            <div class="col-md-6">
                <select id="pa_contenido" class="form-control" v-model="contenido" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Sólo texto" >Sólo texto</option>
                    <option value="texto e imagen" >Texto e imagen</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_diseno">Diseño *</label>
            <div class="col-md-6">
                <select id="pa_diseno" class="form-control" v-model="diseno" name="attribute_pa_diseno" data-attribute_name="attribute_pa_diseno" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Diseñar" >Necesito que me resuelvan el diseño</option>
                    <option value="No Diseñar" >Ya trae el archivo listo para imprimir</option>
                    <option value="Reimprimir" >Reimprimir</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_cantidades-a-cotizar-minimo">Cantidades a Cotizar*</label>
            <div class="col-md-6">
                <input v-model.number="cantidad" class="form-control" type="number" min="10" step="1">
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="detalles">Observaciones</label>
            <div class="col-md-6">
                <textarea class="form-control" v-model="detalles" rows="10" ></textarea>
            </div>
        </div>

    </div>

</template>

<script>

import EventBus from "@/EventBus";

export default {
    name: 'Afiches',

    props: {
        ruta: String,
        modo:{type: Number,
             required: true}, //0-presupuestar 1-update
        datos: {type: Object, default: null},
        idgrupo: Number
	},
    data(){
        return {

            id: '',
            diseno: '',
            cantidad: '',
            detalles: '',
            idtipotrabajo : '',
            tipotrabajo : '',
            papel: ''  ,
            formato: '' ,
            sangrado: '',
            frente: '',
            contenido: '',
             base: '',
            altura: '',

            errorMostrarMsjAviso: [],

        }
    },

    methods: {

        validarTrabajo(){
                var errorAviso = 0;
                this.errorMostrarMsjAviso = [];

                if (!this.papel) this.errorMostrarMsjAviso.push("Falta el tipo de papel.");
                if (!this.formato) this.errorMostrarMsjAviso.push("Falta el formato.");
                if (this.diseno === '') this.errorMostrarMsjAviso.push("Faltan datos de diseño.");
                if (!this.frente) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
                if (!this.sangrado) this.errorMostrarMsjAviso.push("Faltan datos de sangrado.");
                if (!this.contenido) this.errorMostrarMsjAviso.push("Faltan el contenido.");
                if (!this.cantidad) this.errorMostrarMsjAviso.push("Falta la cantidad.");

                if (this.errorMostrarMsjAviso.length) errorAviso = 1;
                return errorAviso;
        },
        Crear(){

            if (this.validarTrabajo()){
                console.log('error validacion');
                EventBus.$emit('ErrorValidacion', this.errorMostrarMsjAviso);
                return;
            }

            let me = this;

            if (me.formato === 'A medida'){
                me.detalles = 'Formato: ' + me.base + 'x' + me.altura + ' cms\n' + me.detalles ;
            }

            axios.post(me.$parent.ruta + '/presupuestos/store', {
                'idtipotrabajo': this.idtipotrabajo,
                'papel': this.papel,
                'formato': this.formato,
                'diseno': this.diseno,
                'contenido': this.contenido,
                'detalles': this.detalles,

                'frente': this.frente,
                'sangrado': this.sangrado,
                'cantidad': this.cantidad,

            })
            .then(function (response) {
                // handle success
                console.log(response);
                me.$emit('respuesta', response.data.trabajo);
                EventBus.$emit('Creado', response.data.trabajo );
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
            });
        },
        Actualizar(){

            if (this.validarTrabajo()){
                console.log('error validacion');
                EventBus.$emit('ErrorValidacion', this.errorMostrarMsjAviso);
                return;
            }

            let me = this;
            var url = '/presupuestos/update';

            if (me.modo == 3){
                url = '/trabajos/update';
            }

            if (me.formato === 'A medida'){
                me.detalles = 'Formato: ' + me.base + 'x' + me.altura + ' cms\n' + me.detalles ;
            }

            axios.post(me.ruta + url, {
                'id': this.id,
                'papel': this.papel,
                'formato': this.formato,
                'diseno': this.diseno,
                'contenido': this.contenido,
                'detalles': this.detalles,

                'frente': this.frente,
                'sangrado': this.sangrado,
                'cantidad': this.cantidad,

            })
            .then(function (response) {
                // handle success
                console.log(response);
                me.$emit('respuesta', response.data.trabajo);
                if (me.modo===3){
                    console.log('Modificando');
                    EventBus.$emit('Modificado', response.data.trabajo );
                }
                else{
                    console.log('Actualizando');
                    EventBus.$emit('Actualizado', response.data.trabajo );
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
            });
        },
        Inicializar(){

            if (this.datos !== null)
            {
                console.log('Iniciando');
                this.id = this.datos.id;
                this.tipotrabajo = this.datos.tipotrabajo;
                this.papel= this.datos.papel;
                this.formato= this.datos.formato;
                this.diseno= this.datos.diseno;
                this.contenido= this.datos.contenido;
                this.detalles= this.datos.detalles;

                this.frente= this.datos.frente;
                this.sangrado= this.datos.sangrado;
                this.cantidad= this.datos.cantidad;
            }
            else
                this.getTipos();
        },
        getTipos(){
            let me = this;
            var url= me.ruta + '/productos/grupos/tipos?id=' + me.idgrupo;
            axios.get(url)
            .then(function (response) {
                // handle success
                console.log(response);
                var respuesta= response.data;
                me.idtipotrabajo= respuesta.productos[0].id;
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
            });
        }


    },
    created(){
            this.Inicializar();

            EventBus.$on('Crear_Afiches', (data) => {
                console.log('Escuchando Crear_Afiches');
                this.Crear();
            });

            EventBus.$on('Actualizar_Afiches', (data) => {
                console.log('Escuchando Actualizar_Afiches');
                this.Actualizar();
            });

            EventBus.$on('Modificar_Afiches', (data) => {
                console.log('Escuchando Modificar_Afiches');
                this.Actualizar();
            });
    }
}
</script>

<style scoped>

    .Otros {
        padding-top: 1rem;
    }
    .separar{
        margin-left: 1rem;
        margin-right: 1rem;
    }
</style>
