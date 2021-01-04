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
                    <option value="Común blanco 75grs" >Común blanco 75grs.</option>
                    <option value="Común blanco 100grs" >Común blanco 100grs.</option>
                    <option value="Blanco brillante 115grs" >Blanco brillante 115grs.</option>
                    <option value="Blanco brillante 130grs" >Blanco brillante 130grs.</option>
                    <option value="Blanco brillante 200grs" >Blanco brillante 200grs.</option>
                    <option value="Blanco brillante 250grs" >Blanco brillante 250grs.</option>
                    <option value="Blanco brillante 300grs" >Blanco brillante 300grs.</option>
                    <option value="Común a color 75grs" >Común a color 75grs.</option>
                    <option value="Autocopiante" >Autocopiante</option>
                    <option value="Otros" >Otros</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">

            <label class="col-md-2 col-form-label" for="pa_formato">Formato (cms)</label>
            <div class="col-md-6">
                <select id="pa_formato" class="form-control" v-model="formato">
                    <option value="" disabled>Seleccione</option>
                    <option value="10.5x14.85cm A6" >10.5x14.85cms (A6)</option>
                    <option value="14.85x21cm A5" >14.85x21cms (A5)</option>
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
            <label class="col-md-2 col-form-label" for="pa_impresion-frente">Impresión Frente</label>
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
            <label class="col-md-2 col-form-label" for="pa_contenido">Contenido</label>
            <div class="col-md-6">
                <select id="pa_contenido" class="form-control" v-model="contenido" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Sólo texto" >Sólo texto</option>
                    <option value="texto e imagen" >Texto e imagen</option>
                </select>
            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_partes">Cantidad de Partes</label>
            <div class="col-md-6">
                <select id="pa_partes" class="form-control" v-model="partes" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="1" >1</option>
                    <option value="2" >2</option>
                    <option value="3" >3</option>
                    <option value="4" >4</option>

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
            <label class="col-md-2 col-form-label" for="pa_cantidades-a-cotizar-minimo">Cantidades a Cotizar (Mínimo 100)</label>
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
    name: 'Talonarios',

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
             base: '',
            altura: '',

            frente: '',
            contenido: '',
            partes: '',

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
                if (!this.partes) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
                if (this.diseno === '') this.errorMostrarMsjAviso.push("Faltan datos de diseño.");
                if (!this.contenido) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
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
                'frente': this.frente,
                'contenido': this.contenido,
                'partes': this.partes,
                'diseno': this.diseno,
                'cantidad': this.cantidad,
                'detalles': this.detalles,

            })
            .then(function (response) {
                // handle success
                console.log(response);
                me.$emit('respuesta', response.data.trabajo);
                EventBus.$emit('Creado', response.data.trabajo );

            })
            .catch(function (error) {
                // handle error
                console.log(error);
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
                //'tipo': this.tipo,
                'papel': this.papel,
                'formato': this.formato,
                'frente': this.frente,
                'contenido': this.contenido,
                'partes': this.partes,
                'diseno': this.diseno,
                'cantidad': this.cantidad,
                'detalles': this.detalles,

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
                this.partes= this.datos.partes;
                this.frente= this.datos.frente;
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
    created() {

        this.Inicializar();

        EventBus.$on('Crear_Talonarios', (data) => {
            console.log('Escuchando Crear_Talonarios');
            this.Crear();
        });

        EventBus.$on('Actualizar_Talonarios', (data) => {
            console.log('Escuchando Actualizar_Talonarios');
            this.Actualizar();
        });

        EventBus.$on('Modificar_Talonarios', (data) => {
            console.log('Escuchando Modificar_Talonarios');
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
