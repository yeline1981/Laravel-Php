<template>

    <div class="col-lg-12">

        <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Listado de Trabajos
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="id|number">ID</option>
                                    <option value="cliente|string">Cliente</option>
                                    <option value="tipotrabajo|string">Producto</option>
                                    <option value="estado|string">Estado</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarTrabajo(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" @click="listarTrabajo(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                <th >Estado</th>
                                <th >Cliente</th>
                                <th >Producto</th>
                                <th >Cantidad</th>
                                <th >Diseñar</th>
                                <th >Tercerizar</th>
                                <th >Fecha</th>
                                <th >Recepción</th>
                                <th >Hecho</th>
                                <th >Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="trabajo in arrayTrabajos" :key="trabajo.id">

                                <!--<td v-text="trabajo.id" style="font-size: 11pt" ></td>-->
                                <th  v-text="trabajo.id"></th>
                                <td  >

                                    <div v-if="trabajo.idestado == 3">
                                        <span class="badge badge-success" v-text="trabajo.estado"></span>
                                    </div>
                                    <div v-else-if="trabajo.idestado == 2">
                                        <span class="badge badge-info" v-text="trabajo.estado"></span>
                                    </div>
                                    <div v-else-if="trabajo.idestado == 5">
                                        <span class="badge badge-light" v-text="trabajo.estado"></span>
                                    </div>
                                    <div  v-else-if="trabajo.idestado == 1">
                                        <span class="badge badge-warning" v-text="trabajo.estado"></span>
                                    </div>
                                    <div  v-else-if="trabajo.idestado == 4">
                                        <span class="badge badge-primary" v-text="trabajo.estado"></span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger" v-text="trabajo.estado"></span>
                                    </div>

                                </td>

                                <td v-text="trabajo.cliente"  ></td>
                                <td v-text="trabajo.tipotrabajo" ></td>
                                <td v-text="trabajo.cantidad"  ></td>
                                <td  v-text="trabajo.diseno" ></td>
                                <td >
                                    <div v-if="trabajo.terciar == true">
                                        <span class="badge badge-primary">Si</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-light">No</span>
                                    </div>
                                </td>

                                <td v-text="trabajo.fecha"  ></td>
                                <td v-text="trabajo.vendedor"  ></td>
                                <td v-text="trabajo.hecho"  ></td>
                                <td >

                                    <button title="Ver/Editar" @click="abrirModalVer(trabajo)"  type="button" class="btn btn-info btn-sm" >
                                        <i class="icon-pencil"></i>
                                    </button>

                                    <button title="Corregir" v-if="privilegios.indexOf(role) !== -1 && trabajo.idestado === 2" @click="abrirModalCorregir(trabajo)" type="button" class="btn btn-warning btn-sm" >
                                        <i class="fas fa-cogs"></i>
                                    </button>

                                    <button title="Aprobar" v-if="privilegios.indexOf(role) !== -1 && trabajo.idestado === 2" @click="abrirModalEstado(trabajo)" type="button"  class="btn btn-success btn-sm" >
                                        <i class="fas fa-thumbs-up"></i>
                                    </button>

                                    <button title="Entregado"  v-if="trabajo.idestado === 4" @click="abrirModalEntregado(trabajo)" type="button" class="btn btn-dark btn-sm" >
                                        <i class="fas fa-check"></i>
                                    </button>

                                    <button title="Tercerizar" v-if="trabajo.terciar===false && trabajo.idestado < 4" @click="abrirModalTerciarizar(trabajo)" class="btn btn-primary btn-sm"  type="button">
                                        <i class="fa fa-truck"></i>
                                    </button>

                                    <button title="Cancelar" v-if="trabajo.idestado < 5" @click="abrirModalCancelar(trabajo)"  type="button"  class="btn btn-danger btn-sm" >
                                        <i class="icon-close"></i>
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

        </div>


        <!-- Inicio del modal Cancelar -->
        <div class="modal fade" :class="{'mostrar' : modal1}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

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
                            <p>Estas seguro de cancelar el trabajo?</p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="cancelarTrabajo()" class="btn btn-danger">Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Cancelar -->

        <!-- Inicio del modal Aprobar -->
        <div class="modal fade" :class="{'mostrar' : modal3}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

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
                            <p>{{texto}}</p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="estadoTrabajo(action)" class="btn btn-info">Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Aprobar -->

        <!-- Inicio del modal Corregir -->
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
                            <p>{{texto}}</p>

                            <div class="form-group row justify-content-center">
                                <label class="col-md-3 col-form-label" for="detalles">Observaciones</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" v-model="detalles" rows="3" placeholder="..." ></textarea>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="corregirTrabajo(action)" class="btn btn-info">Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Corregir -->

        <!-- Inicio del modal Terciarizar -->
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
</template>

<script>

import EventBus from '@/EventBus'


    export default {
      name: 'VerTrabajos',
      props:['ruta'],

      data(){
        return {

            arrayTrabajos: [],

            modal1 : 0,
            modal2 : 0,
            modal3 : 0,
            modal4 : 0,
            tituloModal: '',
            texto: '',
            id: '',
            producto: null,
            idproducto: null,
            action: null,
            detalles:null,

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
            role: '',
            privilegios: ['Administrador', 'Vendedor']

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
            listarTrabajo(page, buscar, criterio) {
                    let me = this;
                    var url= me.ruta +  '/trabajos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                    axios.get(url)
                    .then(function (response) {
                    // handle success
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayTrabajos = respuesta.trabajos.data;
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
                    me.listarTrabajo(page, buscar, criterio);
            },
            cancelarTrabajo(){
                let me = this;
                axios.put(me.ruta + '/trabajos/'+ this.id + '/cancel',{
                }).then(function (response) {
                    console.log(response);
                    me.cerrarModal();
                    me.listarTrabajo(1, '', 'nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            corregirTrabajo(item){

                let me = this;

                axios.put(me.ruta + '/trabajos/' + me.id + '/correct', {
                    'comment': me.detalles
                })
                .then(function (response) {
                    // handle success
                    console.log('Estado ok');
                    console.log(response);
                    me.modal4 = 0;

                    EventBus.$emit('Actualizado', 'Trabajo a corregir')  ;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error.response);
                });

            },
            estadoTrabajo(item){
                let me = this;

                var url = '';

                if (item == 3)
                    url = '/trabajos/' + me.id + '/check';
                else if (item == 5)
                    url = '/trabajos/' + me.id + '/deliver';

                axios.put(me.ruta + url)
                .then(function (response) {
                    // handle success
                    console.log('Estado ok');
                    console.log(response);
                    me.modal3 = 0;

                    if (item == 3)
                       EventBus.$emit('Actualizado', 'Trabajo aprobado')  ;
                    else if (item == 5)
                       EventBus.$emit('Actualizado', 'Trabajo entregado')  ;


                })
                .catch(function (error) {
                    // handle error
                    console.log(error.response);
                });
            },
            cerrarModal(){

                this.modal1 =0;
                this.modal2 =0;
                this.modal3 =0;
                this.modal4 =0;

                this.tituloModal= '';
                this.id = '';
            },
            abrirModalCancelar( data = []){
                this.modal1 = 1;
                this.tituloModal = 'Cancelar Trabajo ID:' + data.id;
                this.id = data.id;
            },
            abrirModalVer( data = []){
                console.log('Emit VerModificar');
                EventBus.$emit('VerModificar', data);
            },
            abrirModalEstado(data = []){
                this.tituloModal = 'Aprobar Trabajo ID:' + data.id;
                this.id = data.id;
                this.modal3 = 1;
                this.action = 3;
                this.texto = 'Estas seguro de aprobar el trabajo?';
            },
            abrirModalEntregado(data = []){
                this.tituloModal = 'Entregar Trabajo ID:' + data.id;
                this.id = data.id;
                this.modal3 = 1;
                this.action = 5;
                this.texto = 'Estas seguro de entregar el trabajo?';
            },
            abrirModalCorregir(data = []){
                this.tituloModal = 'Corregir Trabajo ID:' + data.id;
                this.id = data.id;
                this.modal4 = 1;
                this.action = 1;
                this.texto = 'El trabajo volverá a corrección?';
            },
            getPriv(){
                let me = this;

                axios.get(me.ruta + '/usuarios/role')
                .then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    console.log(respuesta);
                    me.role = respuesta.role;

                }).catch(function (error) {
                    console.log('Error privileg: ' + error.response);
                });
            },
            Limpiar(){
                this.criterio = 'id|number';
                this.buscar = '';
                this.listarTrabajo(1, this.buscar, this.criterio);
            },
            abrirModalTerciarizar(data = []){
                this.tituloModal = 'Terciarizar Trabajo ID:' + data.id;
                this.id = data.id;
                this.modal2 = 1;
            },
            Terciarizar(item){
                let me = this;

                axios.post(me.ruta + '/trabajos/tertiary',{
                    'id' : this.id
                }).then(function (response) {
                    console.log(response);
                    me.modal2 = 0;
                    EventBus.$emit('Actualizado', 'Trabajo tercerizado')  ;
                    me.listarTrabajo(1, '', '');
                }).catch(function (error) {
                    console.log(error.response);
                });
            },

      },
      mounted() {

      },
      created: function() {
          window.scrollTo(0,0);
          this.listarTrabajo(1, this.buscar, this.criterio);
          this.getPriv();

          EventBus.$on('Init', (item) => {
           window.scrollTo(0,0);
           this.listarTrabajo(1, this.buscar, this.criterio);
           this.getPriv();
          });

          EventBus.$on('listarTrabajo', (item) => {
             this.listarTrabajo(1, '', '');
             window.scrollTo(0,0);
          });
      }
    }
</script>

<style scoped>
    html, body
    {
        height: 100%;
    }

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


    th{
        text-align: center;
    }
    td{
        text-align: center;
    }

</style>
