<template>

    <div class="col-md-12">

        <div class="form-group row justify-content-center" v-if="modo!==0">
            <label class="col-md-2 col-form-label" for="pa_tipo">Tipo *</label>
            <div class="col-md-6">
                <input v-model="tipotrabajo" class="form-control" type="text" disabled >
            </div>
        </div>

        <div class="form-group row justify-content-center" v-else>
            <label class="col-md-2 col-form-label" for="pa_tipo">Tipo *</label>
            <div class="col-md-6">
                <select class="form-control" v-model="idtipotrabajo">
                        <option values="0">Seleccione</option>
                        <option v-for="tipo in arrayTipos" :key="tipo.id" :value="tipo" v-text="tipo.tipo"></option>
                    </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_papel">Papel *</label>
            <div class="col-md-6">
                <select id="pa_papel" class="form-control" v-model="papel" data-show_option_none="yes" >
                    <option value="" disabled>Seleccione</option>
                    <option value="Común blanco 75grs" >Común blanco 75grs.</option>
                    <option value="Común blanco 100grs" >Común blanco 100grs.</option>
                    <option value="Blanco brillante 115grs" >Blanco brillante 115grs.</option>
                    <option value="Blanco brillante 130grs" >Blanco brillante 130grs.</option>
                    <option value="Común a color 75grs" >Común a color 75grs.</option>
                    <option value="Otros" >Otros</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">

            <label class="col-md-2 col-form-label" for="pa_formato">Formato Abierto (cms)*</label>

            <div class="col-md-6" v-if="idtipotrabajo.tipo==='Volantes' || tipotrabajo==='Volantes'">
                <select id="pa_formato" class="form-control" v-model="formato">
                    <option value="" disabled>Seleccione</option>
                    <option value="10.5x14.85 cms A6" >10.5x14.85 cms (A6)</option>
                    <option value="10x30 cms " >10x30cms </option>
                    <option value="21x14,8 cms A5" >21x14.8 cms (A5)</option>
                    <option value="21x29.7 cms A4" >21x29.7 cms (A4)</option>
                    <option value="A medida" >A Medida</option>
                </select>
                <div v-if="formato === 'A medida'" class="row Otros">
                    <input class="form-control col-md-2 separar" type="text" v-model="base" placeholder="base"/> x
                    <input class="form-control col-md-2 separar" type="text" v-model="altura" placeholder="altura"/>
                    <span>cms</span>
                </div>
            </div>
            <div class="col-md-6" v-else>
                <select id="pa_formato" class="form-control" v-model="formato">
                    <option value="21x29.7 cms A4" >21x29.7 cms (A4)</option>
                    <option value="29.7x42 cms A3">29.7x42 cms (A3)</option>
                    <option value="A medida" >A Medida</option>
                </select>
                <div v-if="formato === 'A medida'" class="row Otros">
                    <input class="form-control col-md-2 separar" type="text" v-model="base" placeholder="base"/> x
                    <input class="form-control col-md-2 separar" type="text" v-model="altura" placeholder="altura"/>
                    <span>cms</span>
                </div>
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
            <label class="col-md-2 col-form-label" for="pa_sangrado">Sangrado*</label>
            <div class="col-md-6">
                <select id="pa_contenido" class="form-control" v-model="sangrado" data-show_option_none="yes">
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
                <input class="form-control" v-model.number="cantidad" type="number" min="10" step="1" >
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="observacion">Observaciones</label>
            <div class="col-md-6">
                <textarea class="form-control" v-model="detalles" rows="10"></textarea>
            </div>
        </div>


    </div>

</template>

<script>

import EventBus from "@/EventBus";

export default {
    name: 'Folletos',

    props: {
        ruta: String,
        modo:{type: Number,
             required: true}, //0-presupuestar 1-update
        datos: {type: Object, default: null},
        idgrupo: Number
    },
    computed:{

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
            dorso: '',
            frente: '',
            contenido: '',
            sangrado: '',
             base: '',
            altura: '',

            errorMostrarMsjAviso: [],
            arrayTipos: [],

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
                if (!this.sangrado) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");

                if (!this.contenido) this.errorMostrarMsjAviso.push("Falta el contenido.");
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

            axios.post(me.ruta + '/presupuestos/store', {
                'idtipotrabajo': this.idtipotrabajo.id,
                'papel': this.papel,
                'formato': this.formato,
                'frente': this.frente,
                'dorso': this.dorso,
                'sangrado': this.sangrado,
                'contenido': this.contenido,
                'diseno': this.diseno,
                'cantidad': this.cantidad,
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
                me.detalles = me.detalles + '\n Formato: ' + me.base + 'x' + me.altura + ' cms';
            }

            axios.post(me.ruta + url, {
                'id': this.id,
                'papel': this.papel,
                'formato': this.formato,
                'frente': this.frente,
                'dorso': this.dorso,
                'sangrado': this.sangrado,
                'contenido': this.contenido,
                'diseno': this.diseno,
                'cantidad': this.cantidad,
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
                this.dorso= this.datos.dorso;
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
                me.arrayTipos= respuesta.productos;
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
            });
        },


    },
    created() {

        this.Inicializar();

        EventBus.$on('Crear_Folletos', (data) => {
            console.log('Escuchando Crear_Folletos');
            this.Crear();
        });

        EventBus.$on('Actualizar_Folletos', (data) => {
            console.log('Escuchando Actualizar_Folletos');
            this.Actualizar();
        });

        EventBus.$on('Modificar_Folletos', (data) => {
            console.log('Escuchando Modificar_Folletos');
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
