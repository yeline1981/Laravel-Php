<template>
    <main class="main">

        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">

                <div class="card">
                  <div class="card-header">
                    <i class="fa fa-align-justify"></i> Listado de Usuarios
                  </div>
                  <div class="card-body">

                    <div class="form-group row">
                        <div class="col-md-8">
                            <div class="input-group">
                                <select class="form-control col-md-4" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="login">Nombre de usuario</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarUsuario(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" @click="listarUsuario(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                        &nbsp;
                        <button type="button" @click="Limpiar()" class="btn btn-light btn-sm" >
                                <i class="fa fa-eraser"></i>
                        </button>
                    </div>

                    <table class="table table-responsive-sm table-bordered table-striped table-sm">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Nombre de Usuario</th>
                          <th>Privilegio</th>
                          <!--<th>Estado</th>-->
                          <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="usuario in arrayUsuario" :key="usuario.id">
                          <td v-text="usuario.nombre"></td>
                          <td v-text="usuario.login"></td>
                          <td v-text="usuario.role"></td>
                          <!--
                          <td >
                            <div v-if="usuario.estado">
                                <span class="badge badge-success">Activo</span>
                            </div>
                            <div v-else>
                                <span class="badge badge-danger">Desactivado</span>
                            </div>
                          </td>
                          -->
                          <td>
                              &nbsp;
                             <button type="button" title="Actualizar" @click="abrirModal(usuario)" class="btn btn-warning btn-sm" >
                                <i class="icon-pencil"></i>
                              </button> &nbsp;
                              <button type="button" title="Cambiar Contraseña" @click="abrirModalPassw(usuario)" class="btn btn-primary btn-sm" >
                                <i class="icon-lock-open"></i>
                              </button> &nbsp;
                              <button type="button" title="Eliminar" @click="abrirModalEliminar(usuario)" class="btn btn-danger btn-sm">
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
                </div>

        </div>

        <!--Inicio del modal actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" disabled="disabled" v-model="nombre">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre de Usuario</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="login" class="form-control" disabled="disabled">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Privilegio</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idpriv" >
                                            <option value='Vendedor'>Vendedor</option>
                                            <option value='Diseñador'>Diseñador</option>
                                            <option value='Administrador'>Administrador</option>
                                        </select>
                                    </div>
                                </div>

                                <!--
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="checkbox">Activo</label>
                                     <div class="form-check form-check-inline mr-1">

                                        <div v-if="estado">
                                            <input class="form-check-input" v-model="estado" type="checkbox" onchange="$('#form').submit();" checked>
                                        </div>
                                        <div v-else>
                                            <input class="form-check-input" v-model="estado" type="checkbox" onchange="$('#form').submit();">
                                        </div>

                                     </div>
                                </div>
                                -->

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="actualizarUsuario()" class="btn btn-primary" >Actualizar</button>
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" >Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!-- Inicio del modal Eliminar -->
            <div class="modal fade" :class="{'mostrar' : modal2}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

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
                                <p>Estas seguro de eliminar el usuario?</p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" @click="eliminarUsuario()" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->

            <!-- Inicio del modal Password -->
            <div class="modal fade" :class="{'mostrar' : modal3}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nueva contraseña</label>
                                <div class="col-md-9">
                                    <input type="password" v-model="newpassword" class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Confirmar contraseña</label>
                                <div class="col-md-9">
                                    <input type="password" v-model="confirmacion" class="form-control"  >
                                </div>
                            </div>

                            <div v-show="errorpasswd" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsj" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" @click="modificarPasswd()" class="btn btn-danger">Aceptar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Password -->

      </main>
</template>

<script>
    import Notifications from "@/components/Layouts/Notifications";
    import Base from "@/components/Layouts/Base";

    export default {
        props : ['ruta'] ,
        extends: Base,
        components: {
                'notification-component': Notifications
        },
        data(){
            return {
                id: '',
                nombre : '',
                login: '',
                idpriv: '',

                confirmacion: '',
                newpassword : '',
                estado: '',
                arrayUsuario: [],

                modal1 : 0,
                modal2 : 0,
                modal3: 0,
                tituloModal : '',
                texto: '',

                errorpasswd : 0,

                pagination : {
                        'total' : 0,
                        'current_page' : 0,
                        'per_page' : 0,
                        'last_page' : 0,
                        'from' : 0,
                        'to' : 0,
                    },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
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
            listarUsuario (page,buscar,criterio){
                let me=this;

                var url= me.ruta +  '/usuarios?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {

                    var respuesta= response.data;
                    me.arrayUsuario = respuesta.usuarios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarUsuario(page,buscar,criterio);
            },
            actualizarUsuario(){

                let me = this;

                axios.put(me.ruta + '/usuarios/actualizar',{
                    'id' : this.id,
                    'role': this.idpriv,
                    //'estado' : this.estado

                }).then(function (response) {
                    console.log(response);
                    me.textonotificar = 'Usuario actualizado.';
                    me.showAlert(1);
                    me.cerrarModal();
                    me.listarUsuario(1,'','nombre');

                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            eliminarUsuario(){

                let me = this;

                axios.put(me.ruta + '/usuarios/eliminar',{
                    'id' : this.id
                }).then(function (response) {
                    console.log(response);
                    me.textonotificar = 'Usuario eliminado.';
                    me.showAlert(1);
                    me.cerrarModal();
                    me.listarUsuario(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            modificarPasswd(){
                this.errorMostrarMsj = [];

                if (this.newpassword != this.confirmacion) {
                    this.errorMostrarMsj.push("Introduzca nuevamente la contraseña y su confirmación.");
                    this.errorpasswd = 1;
                    return;
                }

                let me = this;

                axios.put(me.ruta + '/usuarios/actualizar/password',{
                    'id' : this.id ,
                    'newpassword' : this.newpassword

                }).then(function (response) {
                    console.log(response);
                    me.textonotificar = 'Contraseña actualizada.';
                    me.cerrarModal();
                    me.showAlert(1);
                    me.listarUsuario(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });

            },
            cerrarModal(){

                this.modal1=0;
                this.modal2=0;
                this.modal3=0;

                this.tituloModal='';
                this.nombre='';
                this.login='';
                this.idpriv = '';
                this.estado = '';
                this.id = '';
                //this.password = '';

                this.errorpasswd = 0;
                this.errorMostrarMsj = [];
            },

            abrirModal(data = []){

                    this.modal1 = 1;
                    this.tituloModal = 'Actualizar usuario ' ;

                    this.nombre= data.nombre;
                    this.login = data.login;
                    this.idpriv = data.role;
                    this.estado = data.estado;
                    this.id = data.id;

            },
            abrirModalEliminar( data = []){
                this.modal2 = 1;
                this.id = data.id;
                this.tituloModal = 'Eliminar usuario ' + data.nombre;

            },
            abrirModalPassw( data = []){
                this.modal3 = 1;
                this.id = data.id;
                this.tituloModal = 'Modificar contraseña del usuario ' + data.nombre;
                //this.password = data.password;
                this.errorpasswd = 0;

            },
            Limpiar(){
                this.criterio = 'nombre';
                this.buscar = '';
                this.listarUsuario(1, this.buscar, this.criterio);
            }
      },
      mounted() {
          this.listarUsuario(1, this.buscar, this.criterio);
      }
    }
</script>

<style scoded>
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
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }

</style>
