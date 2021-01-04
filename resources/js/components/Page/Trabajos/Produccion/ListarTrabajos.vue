<template>

    <main class="main">
        <!-- Breadcrumb-->
        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">

            <ver-trabajos :ruta="ruta" v-if="modo==1" ></ver-trabajos>
            <modificar-trabajo :modo="3" :ruta="ruta" :datos="datos" v-else></modificar-trabajo>

            <!-- Inicio del modal Presupuestar -->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Modificar Presupuesto</h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Precio Actual</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" v-model="oldprecio" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Total Actual</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" v-model="oldtotal" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" v-model="precio">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">IVA Incluido</label>
                                <div class="col-md-9 col-form-label">
                                    <div class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" id="inline_radio1" type="radio" value=1 v-model.number="iva">
                                        <label class="form-check-label" for="inline_radio1">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" id="inline_radio2" type="radio" value=0 v-model.number="iva">
                                        <label class="form-check-label" for="inline_radio2">No</label>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <hr>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Código Facturación</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model.number="codigo">
                                        <option v-for="tipo in arrayFacturaciones" :key="tipo.id" :value="tipo.id" v-text="tipo.descripcion"></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Cantidad</label>
                                <div class="col-md-9">
                                    <input class="form-control"  type="number" v-model.number="facturado">
                                </div>
                            </div>
                            -->


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" >Ignorar</button>
                            <button type="button" @click="presupuestarTrabajo()" class="btn btn-primary" >Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Presupuestar -->

        </div>

      </main>

</template>

<script>

import EventBus from '@/EventBus'

import ModificarTrabajo  from '@/components/Page/Trabajos/ModificarTrabajo'
import VerTrabajos  from './VerTrabajos';
import Notifications from "@/components/Layouts/Notifications";
import Base from "@/components/Layouts/Base";


export default {
    name: 'ListarTrabajos',
    props : ['ruta'] ,
    extends: Base,
    components: {
        'modificar-trabajo': ModificarTrabajo,
        'ver-trabajos': VerTrabajos,
        'notification-component': Notifications
    },
    data(){
        return {
            modo: 1,
            ok: 0,
            datos:{},
            modal1: 0,
            precio: null,
            oldprecio: null,
            oldtotal: null,
            iva: 1,
            id: '',
            codigo: '',
            facturado: ''

        }
    },
    methods: {
        presupuestarTrabajo(){
            let me = this;

                var cprecio = 0.0;
                var civa = 0.0;
                var total = 0.0;

                if (me.iva === 1){ //iva incluido, desglosar

                    cprecio = (me.precio / 1.22).toFixed(2);
                    civa = (parseFloat(me.precio) - parseFloat(cprecio)).toFixed(2);
                    console.log(cprecio + ' \\-- ' + civa);
                    total = me.precio;

                }
                else{
                    civa = (parseFloat(me.precio) * 0.22).toFixed(2);
                    total = Math.round(parseFloat(me.precio) + parseFloat(civa));
                    cprecio = me.precio;
                    //console.log(civa + ' ///-- ' + cprecio);
                }

                axios.post(me.ruta + '/trabajos/budget',{
                    'id' : this.id,
                    'precio' : cprecio,
                    'iva': civa,
                    'total': total,
                //    'codigo': this.codigo,
                //    'cantidad': this.facturado

                }).then(function (response) {
                    console.log(response);
                    me.modal1 = 0;
                    me.precio = null;
                    me.iva = 1;
                   // me.Facturar(response.data.presupuesto);

                    EventBus.$emit('Init', '');
                    me.modo = 1;
                    me.textonotificar = 'Trabajo actualizado.';
                    me.showAlert(1);


                }).catch(function (error) {
                    console.log(error.response);
                });
        },
        cerrarModal(){

            this.modal1=0;
            this.precio = null;
            this.iva = 1;

            EventBus.$emit('Init', '');
            this.modo = 1;
            this.textonotificar = 'Trabajo actualizado.';
            this.showAlert(1);

        },
    },
    created : function(){

        EventBus.$on('Error', (item=[]) => {
              this.errorMostrarMsj = item;
              this.showAlert(2);
        });


        EventBus.$on('Actualizado', (item) => {
            console.log('Oigo actualizado en listar');
            this.textonotificar = 'Trabajo actualizado';
            this.showAlert(1);
            EventBus.$emit('Init', '');
        });

        EventBus.$on('Modificado', (item) => {
            console.log('Oigo modificado en listar');
            this.id = item.id;
            this.oldprecio = item.precio;
            this.oldtotal = item.total;
            //this.textonotificar = 'Trabajo modificado, cambie el precio si es necesario.';
            //EventBus.$emit('Init', '');
            //this.showAlert(1);
            this.modal1 = 1;
        });

        EventBus.$on('VerModificar', (item) => {
            console.log('VerModificar' + item);
            this.modo = 0;
            this.datos = item;
            //window.location.href = ruta + '/trabajos/'+ data.grupo +'/tipo='+ data.idtipo+'/'+data.id;
        });

        EventBus.$on('VerTrabajos', (item) => {
            console.log('VerTrabajos' + item);
            this.modo = 1;
        });


    }
}
</script>


