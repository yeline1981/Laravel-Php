<template>
    <main class="main">
        <!-- Breadcrumb-->

        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                     Nuevo Usuario</div>
                  <div class="card-body">

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Nombre y Apellidos</label>
                        <div class="col-md-9">
                          <input class="form-control" type="text" v-model="nombre">

                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Nombre de usuario</label>
                        <div class="col-md-9">
                          <input class="form-control" type="text" v-model="login" >

                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="password-input">Contraseña</label>
                        <div class="col-md-9">
                          <input class="form-control" type="password" v-model="password" >

                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="password-input">Confirmar Contraseña</label>
                        <div class="col-md-9">
                          <input class="form-control" type="password" v-model="confirmacion">

                        </div>
                      </div>


                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="idpriv">Privilegio</label>
                        <div class="col-md-9">
                          <select class="form-control" v-model="idpriv">
                            <option value='Vendedor'>Vendedor</option>
                            <option value='Diseñador'>Diseñador</option>
                            <option value='Administrador'>Administrador</option>

                          </select>
                        </div>
                      </div>

                    </form>
                  </div>
                   <div class="card-footer">
                      <div class="float-right">
                      <button class="btn btn-sm btn-danger" @click="Cancelar()" type="reset">
                        <i class="fa fa-ban"></i> Cancelar</button>
                      <button class="btn btn-sm btn-primary" @click="crearUsuario()" type="button">
                        <i class="fa fa-dot-circle-o"></i> Crear</button>

                      </div>
                    </div>
                </div>

              </div>

            </div>
            <!-- /.row-->
          </div>
        </div>

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
            nombre : '',
            login: '',
            password: '',
            idpriv: '',
            confirmacion : '',
            errorusuario : 0,

        }
      },
      methods: {
        validarUsuario(){

                var ret = 0;

                this.errorMostrarMsj =[];

                if (!this.login) this.errorMostrarMsj.push("El nombre de usuario no puede estar vacío.");

                if (!this.nombre) this.errorMostrarMsj.push("El nombre no puede estar vacío.");

                if (this.password != this.confirmacion) this.errorMostrarMsj.push("Su contraseña y la confirmación son diferentes.");

                if (this.errorMostrarMsj.length) ret = 1;

                return ret;
            },

        crearUsuario(){
                if (this.validarUsuario()){
                    this.showAlert(2);
                    return;
                }

                let me = this;

                axios.post(me.ruta + '/usuarios/registrar',{
                    'nombre': this.nombre,
                    'role': this.idpriv,
                    'login' : this.login,
                    'password' : this.password
                }).then(function (response) {
                    console.log(response);
                    me.Limpiar();
                    me.textonotificar = 'Usuario creado satisfactoriamente';
                    me.showAlert(1);
                }).catch(function (error) {
                    console.log(error.response);
                    me.showAlert(2);
                });
            },
          Cancelar(){
            this.Limpiar();
            window.location.href = this.ruta + '/main';
          },
          Limpiar(){
            this.nombre='';
            this.login='';
            this.idpriv = '';
            this.password = '';
            this.confirmacion = '';
          }

      },
      mounted() {
          console.log('Component mounted.');
      }

    }
</script>


