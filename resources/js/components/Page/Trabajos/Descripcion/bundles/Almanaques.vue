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
                    <option value="" disabled>Seleccioná</option>
                    <option value="Común 75 grs" >Común 75 grs</option>
                    <option value="Brillante 115 grs" >Brillante 115 grs</option>
                    <option value="Brillante 130 grs" >Brillante 130 grs</option>
                    <option value="Brillante 200 grs" >Brillante 200 grs</option>
                    <option value="Brillante Premium 180 grs" >Brillante Premium 180 grs</option>
                    <option value="Mate 180 grs" >Mate 180 grs</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_formato">Formato (cms)*</label>
            <div class="col-md-6">
                <div class="row">
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
            <label class="col-md-2 col-form-label" for="pa_recubrimiento">Recubrimiento*</label>
            <div class="col-md-6">
                <select id="pa_recubrimiento" class="form-control" v-model="recubrimiento" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Sin recubrimiento" >Sin recubrimiento</option>
                    <option value="Plastificado mate" >Plastificado mate</option>
                    <option value="Plastificado brillante" >Plastificado brillante</option>
                    <option value="Laminado mate" >Laminado mate</option>
                    <option value="Laminado brillante" >Laminado brillante</option>
                    <option value="Otras terminaciones" >Otras terminaciones</option>
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
    name: 'Almanaques',
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
            dorso: '',
            frente: '',
            contenido: '',
            recubrimiento: '',
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


                if (!this.frente) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");

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

            me.formato = me.base + 'x' + me.altura + ' cms';

            axios.post(me.$parent.ruta + '/presupuestos/store', {
                'idtipotrabajo': this.idtipotrabajo,
                'papel': this.papel,
                'formato': this.formato,
                'diseno': this.diseno,
                'contenido': this.contenido,
                'detalles': this.detalles,

                'frente': this.frente,
                'dorso': this.dorso,
                'recubrimiento': this.recubrimiento,
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

            me.formato = me.base + 'x' + me.altura + ' cms';

            axios.post(me.ruta + url, {
                'id' : this.id,
                'papel': this.papel,
                'formato': this.formato,
                'diseno': this.diseno,
                'contenido': this.contenido,
                'detalles': this.detalles,
                'frente': this.frente,
                'dorso': this.dorso,
                'recubrimiento': this.recubrimiento,
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
                //this.formato= this.datos.formato;
                var res = this.datos.formato.split("x");
                this.base = res[0];
                this.altura = res[1].split("cms")[0];

                this.diseno= this.datos.diseno;
                this.contenido= this.datos.contenido;
                this.detalles= this.datos.detalles;
                this.dorso= this.datos.dorso;
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

        EventBus.$on('Crear_Almanaques', (data) => {
            console.log('Escuchando Crear_Almanaques');
            this.Crear();
        });

        EventBus.$on('Actualizar_Almanaques', (data) => {
            console.log('Escuchando Actualizar_Almanaques');
            this.Actualizar();
        });

        EventBus.$on('Modificar_Almanaques', (data) => {
            console.log('Escuchando Modificar_Almanaques');
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
