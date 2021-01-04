<template>

    <main class="main">
        <!-- Breadcrumb-->

        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Facturación
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="fecha">Fecha contrato</option>
                                    <option value="cliente">Cliente</option>
                                    <option value="tipotrabajo">Producto</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarPublicaciones(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" @click="listarPublicaciones(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                        &nbsp;
                        <button type="button" @click="Limpiar()" class="btn btn-light btn-sm" >
                                <i class="fa fa-eraser"></i>
                        </button>

                    </div>



                    <table class="table table-striped table-bordered table-sm " cellspacing="0"  width="100%">
                        <thead>
                        <tr>
                            <th >ID Trabajo </th>
                            <th >Cliente</th>
                            <th >Producto </th>

                            <th >Fecha</th>
                            <th >Precio</th>
                            <th >IVA</th>
                            <th >Total</th>

                            <th >Cobrado</th>
                            <th >Factura</th>
                            <th >Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="aviso in arrayAvisos" :key="aviso.id">

                            <td v-text="aviso.id" ></td>
                            <td v-text="aviso.cliente" ></td>
                            <td v-text="aviso.tipotrabajo" ></td>

                            <td v-text="aviso.fecha" ></td>
                            <td v-text="aviso.precio" ></td>
                            <td v-text="aviso.iva" ></td>
                            <td v-text="aviso.total" ></td>
                            <td v-text="aviso.senado" ></td>
                            <td v-text="aviso.factura" ></td>
                            <td >
                            <button  type="button" title="Nuevo Pago" @click="abrirModalPagar(aviso)" class="btn btn-secondary btn-sm" >
                                <i class="fa fa-dollar"></i>
                            </button>

                            <button  type="button" title="Imprimir" @click="Imprimir(aviso)" class="btn btn-primary btn-sm" >
                                <i class="fa fa-print"></i>
                            </button>

                            <button  v-if="aviso.total===aviso.senado" type="button" title="Factura" @click="abrirModalFactura(aviso)" class="btn btn-info btn-sm" >
                                <i class="far fa-file"></i>
                            </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="clearfix ">
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

                </div>
            </div>

            <!-- Inicio del modal Pagar -->
            <div class="modal fade" :class="{'mostrar' : modal1}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

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
                                        <label class="col-md-3 form-control-label" for="text-input">Total:</label>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control" v-model="total" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio:</label>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control" v-model="precio" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Iva:</label>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control" v-model="iva" disabled>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Señado:</label>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control" v-model="senna" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Ingresa:</label>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control" v-model="ingresa">
                                        </div>
                                    </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" @click="pagarTrabajo()" class="btn btn-info">Aceptar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Pagar -->

            <!-- Inicio del modal Factura -->
            <div class="modal fade" :class="{'mostrar' : modal2}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

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

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Número:</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="factura">
                                        </div>
                                    </div>

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

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" @click="facturar()" class="btn btn-info">Aceptar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Factura -->

        </div>

    </main>

</template>

<script>
    import EventBus from "@/EventBus.js";
    import Notifications from "@/components/Layouts/Notifications";
    import Base from "@/components/Layouts/Base";

    export default {
        name: 'Facturacion',
        props: ['ruta'],
        extends: Base,
        components: {
            'notification-component': Notifications
        },
       data(){
         return {
            arrayAvisos: [],
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            criterio : 'tipotrabajo',
            buscar: null,
            total: 0,
            modal1: 0,
            modal2: 0,
            id: '',
            precio: '',
            iva: '',
            total: '',
            senna: '',
            ingresa: '',
            factura: '',
            tituloModal: '',
            texto: '',

            arrayFacturaciones: [],
            facturado: '',
            codigo: ''

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
        methods : {
            listarPublicaciones (page,buscar,criterio){
                let me=this;

                var url= me.ruta + '/caja/facturacion?page=' + page ;
                var filter  = 0;

                if (buscar !== null){
                    url = url + '&filter&' + criterio + '=' + buscar ;
                }

                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayAvisos = respuesta.trabajos.data;
                    me.pagination= respuesta.pagination;
                    me.total = respuesta.pagination.total;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPublicaciones(page,buscar,criterio);
            },
            Limpiar(){
                this.criterio = 'tipotrabajo';
                this.buscar = null;
                this.listarPublicaciones(1, this.buscar, this.criterio);
            },
            pagarTrabajo(){
                let me = this;

                axios.put(me.ruta + '/trabajos/pay',{
                    'id' : this.id,
                    'ingresado' : this.ingresa

                }).then(function (response) {
                    console.log(response);
                    me.modal1 = 0;
                    me.ingresa = '';
                    me.precio = '';
                    me.senna = '';
                    me.listarPublicaciones(1, me.buscar, me.criterio);
                    me.textonotificar = 'Cobro ingresado';
                    me.showAlert(1);

                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            facturar(){
                let me = this;

                axios.put(me.ruta + '/trabajos/bill',{
                    'id' : this.id,
                    'factura' : this.factura
                }).then(function (response) {
                    console.log(response);
                    me.modal2 = 0;
                    me.listarPublicaciones(1, me.buscar, me.criterio);
                    me.textonotificar = 'Factura ingresado';
                    me.showAlert(1);

                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            cerrarModal(){

                this.modal1 =0;
                this.modal2 =0;
                this.tituloModal= '';
                this.id = '';
            },
            abrirModalPagar(data = []){
                console.log('abrirModalPagar');
                this.modal1 = 1;
                this.tituloModal= 'Nuevo Pago ID:' + data.id;
                this.id = data.id;
                this.precio = data.precio;
                this.total = data.total;
                this.iva = data.iva;
                this.senna = data.senado;
            },
            abrirModalFactura(data = []){
                this.modal2 = 1;
                this.tituloModal= 'Factura asociada al ID:' + data.id;
                this.id = data.id;
            },
            Imprimir(item){
               window.open(this.ruta + '/trabajos/vale?id='+ item.id , '_blank');
            },
            getFacturacion(){
                let me = this;
                var url= me.ruta + '/caja/facturacion/codigos';
                axios.get(url)
                .then(function (response) {
                    // handle success
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayFacturaciones= respuesta.codigos;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error.response);
                });
            },
            Facturar(){

            }

        },
        created: function() {
            console.log('Caja general');
            this.listarPublicaciones(1, this.buscar, this.criterio);

            if (this.$parent.estado == 1){
                this.textonotificar = 'Solicitud aceptada';
                this.showAlert(1);
                this.$parent.estado = 0;
            };


        },

    }
</script>

<style scoped>
    th, td{
        text-align: center;
    }

</style>
