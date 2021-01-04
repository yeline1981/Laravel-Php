<template>

    <div class="col-md-12">

        <div class="form-group row justify-content-center" v-if="modo!=0">
            <label class="col-md-2 col-form-label" for="pa_tipo">Tipo *</label>
            <div class="col-md-6">
                <input v-model="tipotrabajo" class="form-control" type="text" disabled >
            </div>
        </div>
        <div class="form-group row justify-content-center" v-else>
            <label class="col-md-2 col-form-label" for="pa_tipo">Tipo *</label>
            <div class="col-md-6">
                <select class="form-control" v-model.number="idtipotrabajo">
                        <option values="0">Seleccione</option>
                        <option v-for="tipo in arrayTipos" :key="tipo.id" :value="tipo" v-text="tipo.tipo"></option>
                    </select>
            </div>
        </div>

        <!-- Hojas membretadas -->
        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_papel">Papel* </label>
            <div class="col-md-6">
                <select id="pa_papel" class="form-control" v-model="papel" data-show_option_none="yes" >
                    <option value="" disabled>Seleccione</option>
                    <option value="Común blanco 75grs" >Común blanco 75grs.</option>
                    <option value="Común blanco 100grs" >Común blanco 100grs.</option>
                    <option value="Otros" >Otros</option>
                </select>
            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_formato">Formato (cms)*</label>
            <div class="col-md-6" v-if="idtipotrabajo.tipo==='Hojas Membretadas'">
                <select id="pa_formato" class="form-control" v-model="formato">
                    <option value="" disabled>Seleccione</option>
                    <option value="21x29.7 cms A4">21x29.7 cms (A4)</option>
                    <option value="21.5x35.5 cms Oficio">21.5x35.5 cms (Oficio)</option>
                    <option value="21.5x27.9 cms Carta">21.5x27.9 cms (Carta)</option>
                </select>
            </div>
            <div class="col-md-6" v-else-if="idtipotrabajo.tipo==='Sobres'">
                <select id="pa_formato" class="form-control" v-model="formato">
                    <option value="" disabled>Seleccione</option>
                    <option value="23,5x12cms" >23,5x12cms</option>
                    <option value="22,9x32,4cms" >22,9x32,4cms</option>
                    <option value="22,9x11,4cms" >22,9x11,4cms</option>
                    <option value="25x36cms" >25x36cms</option>
                    <option value="A medida" >A medida</option>
                </select>
            </div>
            <div class="col-md-6" v-else>
               <select id="pa_formato" class="form-control" v-model="formato">
                    <option value="" disabled>Seleccione</option>
                    <option value="23,5x12cms" >23,5x12cms</option>
                    <option value="22,9x32,4cms" >22,9x32,4cms</option>
                    <option value="22,9x11,4cms" >22,9x11,4cms</option>
                    <option value="25x36cms" >25x36cms</option>
                    <option value="A medida" >A medida</option>
                </select>
            </div>
            <div v-if="formato === 'A medida'" class="row Otros col-md-6">
                <input class="form-control col-md-2 separar" type="text" v-model="base" placeholder="base"/> x
                <input class="form-control col-md-2 separar" type="text" v-model="altura" placeholder="altura"/>
                <span>cms</span>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_impresion-frente">Impresión Frente*</label>
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
            <label class="col-md-2 col-form-label" for="pa_impresion-dorso">Impresión Dorso*</label>
            <div class="col-md-6">
                <select id="pa_impresion-dorso" class="form-control" v-model="dorso" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Sin impresión" >Sin Impresión</option>
                    <option value="Negro" >Negro</option>
                    <option value="Color" >Color</option>
                    <option value="Negro Pleno" >Negro Pleno</option>
                    <option value="Color Pleno" >Color Pleno</option>
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


        <div class="form-group row justify-content-center" v-if="idtipotrabajo.tipo!=='Hojas Membretadas'">
            <label class="col-md-2 col-form-label" for="pa_solapa">Solapa (sobres y carpetas)</label>
            <div class="col-md-6">
                <select id="pa_solapa" class="form-control" v-model="solapa" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Sin solapa" >Sin solapa</option>
                    <option value="Una solapa impresa" >Una solapa impresa</option>
                    <option value="Doble solapa impresa" >Doble solapa impresa</option>
                    <option value="Una solapa sin impresión" >Una solapa sin impresión</option>
                    <option value="Doble solapa sin impresión" >Doble solapa sin impresión</option>
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
            <label class="col-md-2 col-form-label" for="pa_cantidades-a-cotizar-minimo">Cantidades a Cotizar</label>
            <div class="col-md-6">
                <input v-model.number="cantidad" class="form-control" type="number" min="10" step="1">
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="observacion">Observaciones</label>
            <div class="col-md-6">
                <textarea class="form-control" v-model="detalles" rows="10" ></textarea>
            </div>
        </div>

    </div>

</template>

<script>

import EventBus from "@/EventBus";


export default {
    name: 'Papeleria_Empresarial',

    props: {
        ruta: String,
        modo:{type: Number,
             required: true}, //0-presupuestar 1-update
        datos: {type: Object, default: null},
        idgrupo: Number
    },
    computed: {
        isTextDisabled: function () {
            if (this.formato === 'Otros')
                return false;
            else
                return true;
        }
    },
    data(){
        return {

            id: '',
            diseno: '',
            cantidad: '',
            detalles: '',
            idtipotrabajo : {},
            tipotrabajo : '',
            papel: ''  ,
            formato: '' ,
            formato_sobres: '',
            dorso: '',
            frente: '',
            solapa: '',
            contenido: '',
             base: '',
            altura: '',

            errorMostrarMsjAviso: [],
            arrayTipos: [],
            active : 0
        }
    },

    methods: {
        validarTrabajo(){
                var errorAviso=0;
                this.errorMostrarMsjAviso =[];
                if (!this.idtipotrabajo && !this.tipotrabajo) this.errorMostrarMsjAviso.push("Falta el tipo de trabajo.");
                if (!this.papel) this.errorMostrarMsjAviso.push("Falta el tipo de papel.");
                if (!this.formato) this.errorMostrarMsjAviso.push("Falta el formato.");
                if (!this.frente) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
                if (!this.dorso) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
                if (this.diseno === '') this.errorMostrarMsjAviso.push("Faltan datos de diseño.");
                //if (!this.solapa) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
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

            if (this.formato_sobres != '')
                this.formato = this.formato_sobres;

            let me = this;

            if (me.formato === 'A medida'){
                me.detalles = 'Formato: ' + me.base + 'x' + me.altura + ' cms\n' + me.detalles ;
            }

            axios.post(me.$parent.ruta + '/presupuestos/store', {
                'idtipotrabajo': this.idtipotrabajo.id,
                'papel': this.papel,
                'formato': this.formato,
                'diseno': this.diseno,
                'contenido': this.contenido,
                'dorso': this.dorso,
                'frente': this.frente,
                'cantidad': this.cantidad,

                'detalles': this.detalles,
                'solapa': this.solapa,
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
                'id' : this.id,
                'papel': this.papel,
                'formato': this.formato,
                'diseno': this.diseno,
                'contenido': this.contenido,
                'dorso': this.dorso,
                'frente': this.frente,
                'cantidad': this.cantidad,

                'detalles': this.detalles,
                'solapa': this.solapa,
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
                this.contenido = this.datos.contenido;

                this.detalles= this.datos.detalles;
                this.dorso= this.datos.dorso;
                this.frente= this.datos.frente;
                this.solapa= this.datos.solapa;
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
                me.arrayTipos= respuesta.productos;
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
            });
        }


    },
    created(){

        this.Inicializar();

        EventBus.$on('Crear_Papeleria_Empresarial', (data) => {
            console.log('Escuchando Crear_Papeleria_Empresarial');
            this.Crear();
        });

        EventBus.$on('Actualizar_Papeleria_Empresarial', (data) => {
            console.log('Escuchando Actualizar_Papeleria_Empresarial');
            this.Actualizar();
        });

        EventBus.$on('Modificar_Papeleria_Empresarial', (data) => {
            console.log('Escuchando Modificar_Papeleria_Empresarial');
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
