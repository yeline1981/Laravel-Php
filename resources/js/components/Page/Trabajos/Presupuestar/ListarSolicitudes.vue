<template>

    <main class="main">
        <!-- Breadcrumb-->
        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">

            <div class="col-lg-12" v-if="modo==0">
                <div class="card">
                        <div class="card-header">
                        <i class="fa fa-align-justify"></i> Listado de Solicitudes
                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                            <option value="id|number">ID</option>
                                            <option value="tipotrabajo|string">Producto</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listar(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" @click="listar(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                &nbsp;
                                <button type="button" @click="Limpiar()" class="btn btn-light btn-sm" >
                                        <i class="fa fa-eraser"></i>
                                </button>
                            </div>


                            <table class="table table-striped table-responsive-sm table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th >Id</th>
                                        <th >Producto</th>
                                        <th >Cantidad</th>
                                        <th >Diseñar</th>
                                        <th >Ingreso</th>
                                        <th >Tercerizar</th>
                                        <th >Precio</th>
                                        <th >IVA</th>
                                        <th >Total</th>
                                        <th >Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="trabajo in arrayTrabajos" :key="trabajo.id">

                                        <td v-text="trabajo.id" style="font-size: 11pt;" ></td>

                                        <td v-text="trabajo.tipotrabajo" ></td>
                                        <td v-text="trabajo.cantidad"  ></td>
                                        <td  v-text="trabajo.diseno">
                                            <!--
                                            <div v-if="trabajo.diseno == true">
                                                <span class="badge badge-primary">Si</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-light">No</span>
                                            </div>
                                            -->
                                        </td>
                                        <td v-text="trabajo.fecha"  ></td>
                                        <td >
                                            <div v-if="trabajo.terciar == true">
                                                <span class="badge badge-primary">Si</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-light">No</span>
                                            </div>
                                        </td>
                                        <td v-text="trabajo.precio"  ></td>
                                        <td v-text="trabajo.iva"  ></td>
                                        <td v-text="trabajo.total"  ></td>

                                        <td >
                                            <button  title="Modificar" @click="abrirModificar(trabajo)" class="btn btn-info btn-sm" type="button" >
                                                <i class="icon-pencil"></i>
                                            </button>

                                            <button  title="Presupuestar" @click="abrirPresupuestar(trabajo)" class="btn btn-secondary btn-sm" type="button" >
                                                <i class="fa fa-dollar"></i>
                                            </button>

                                            <button title="Aceptado" v-if="trabajo.precio!=null"  @click="abrirModalAceptar(trabajo)" class="btn btn-success btn-sm" type="button">
                                                <i class="fas fa-thumbs-up"></i>
                                            </button>

                                            <button title="Tercerizar" v-if="trabajo.terciar===false" @click="abrirModalTerciarizar(trabajo)" class="btn btn-primary btn-sm"  type="button">
                                                <i class="fa fa-truck"></i>
                                            </button>

                                            <button title="Eliminar" @click="abrirModalEliminar(trabajo)" class="btn btn-danger btn-sm" type="button">
                                                <i class="icon-trash"></i>
                                            </button>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>


                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>

                        </div>
                        <!-- card-body -->
                </div>
                <!-- card -->

                <!-- Inicio del modal Presupuestar -->
                <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

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

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" @click="cerrarModal()" class="btn btn-secondary" >Cerrar</button>
                                <button type="button" @click="presupuestarTrabajo()" class="btn btn-primary" >Actualizar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fin del modal Presupuestar -->

                <!-- Inicio del modal Aceptar -->
                <div class="modal fade" :class="{'mostrar' : modal2}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

                    <div class="modal-dialog modal-success modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" v-show="accepted">
                                    <p>Estas seguro de Aceptar el trabajo?</p>
                                </form>
                                <form class="form-horizontal" v-show="!accepted">
                                    <contactos-aviso :ruta="ruta" v-on:cliente="Next" ></contactos-aviso>
                                </form>
                            </div>
                            <div class="modal-footer" v-show="accepted">
                                <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" @click="aceptarTrabajo()" class="btn btn-success">Aceptar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fin del modal Aceptar -->

                <!-- Inicio del modal Eliminar -->
                <div class="modal fade" :class="{'mostrar' : modal3}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

                    <div class="modal-dialog modal-danger" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <p>Estas seguro de eliminar el Trabajo?</p>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" @click="eliminarTrabajo()" class="btn btn-danger">Aceptar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fin del modal Eliminar -->

                <!-- Inicio del modal Terciarizar -->
                <div class="modal fade" :class="{'mostrar' : modal4}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

                    <div class="modal-dialog modal-info" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <p>Estás seguro de Terciarizar el Trabajo?</p>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" @click="Terciarizar()" class="btn btn-info">Aceptar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fin del modal Terciarizar -->


            </div>

            <modificar-trabajo :ruta="ruta" :datos="datos" :modo="2" v-else></modificar-trabajo>

        </div>

    </main>
</template>

<script>


import ContactosAviso from './ContactosAviso';
import ModificarTrabajo  from '@/components/Page/Trabajos/ModificarTrabajo';
import Notifications from "@/components/Layouts/Notifications";
import Base from "@/components/Layouts/Base";

import EventBus from "@/EventBus";

export default {
        name: 'ListarSolicitudes',
        props : ['ruta'] ,
        extends: Base,
        components: {
            'contactos-aviso': ContactosAviso,
            'modificar-trabajo': ModificarTrabajo,
            'notification-component': Notifications
        },
        data(){
            return {
                modo: 0,
                ok: 0,
                showalert: 0,

                tipo: null,
                arrayTrabajos: [],

                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'id|number',
                buscar: '',

                modal1 : 0, //modif
                modal2 : 0, //aceptar
                modal3 : 0, //elim
                modal4 : 0, //terciarizar
                tituloModal: '',
                texto: '',

                precio: null,
                iva: 1,

                id: null,
                accepted: 1,
                idcliente: null,
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            }
        },
        methods: {

            listar(page){
                let me=this;

                var url= me.ruta +  '/presupuestos?page=' + page ;
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayTrabajos = respuesta.trabajos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page);
            },
            abrirModificar(data = []){
                //console.log('Emit VerModificar');
                //EventBus.$emit('VerModificar', data);
                this.modo = 2;
                this.datos = data;
            },
            abrirPresupuestar(data = []){

                this.id = data.id;
                this.tituloModal = 'Presupuestar Solicitud ID:' + data.id;
                this.modal1 = 1;
            },
            abrirModalEliminar( data = []){
                this.tituloModal = 'Eliminar Trabajo ID:' + data.id;
                this.id = data.id;
                this.modal3 = 1;
            },
            abrirModalAceptar( data = []){
                this.tituloModal = 'Aceptar Trabajo ID:' + data.id;
                this.id = data.id;
                this.modal2 = 1;
            },
            abrirModalTerciarizar(data = []){
                this.tituloModal = 'Terciarizar Trabajo ID:' + data.id;
                this.id = data.id;
                this.modal4 = 1;
            },
            cerrarModal(){

                this.modal1=0;
                this.modal2=0;
                this.modal3=0;
                this.modal4 = 0;

                this.tituloModal='';
                this.id = '';
                this.precio = null;
                this.iva = 1;


                this.errorpasswd = 0;
                this.errorMostrarMsjusuario = [];
            },
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

                axios.post(me.ruta + '/presupuestos/budget',{
                    'id' : this.id,
                    'precio' : cprecio,
                    'iva': civa,
                    'total': total

                }).then(function (response) {
                    console.log(response);
                    me.modal1 = 0;
                    me.precio = null;
                    me.iva = 1;

                    me.textonotificar = 'Presupuesto asignado.';
                    me.showAlert(1);
                    me.listar(1);

                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            eliminarTrabajo(){
                let me = this;

                axios.put(me.ruta + '/presupuestos/' + this.id + '/drop',{
                }).then(function (response) {
                    console.log(response);
                    me.modal3 = 0;
                    me.textonotificar = 'Solicitud eliminada.';
                    me.showAlert(1);
                    me.listar(1);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            aceptarTrabajo(){
                this.accepted = 0;
                //this.listar(1);
            },
            Terciarizar(item){
                let me = this;

                axios.post(me.ruta + '/presupuestos/tertiary',{
                    'id' : this.id
                }).then(function (response) {
                    console.log(response);
                    me.modal4 = 0;
                    me.listar(1);

                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            Next(item){
                let me = this;

                axios.post(me.ruta + '/presupuestos/accept',{
                    'id' : this.id,
                    'idcliente': item
                }).then(function (response) {
                    console.log(response);
                    me.modal2 = 0;
                    //me.listar(1);
					me.showPay(response.data.presupuesto);

                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            showPay(item){
                this.$parent.estado = 1;
                this.$parent.menu = 5;
            },

      },
      created : function(){

        this.listar(1);

         EventBus.$on('VerModificar', (item) => {
            console.log('VerModificar' + item);
            this.modo = 0;
            this.datos = item;
            //window.location.href = ruta + '/trabajos/'+ data.grupo +'/tipo='+ data.idtipo+'/'+data.id;
        });

        EventBus.$on('Actualizado', (item) => {
            console.log('Actualizado');
            this.textonotificar = 'Solicitud actualizada';
            this.showAlert(1);
            this.modo = 0;
            this.listar(1);
        });

        EventBus.$on('VerSolicitudes', (item) => {
            console.log('VerSolicitudes');
            this.modo = 0;
            this.listar(1);
        });

        EventBus.$on('ErrorValidacion', (item) => {
            this.errorMostrarMsj = item;
            this.showAlert(2);
        });

      }
    }
</script>

<style scoped>
    th{
        text-align: center;
    }
    td{
        text-align: center;
    }
</style>


