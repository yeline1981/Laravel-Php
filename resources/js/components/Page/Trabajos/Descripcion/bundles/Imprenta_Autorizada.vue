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
                        <option v-for="tipo in arrayTipos" :key="tipo.id" :value="tipo.id" v-text="tipo.tipo"></option>
                    </select>
            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_papel">Papel *</label>
            <div class="col-md-6">
                <select id="pa_papel" class="form-control" v-model="papel" data-show_option_none="yes" >
                    <option value="" disabled>Seleccione</option>
                    <option value="Común" >Común</option>
                    <option value="Autocopiante" >Autocopiante</option>
                </select>

            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_formato">Formato (cms)*</label>
            <div class="col-md-6">
                <select id="pa_formato" class="form-control" v-model="formato">
                    <option value="" disabled>Seleccione</option>
                    <option value="10.5x14.85cm A6" >10.5x14.85cms (A6)</option>
                    <option value="14.85x21cm A5" >14.85x21cms (A5)</option>
                    <option value="21x29.7cms A4">21x29.7cms (A4)</option>
                    <option value="A Medida" >A Medida</option>
                </select>
                <div v-if="formato === 'A medida'" class="row Otros">
                    <input class="form-control col-md-2 separar" type="text" v-model="base" placeholder="base"/> x
                    <input class="form-control col-md-2 separar" type="text" v-model="altura" placeholder="altura"/>
                    <span>cms</span>
                </div>
            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_impresion-frente">Cantidad de Vías*</label>
            <div class="col-md-6">
                <select id="pa_impresion-frente" class="form-control" v-model="vias" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="1" >1 via (Sin copia)</option>
                    <option value="2" >2 vias (Original y copia)</option>
                    <option value="3" >3 vias (Original y 2 copias)</option>
                    <option value="4" >4 vias (Original y 3 copias)</option>
                    <option value="5" >5 vias (Original y 4 copias)</option>
                </select>
            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_impresion-dorso">Impresión *</label>
            <div class="col-md-6">
                <select id="pa_impresion-dorso" class="form-control" v-model="frente" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Negro" >Negro</option>
                    <option value="Color" >Color</option>
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
            <label class="col-md-2 col-form-label" for="pa_encuadernado">Encuadernación *</label>
            <div class="col-md-6">
                <select id="pa_encuadernado" class="form-control" v-model="encuadernado" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Engomado" >Engomado</option>
                    <option value="Engrampado" >Engrampado</option>
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
                    <option value="Reimprimir" >Reimpresión</option>
                </select>
            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_cantidades-a-cotizar-minimo">Cantidades a Cotizar*</label>
            <div class="col-md-6">
                    <input v-model.number="cantidad" class="form-control" type="number" min="1" step="1">
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" >Unidad *</label>
            <div class="col-md-6">
                <select  class="form-control" v-model="unidad" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Números" >Números</option>
                    <option value="Libretas" >Libretas</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center">

                <div class="form-group row col-md-3">
                    <label class="col-md-6 col-form-label" for="numerar">Numerar *</label>
                    <div class="col-md-6">
                        <select id="numerar" class="form-control col-auto" v-model="numerado" name="attribute_pa_diseno" data-attribute_name="attribute_pa_diseno" data-show_option_none="yes">
                            <option value="true" >Si</option>
                            <option value="false" >No</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row col-md-3">
                    <label class="col-form-label col-auto" for="desde">Desde</label>
                    <div class="col">
                        <input v-model.number="desde" id="desde" class="form-control" type="number" min="1" step="1">
                    </div>
                </div>

                <div class="form-group row col-md-3">
                    <label class="col-form-label col-auto" >Hasta</label>
                    <div class="col">
                        <input v-model.number="hasta" class="form-control" type="number" min="1" step="1">
                    </div>
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
    name: 'Imprenta_Autorizada',

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
            vias: '',
            frente: '',
            contenido: '',
            encuadernado: '',
            unidad: '',
            numerado: true,
            desde: null,
            hasta: null,
             base: '',
            altura: '',

            errorMostrarMsjAviso: [],
            arrayTipos: []
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
                if (!this.encuadernado) this.errorMostrarMsjAviso.push("Faltan datos de encuadernado.");
                if (this.diseno === '') this.errorMostrarMsjAviso.push("Faltan datos de diseño.");
                if (!this.vias) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
                if (!this.cantidad) this.errorMostrarMsjAviso.push("Falta la cantidad.");
                if (!this.unidad) this.errorMostrarMsjAviso.push("Falta la unidad.");
                if (!this.numerado) this.errorMostrarMsjAviso.push("Falta el numerado.");

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
                'frente': this.frente,
                'cantidad': this.cantidad,

                'vias': this.vias,
                'encuadernado': this.encuadernado,
                'unidad': this.unidad,
                'numerado': this.numerado,
                'desde':this.desde,
                'hasta':this.hasta,
                'detalles': this.detalles

            })
            .then(function (response) {
                // handle success
                console.log(response);
                me.$emit('respuesta', response.data.trabajo);
                EventBus.$emit('Creado', response.data.trabajo );
            })
            .catch(function (error) {
                // handle error
                console.log('Dio error');
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
                'frente': this.frente,
                'cantidad': this.cantidad,

                'vias': this.vias,
                'encuadernado': this.encuadernado,
                'detalles': this.detalles

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
                console.log(error);
            });
        },
        Inicializar(){
            console.log('Iniciando');

            if (this.datos !== null)
            {
                this.id = this.datos.id;
                this.tipotrabajo = this.datos.tipotrabajo;
                this.papel= this.datos.papel;
                this.formato= this.datos.formato;
                this.diseno= this.datos.diseno;
                this.contenido= this.datos.contenido;
                this.detalles= this.datos.detalles;
                this.vias= this.datos.vias;
                this.frente= this.datos.frente;
                this.encuadernado= this.datos.encuadernado;
                this.cantidad= this.datos.cantidad;
                this.unidad= this.datos.unidad;
                this.desde= this.datos.desde;
                this.hasta= this.datos.hasta;
                this.numerado= this.datos.numerado;
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
    created() {

        this.Inicializar();

        EventBus.$on('Crear_Imprenta_Autorizada', (data) => {
            console.log('Escuchando Crear_Imprenta_Autorizada');
            this.Crear();
        });

        EventBus.$on('Actualizar_Imprenta_Autorizada', (data) => {
            console.log('Escuchando Actualizar_Imprenta_Autorizada');
            this.Actualizar();
        });

        EventBus.$on('Modificar_Imprenta_Autorizada', (data) => {
            console.log('Escuchando Modificar_Imprenta_Autorizada');
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
