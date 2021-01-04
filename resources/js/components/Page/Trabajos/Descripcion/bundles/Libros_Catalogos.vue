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
            <label class="col-md-2 col-form-label" for="pa_papel">Papel Interior*</label>
            <div class="col-md-6">
                <select id="pa_papel" class="form-control" v-model="papel" data-show_option_none="yes" >
                    <option value="" disabled>Seleccione</option>
                    <option value="Obra 70gr" >Obra 70gr</option>
                    <option value="Obra 80gr" >Obra 80gr</option>
                    <option value="Obra 100gr" >Obra 100gr</option>
                    <option value="Obra 130gr" >Obra 130gr</option>
                    <option value="Obra 180gr" >Obra 180gr</option>
                    <option value="Obra 210gr" >Obra 210gr</option>

                    <option value="Obra Bookcel 80gr" >Obra Bookcel 80gr</option>

                    <option value="Coteado mate 115g " >Coteado mate 115gr</option>
                    <option value="Coteado mate 130gr" >Coteado mate 130gr</option>
                    <option value="Coteado mate 150gr" >Coteado mate 150gr</option>
                    <option value="Coteado mate 170gr" >Coteado mate 170gr</option>
                    <option value="Coteado mate 200gr" >Coteado mate 200gr</option>
                    <option value="Coteado mate 250gr" >Coteado mate 250gr</option>
                    <option value="Coteado mate 300gr" >Coteado mate 300gr</option>
                    <option value="Coteado mate 350gr" >Coteado mate 350gr</option>

                    <option value="Coteado brillante 115g " >Coteado brillante 115gr</option>
                    <option value="Coteado brillante 130gr" >Coteado brillante 130gr</option>
                    <option value="Coteado brillante 150gr" >Coteado brillante 150gr</option>
                    <option value="Coteado brillante 170gr" >Coteado brillante 170gr</option>
                    <option value="Coteado brillante 200gr" >Coteado brillante 200gr</option>
                    <option value="Coteado brillante 250gr" >Coteado brillante 250gr</option>
                    <option value="Coteado brillante 300gr" >Coteado brillante 300gr</option>
                    <option value="Coteado brillante 350gr" >Coteado brillante 350gr</option>

                    <option value="Otros" >Otros</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_papel2">Papel Tapa*</label>
            <div class="col-md-6">
                <select id="pa_papel2" class="form-control" v-model="papeltapa" data-show_option_none="yes" >
                    <option value="" disabled>Seleccione</option>
                     <option value="" disabled>Seleccione</option>
                    <option value="Obra 70gr" >Obra 70gr</option>
                    <option value="Obra 80gr" >Obra 80gr</option>
                    <option value="Obra 100gr" >Obra 100gr</option>
                    <option value="Obra 130gr" >Obra 130gr</option>
                    <option value="Obra 180gr" >Obra 180gr</option>
                    <option value="Obra 210gr" >Obra 210gr</option>

                    <option value="Obra Bookcel 80gr" >Obra Bookcel 80gr</option>

                    <option value="Coteado mate 115g " >Coteado mate 115gr</option>
                    <option value="Coteado mate 130gr" >Coteado mate 130gr</option>
                    <option value="Coteado mate 150gr" >Coteado mate 150gr</option>
                    <option value="Coteado mate 170gr" >Coteado mate 170gr</option>
                    <option value="Coteado mate 200gr" >Coteado mate 200gr</option>
                    <option value="Coteado mate 250gr" >Coteado mate 250gr</option>
                    <option value="Coteado mate 300gr" >Coteado mate 300gr</option>
                    <option value="Coteado mate 350gr" >Coteado mate 350gr</option>

                    <option value="Coteado brillante 115g " >Coteado brillante 115gr</option>
                    <option value="Coteado brillante 130gr" >Coteado brillante 130gr</option>
                    <option value="Coteado brillante 150gr" >Coteado brillante 150gr</option>
                    <option value="Coteado brillante 170gr" >Coteado brillante 170gr</option>
                    <option value="Coteado brillante 200gr" >Coteado brillante 200gr</option>
                    <option value="Coteado brillante 250gr" >Coteado brillante 250gr</option>
                    <option value="Coteado brillante 300gr" >Coteado brillante 300gr</option>
                    <option value="Coteado brillante 350gr" >Coteado brillante 350gr</option>

                    <option value="Otros" >Otros</option>
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
            <label class="col-md-2 col-form-label" for="pa_impresion">Impresión interior*</label>
            <div class="col-md-6">
                <select id="pa_impresion-frente" class="form-control" v-model="frente" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Negro" >Negro</option>
                    <option value="Color" >Color</option>
                    <option value="Sin impresión" >Sin impresión</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_impresion">Impresión Tapa*</label>
            <div class="col-md-6">
                <select id="pa_impresion-frente" class="form-control" v-model="dorso" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Negro" >Negro</option>
                    <option value="Color" >Color</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_formato">Cantidad de Hojas *</label>
            <div class="col-md-6">
                <input v-model.number="hojas" class="form-control" type="number" >
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_recubrimiento">Recubrimiento Tapa *</label>
            <div class="col-md-6">
                <select id="pa_recubrimiento" class="form-control" v-model="recubrimiento" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Sin recubrimiento" >Sin recubrimiento</option>
                    <option value="Laminado mate" >Laminado mate</option>
                    <option value="Laminado brillante" >Laminado brillante</option>
                    <option value="Otras terminaciones" >Otras terminaciones</option>
                </select>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label class="col-md-2 col-form-label" for="pa_encuadernado">Encuadernación *</label>
            <div class="col-md-6">
                <select id="pa_encuadernado" class="form-control" v-model="encuadernado" data-show_option_none="yes">
                    <option value="" disabled>Seleccione</option>
                    <option value="Lomo cuadrado" >Lomo cuadrado(falso cosido)</option>
                    <option value="Engrampado" >Engrampado</option>
                    <option value="Engomado" >Engomado</option>
                    <option value="Espiral Plástico" >Espiral Plástico</option>
                    <option value="Rulo Plástico" >Rulo Plástico</option>
                    <option value="Rulo Metálico" >Rulo Metálico</option>
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
    name: 'Libros_Catalogos',

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
            frente: ' ',
            dorso: '',
            recubrimiento: '',
            hojas: '',
            encuadernado: '',
            papeltapa: '',
            contenido: 'Texto e imagen',
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
                if (!this.papeltapa) this.errorMostrarMsjAviso.push("Falta el tipo de papel para la tapa.");
                if (!this.base || !this.altura) this.errorMostrarMsjAviso.push("Falta el formato.");
                if (!this.frente) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
                if (!this.dorso) this.errorMostrarMsjAviso.push("Faltan datos de impresión.");
                if (this.diseno === '') this.errorMostrarMsjAviso.push("Faltan datos de diseño.");
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

                'vias': this.hojas,
                'encuadernado': this.encuadernado,
                'recubrimiento': this.recubrimiento,
                'cantidad': this.cantidad,
                'frente': this.frente,
                'dorso': this.dorso,
                'tapa': this.papeltapa

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

                'vias': this.hojas,
                'encuadernado': this.encuadernado,
                'recubrimiento': this.recubrimiento,
                'cantidad': this.cantidad,
                'frente': this.frente,
                'dorso': this.dorso,
                'tapa' : this.papeltapa

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
                this.papeltapa= this.datos.tapa;
                //this.formato= this.datos.formato;
                var res = this.datos.formato.split("x");
                this.base = res[0];
                this.altura = res[1].split("cms")[0];

                this.diseno= this.datos.diseno;
               // this.contenido= this.datos.contenido;
                this.detalles= this.datos.detalles;
                this.dorso= this.datos.dorso;
                this.frente= this.datos.frente;
                this.recubrimiento= this.datos.recubrimiento;
                this.encuadernado= this.datos.encuadernado;
                this.cantidad= this.datos.cantidad;
                this.hojas= this.datos.vias;
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

        EventBus.$on('Crear_Libros_Catalogos', (data) => {
            console.log('Escuchando Crear_Libros_Catalogos');
            this.Crear();
        });

        EventBus.$on('Actualizar_Libros_Catalogos', (data) => {
            console.log('Escuchando Actualizar_Libros_Catalogos');
            this.Actualizar();
        });

        EventBus.$on('Modificar_Libros_Catalogos', (data) => {
            console.log('Escuchando Modificar_Libros_Catalogos');
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
