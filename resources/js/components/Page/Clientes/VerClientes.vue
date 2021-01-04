<template>

    <div class="col-md-12">

        <div class="card">
                <div class="card-header">
                <i class="fa fa-align-justify"></i> Listado de Clientes
                <!--
                <div class="text-right">
                <button type="button" @click="abrirModal('cliente','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
                </div>
                -->
                </div>

                <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="id|string">Cédula/RUT</option>
                                <option value="nombre|string">Nombre</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarCliente(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" @click="listarCliente(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                    &nbsp;
                    <button type="button" @click="Limpiar()" class="btn btn-light btn-sm" >
                            <i class="fa fa-eraser"></i>
                    </button>
                </div>

                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th style="text-align: center">Cédula/RUT</th>
                        <th style="text-align: center">Nombre y Apellidos</th>

                        <th style="text-align: center">Teléfono</th>

                        <th style="text-align: center">Email</th>

                        <th style="text-align: center">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="cliente in arrayCliente" :key="cliente.idcliente">

                        <td style="text-align: center" v-text="cliente.id"></td>
                        <td style="text-align: center" v-text="cliente.nombre"></td>

                        <td style="text-align: center" v-text="cliente.telefono"></td>

                        <td style="text-align: center" v-text="cliente.email"></td>

                        <td style="text-align: center">
                            <button type="button" title="Editar" @click="abrirModal(cliente)" class="btn btn-warning btn-sm">
                            <i class="icon-pencil"></i>
                            </button> &nbsp;
                            <button type="button" title="Eliminar" @click="abrirModalEliminar(cliente)" class="btn btn-danger btn-sm">
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

        <!-- Inicio del modal Eliminar -->
            <div class="modal fade" :class="{'mostrar' : modal1}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <p>Estas seguro de eliminar el cliente?</p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" @click="eliminarCliente()" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->

        <!-- Inicio del modal Confirmar -->
        <div class="modal fade" :class="{'mostrar' : showConfirm}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <p>Estás seguro de eliminar la imagen?</p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cancelDeleting()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="DeleteImagen()" class="btn btn-danger">Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>


</template>

<script>

import EventBus from "@/EventBus.js";

    export default {
      name: 'VerClientes',
      props : ['ruta'] ,
      data(){
        return {

            arrayCliente: [],
            id: null,

            modal1 : 0,

            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            criterio : 'nombre|string',
            buscar: '',
            texto: '',
            ok : 0,
            errorMostrarMsjcliente : [],
            showalert: 0,
            dismissCountDown: 5,
            tituloModal : '',
            showConfirm : 0,

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
          listarCliente(page, buscar, criterio) {
                let me = this;
                var url= me.ruta +  '/clientes?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url)
                .then(function (response) {
                  // handle success
                   console.log(response);
                   var respuesta= response.data;

                   me.arrayCliente = respuesta.clientes.data;
                   me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                  // handle error
                  console.log(error.response);
                });

          },
          cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarCliente(page, buscar, criterio);
          },
          eliminarCliente(){

                let me = this;

                axios.put(me.ruta + '/clientes/eliminar',{
                    'id' : this.id
                }).then(function (response) {
                    console.log(response);
                    me.modal1 = 0;
                    me.listarCliente(1, '', '');
                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            abrirModal(data = []){
                this.$parent.modo = 0;
                EventBus.$emit('VerClientes', data) ;

            },
            abrirModalEliminar( data = []){

                this.modal1 = 1;
                this.id = data.id;
                this.tituloModal = 'Eliminar cliente: ' + data.id;

            },
            Limpiar(){
                this.criterio = 'razon_social|string';
                this.buscar = '';
                this.listarCliente(1, this.buscar, this.criterio);
            }
      },
      mounted() {


      },
      created: function() {
           window.scrollTo(0,0);

           this.ruta = this.$parent.ruta;
           this.listarCliente(1, this.buscar, this.criterio);


          EventBus.$on('ListarClientes', (item) => {
             this.listarCliente(1, this.buscar, this.criterio);
             window.scrollTo(0,0);
          });
      }

    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #3c29297a !important;
    }



</style>
